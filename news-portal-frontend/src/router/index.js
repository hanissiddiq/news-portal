import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import NewsDetail from '../views/NewsDetail.vue';
import NewsForm from '../views/NewsForm.vue';
const routes = [
  { path: '/', component: Home, name: 'home' },
  { path: '/login', component: Login, name: 'login' },
  { path: '/register', component: Register, name: 'register' },
  { path: '/news/create', component: NewsForm, name: 'news.create' },
  { path: '/news/:id', component: NewsDetail, name: 'news.show', props: true }
];
const router = createRouter({ history: createWebHistory(), routes });
export default router;
