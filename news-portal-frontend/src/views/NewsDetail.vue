<template>
  <div v-if="news">
    <h2>{{ news.title }}</h2>
    <div>By {{ news.author.name }} | Category: {{ news.category.name }}</div>
    <img v-if="news.image" :src="imageUrl(news.image)" style="max-width:500px" />
    <div v-html="news.body"></div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/axios';
import { useRoute } from 'vue-router';
const route = useRoute();
const news = ref(null);
onMounted(async () => {
  const res = await api.get(`/news/${route.params.id}`);
  news.value = res.data;
});
const imageUrl = (path) => path ? `http://localhost:8000/storage/${path}` : null;
</script>
