<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({ student: Object })

const form = useForm(props.student)

const page = usePage()
const courses = page.props.courses

const editStudent = (id) => {
  form.put(`/students/${id}`)
}
</script>

<template>
  <form @submit.prevent="editStudent(student.id)">
    <div class="mb-3">
      <label for="first_name" class="form-label">First Name</label>
      <input type="text" class="form-control" id="first_name" v-model="form.first_name">
      <span v-if="form.errors.first_name" class="text-danger">{{ form.errors.first_name }}</span>
    </div>

    <div class="mb-3">
      <label for="last_name" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="last_name" v-model="form.last_name">
      <span v-if="form.errors.last_name" class="text-danger">{{ form.errors.last_name }}</span>
    </div>

    <div class="mb-3">
      <label for="github_username" class="form-label">Github</label>
      <input type="text" class="form-control" id="github_username" v-model="form.github_username">
      <span v-if="form.errors.github_username" class="text-danger">{{ form.errors.github_username }}</span>
    </div>

    <div class="mb-3">
      <label for="course_id" class="form-label">Course</label>
      <select id="course_id" class="form-select" v-model="form.course_id">
        <option value="" disabled>Select a course</option>
        <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.name }}</option>
      </select>
      <span v-if="form.errors.course_id" class="text-danger">{{ form.errors.course_id }}</span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>
