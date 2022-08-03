<script setup>
import { inject } from "vue";
import { ref } from "vue";
import TodoNote from "./../components/TodoNote.vue";
import Header from "./../components/Header.vue";
import { useRouter } from "vue-router";

const axios = inject("axios");
const title = ref("");
const note = ref("");
const message = ref("");
const todoNotesdata = ref([]);
const router = useRouter();

// redirecting if not logged in
if (!sessionStorage.getItem("api_token")) {
  router.push("/login");
}
// submit handler
function onSubmit(e) {
  e.preventDefault();

  function login() {
    const data = {
      title: title.value,
      note: note.value,
      api_token: sessionStorage.getItem("api_token"),
    };
    axios
      .post("http://localhost:8080/todonotes/create", data)
      .then(({ data }) => {})
      .catch((error) => {
        console.log(error.response);
        message.value = "Please check provided details";
      });
  }
  // validation
  if (title.value != "" && note.value != "") {
    login();
  }
}

function updateDone(id) {
  axios
    .post(`http://localhost:8080/todonotes/mark/done/${id}`, {
      api_token: sessionStorage.getItem("api_token"),
    })
    .then(({ data }) => {})
    .catch((error) => {
      console.log(error.response);
      message.value = "Please check provided details";
    });
}

function updatePending(id) {
  axios
    .post(`http://localhost:8080/todonotes/mark/pending/${id}`, {
      api_token: sessionStorage.getItem("api_token"),
    })
    .then(({ data }) => {})
    .catch((error) => {
      console.log(error.response);
      message.value = "Please check provided details";
    });
}

// Fetch todonote details

axios
  .get("http://localhost:8080/todonotes", {
    params: {
      api_token: sessionStorage.getItem("api_token"),
    },
  })
  .then(({ data }) => {
    todoNotesdata.value = data.notes;
  })
  .catch((error) => console.log(error));
</script>

<template>
  <Header />
  <div class="todoNotes-container">
    <!-- Following form is to create a notes -->
    <form @submit="onSubmit" class="add-form mb-4">
      <div class="form-group">
        <label>Title</label>
        <input
          type="text"
          v-model="title"
          name="title"
          placeholder="title"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label>Note</label>
        <input
          type="text"
          v-model="note"
          name="note"
          placeholder="note"
          class="form-control"
        />
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <!-- below code describes about fetching todo notes data -->
    <div
      :key="todoNotedata.id"
      v-for="todoNotedata in todoNotesdata"
      class="todoNote-container"
    >
      <TodoNote
        :todoNotedata="todoNotedata"
        @update-done="updateDone"
        @update-pending="updatePending"
      />
    </div>
  </div>
</template>

<style scoped>
.todoNotes-container {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.todoNote-container {
  display: flex;
  justify-content: center;
  background-color: azure;
  width: 50vh;
  border: 2px solid rgb(168, 163, 163);
}
</style>
