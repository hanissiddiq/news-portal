<template>
  <div>
    <h1>News Portal</h1>
    <CategoryList @select="onCategory" />
    <div v-for="item in news" :key="item.id" class="card">
      <h3><router-link :to="{name:'news.show', params:{id:item.id}}">{{ item.title }}</router-link></h3>
      <p>{{ item.excerpt }}</p>
      <small>By {{ item.author.name }} | Category: {{ item.category.name }}</small>
      <div v-if="item.image"><img :src="imageUrl(item.image)" style="max-width:200px" /></div>
    </div>
    <button v-if="nextPage" @click="loadMore">Load more</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/axios';
import CategoryList from '../components/CategoryList.vue';

const news = ref([]);
const page = ref(1);
const nextPage = ref(true);
const categoryFilter = ref(null);

const load = async () => {
  const params = { page: page.value };
  if(categoryFilter.value) params.category = categoryFilter.value;
  const res = await api.get('/news', { params });
  if(page.value === 1) news.value = res.data.data;
  else news.value.push(...res.data.data);
  nextPage.value = res.data.next_page_url !== null;
};
onMounted(load);
const loadMore = async () => { page.value++; await load(); };
const onCategory = (slug) => { categoryFilter.value = slug; page.value = 1; load(); };
const imageUrl = (path) => path ? `http://localhost:8000/storage/${path}` : null;
</script>
