<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({ exercise: Object })
const courses = usePage().props.courses

const form = useForm({
  ...props.exercise,
  courses: props.exercise.courses.map(course => course.id),
})

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
      <span v-if="form.errors.path" class="text-danger">{{ form.errors.path }}</span>
    </div>

    <div class="mb-3">
      <label for="courses" class="form-label">Courses:</label>
      <ul class="list-group">
        <li v-for="course in courses" :key="course.id" class="list-group-item">
          <input type="checkbox" :value="course.id" v-model="form.courses" class="form-check-input" :id="`checkbox-${course.id}`">
          <label class="form-check-label ms-2" :for="`checkbox-${course.id}`">{{ course.name }}</label>
        </li>
      </ul>
      <span v-if="form.errors.courses" class="text-danger">{{ form.errors.courses }}</span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>