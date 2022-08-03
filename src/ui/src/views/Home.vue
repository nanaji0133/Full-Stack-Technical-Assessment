<script setup>
import Header from "./../components/Header.vue";
import { useRouter } from "vue-router";
const router = useRouter();
// redirecting if not logged in
if (!sessionStorage.getItem("api_token")) {
  router.push("/login");
}
</script>

<template>
  <Header />
  <div>
    <h3>Scrawlr Hiring Assessment</h3>
  </div>
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
