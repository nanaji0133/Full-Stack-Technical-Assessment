<script setup>
import { ref } from "vue";
import { inject } from "vue";
import Header from "./../components/Header.vue";

const axios = inject("axios");
const username = ref("");
const password_hash = ref("");
const message = ref("");
function onSubmit(e) {
  e.preventDefault();
  message.value =
    username.value == "" || password_hash.value == ""
      ? "Please check provided details"
      : "";

  function login() {
    const data = {
      username: username.value,
      password_hash: password_hash.value,
    };
    axios
      .post("http://localhost:8080/user/login", data)
      .then(({ data }) => {
        // set api_token into session storage to authenticate remaining routes and save username aswell
        console.log(data);
        sessionStorage.setItem("api_token", data.api_token);
        sessionStorage.setItem("username", data.user.username);
      })
      .catch((error) => {
        console.log(error.response);
        message.value = "Please check provided details";
      });
  }
  // validation
  if (username.value != "" && password_hash.value != "") {
    login();
  }
}
</script>

<template>
  <Header />
  <div class="login-container">
    <form @submit="onSubmit">
      <div class="form-group">
        <label for="usernameInput">Username</label>
        <input
          type="text"
          class="form-control"
          v-model="username"
          name="username"
          id="usernameInput"
          aria-describedby="emailHelp"
          placeholder="Enter Username"
        />
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input
          type="password"
          v-model="password_hash"
          name="password_hash"
          class="form-control"
          id="exampleInputPassword1"
          placeholder="Password"
        />
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
      <div class="alert-message">{{ message }}</div>
    </form>
  </div>
</template>

<style scoped>
.form-group {
  margin-top: 10px;
}
input {
  width: 30vw;
}
.login-container {
  display: flex;
  justify-content: center;
}
.alert-message {
  color: red;
  padding-top: 10px;
}
</style>
