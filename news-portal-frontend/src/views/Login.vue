<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="submit">
      <input v-model="email" placeholder="email" />
      <input v-model="password" type="password" placeholder="password" />
      <button>Login</button>
    </form>
    <div v-if="error">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from '../composables/useAuth';
const { login, fetchMe } = useAuth();
const router = useRouter();
const email = ref('admin@example.com');
const password = ref('password');
const error = ref(null);

const submit = async () => {
  try{
    await login(email.value, password.value);
    await fetchMe();
    router.push({ name: 'home' });
  }catch(e){
    error.value = e.response?.data?.message || 'Login failed';
  }
};
</script>
