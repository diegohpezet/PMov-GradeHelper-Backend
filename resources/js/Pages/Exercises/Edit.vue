<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ exercise: Object })

const form = useForm(props.exercise)

const editExercise = (id) => {
  form.put(`/exercises/${id}`)
}
</script>

<template>
  <form @submit.prevent="editExercise(exercise.id)">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" v-model="form.title">
      <span v-if="form.errors.title" class="text-danger">{{ form.errors.title }}</span>
    </div>

    <div class="mb-3">
      <label for="path" class="form-label">Path</label>
      <input type="text" class="form-control" id="path" v-model="form.path">
      <span v-if="form.errors.path" class="text-danger">{{ form.errors.path }}"></span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>