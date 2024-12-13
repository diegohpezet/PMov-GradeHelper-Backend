<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ grade: Object })

const form = useForm(props.grade)

const editGrade = (gradeId) => {
  form.put(`/grades/${gradeId}`)
}
</script>

<template>
  <h1>Edit grade</h1>

  <form @submit.prevent="editGrade(grade.id)">
    <div class="mb-3">
      <label for="score" class="form-label">Score</label>
      <input type="number" class="form-control" id="score" v-model="form.score">
      <span v-if="form.errors.score" class="text-danger">{{ form.errors.score }}</span>
    </div>

    <div class="mb-3">
      <label for="comment" class="form-label">Comment</label>
      <input type="text" class="form-control" id="comment" v-model="form.comment">
      <span v-if="form.errors.comment" class="text-danger">{{ form.errors.comment }}</span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>