<template>
  <div>
    <h2>Create News</h2>
    <form @submit.prevent="submit">
      <input v-model="form.title" placeholder="Title" required />
      <select v-model="form.category_id" required>
        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
      </select>
      <input v-model="form.excerpt" placeholder="Excerpt" />
      <textarea v-model="form.body" placeholder="Body" required></textarea>
      <input type="file" @change="onFile" />
      <button>Create</button>
    </form>
    <div v-if="error">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/axios';
import { useRouter } from 'vue-router';
const router = useRouter();
const categories = ref([]);
onMounted(async () => { const res = await api.get('/categories'); categories.value = res.data; });
const form = ref({ title:'', category_id:'', excerpt:'', body:'' });
let file = null;
const error = ref(null);

const onFile = (e) => { file = e.target.files[0]; };

const submit = async () => {
  try{
    const fd = new FormData();
    fd.append('title', form.value.title);
    fd.append('category_id', form.value.category_id);
    fd.append('excerpt', form.value.excerpt);
    fd.append('body', form.value.body);
    if(file) fd.append('image', file);
    const res = await api.post('/news', fd, { headers: { 'Content-Type': 'multipart/form-data' }});
    router.push({ name: 'news.show', params: { id: res.data.id }});
  }catch(e){ error.value = e.response?.data?.message || 'Failed'; }
};
</script>
