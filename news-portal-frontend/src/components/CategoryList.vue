<template>
  <div>
    <h4>Categories</h4>
    <ul>
      <li v-for="c in categories" :key="c.id">
        <a href="#" @click.prevent="$emit('select', c.slug)">{{ c.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/axios';
const categories = ref([]);
onMounted(async () => {
  const res = await api.get('/categories');
  categories.value = res.data;
});
</script>
