<script setup>
import { useRouter } from "vue-router";
const router = useRouter();
const isLoggedIn = sessionStorage.getItem("api_token") ? true : false;
function logout() {
  console.log("loggedout");
  sessionStorage.removeItem("api_token");
  router.push("/login");
}
</script>

<template>
  <!-- rotuing links and show path only if logged in -->
  <nav class="navbar navbar-dark bg-dark">
    <!-- Navbar content -->
    <router-link class="px-3" to="/" v-if="isLoggedIn">Home</router-link> |
    <router-link class="px-3" to="/signup">Signup</router-link> |
    <router-link class="px-3" to="/login">Login</router-link> |
    <router-link class="px-3" to="/todonotes" v-if="isLoggedIn"
      >TODO Notes</router-link
    >
    |
    <!-- Should only show if still logged in -->
    <a href="#" @click="logout" v-if="isLoggedIn">Logout</a>
  </nav>
</template>

<style scoped>
nav {
  justify-content: end;
  height: 6vh;
}
</style>
