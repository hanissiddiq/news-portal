<template>
  <div>
    <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/news/create">Create</router-link> |
      <router-link to="/login">Login</router-link> |
      <router-link to="/register">Register</router-link>
    </nav>
    <router-view />
  </div>
</template>
