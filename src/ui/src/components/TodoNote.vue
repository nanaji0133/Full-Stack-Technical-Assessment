<script setup>
const props = defineProps({
  todoNotedata: Array,
});
</script>

<template>
  <div class="todoNotes-container">
    <h4>Title: {{ todoNotedata.title }}</h4>
    <p>Note: {{ todoNotedata.note }}</p>
    <p v-if="todoNotedata.completed_at">
      Completed at: {{ todoNotedata.completed_at }}
    </p>
    <p>
      Update as:
      <span @click="$emit('update-done', todoNotedata.id)">Done | </span>
      <span @click="$emit('update-pending', todoNotedata.id)">Pending</span>
    </p>
  </div>
</template>

<style scoped>
span {
  color: blue;
}
</style>
