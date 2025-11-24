<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="submit">
      <input v-model="name" placeholder="name" />
      <input v-model="email" placeholder="email" />
      <input v-model="password" type="password" placeholder="password" />
      <input v-model="password_confirmation" type="password" placeholder="confirm password" />
      <button>Register</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from '../composables/useAuth';
const { register, fetchMe } = useAuth();
const router = useRouter();
const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const submit = async () => {
  await register({ name: name.value, email: email.value, password: password.value, password_confirmation: password_confirmation.value });
  await fetchMe();
  router.push({ name: 'home' });
};
</script>
