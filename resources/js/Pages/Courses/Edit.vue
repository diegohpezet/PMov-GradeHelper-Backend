<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ course: Object })

const form = useForm(props.course)

const editCourse = (id) => {
  form.put(`/courses/${id}`)
}
</script>

<template>
  <form @submit.prevent="editCourse(course.id)">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" v-model="form.name">
    </div>

    <div class="mb-3">
      <label for="school_year" class="form-label">School year</label>
      <input type="text" class="form-control" id="school_year" v-model="form.school_year">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    
  </form>
</template>