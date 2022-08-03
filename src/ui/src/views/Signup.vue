<script setup>
import { ref } from "vue";
import { inject } from "vue";
import { useRouter } from "vue-router";
import Header from "./../components/Header.vue";

const axios = inject("axios");
const username = ref("");
const router = useRouter();

const email = ref("");
const password_hash = ref("");
const confirm_password = ref("");
const message = ref("");
function onSubmit(e) {
  e.preventDefault();
  message.value =
    username.value == "" ||
    email.value == "" ||
    password_hash.value == "" ||
    confirm_password.value == "" ||
    confirm_password.value != password_hash.value
      ? "Please check provided details"
      : "";

  function signup() {
    const data = {
      username: username.value,
      password_hash: password_hash.value,
      email: email.value,
    };
    axios
      .post("http://localhost:8080/user/signup", data)
      .then(({ data }) => {
        // set api_token into session storage to authenticate remaining routes
        sessionStorage.setItem("api_token", data.api_token);
        router.push("/");
      })
      .catch((error) => console.log(error.response));
  }
  //   validation
  if (
    username.value != "" &&
    email.value != "" &&
    password_hash.value != "" &&
    confirm_password.value == password_hash.value
  ) {
    signup();
  }
}
</script>

// Sign up form, if request and details are correct redirect to Homne/todonotes page
// Validation alert message if details not filled or wrong details
<template>
  <Header />
  <div class="singup-container">
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
        <label for="exampleInputEmail1">Email address</label>
        <input
          type="email"
          v-model="email"
          name="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Enter email"
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
      <div class="form-group">
        <label for="confirmInputPassword1">Confirm Password</label>
        <input
          type="password"
          v-model="confirm_password"
          name="confirm_password"
          class="form-control"
          id="confirmInputPassword1"
          placeholder="Confirm Password"
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
.singup-container {
  display: flex;
  justify-content: center;
}
.alert-message {
  color: red;
  padding-top: 10px;
}
</style>
