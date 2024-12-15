<script setup>
import { useForm, usePage } from '@inertiajs/vue3';


const form = useForm({
  first_name: '',
  last_name: '',
  githubUsername: '',
  course_id: ''
})

// Get courses information
const page = usePage()
const courses = page.props.courses

function submit() {
  form.post('/students', {
    onSuccess: () => form.reset()
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <div class="row g-2">
      <div class="col-12 col-sm-6 col-xxl-3 my-3">
        <label for="last_name" class="visually-hidden">Last Name</label>
        <input type="text" id="last_name" class="form-control" v-model="form.last_name" placeholder="Last Name"/>
      </div>

      <div class="col-12 col-sm-6 col-xxl-3 my-3">
        <label for="first_name" class="visually-hidden">First Name</label>
        <input type="text" id="first_name" class="form-control" v-model="form.first_name" placeholder="First Name" />
      </div>

      <div class="col-12 col-sm-6 col-xxl-3 my-3">
        <label for="githubUsername" class="visually-hidden">Github</label>
        <input type="text" id="githubUsername" class="form-control" v-model="form.githubUsername" placeholder="Github" />
      </div>

      <div class="col-12 col-sm-6 col-xxl-2 my-3">
        <label for="course_id" class="visually-hidden">Course</label>
        <select id="course_id" class="form-select" v-model="form.course_id">
          <option value="" disabled>Select a course</option>
          <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.name }}</option>
        </select>
      </div>

      <div class="col-12 col-xxl-1 my-lg-3 d-flex">
        <button type="submit" class="btn btn-primary text-white w-variant">
          <i class="ri-add-line"></i>
          <span class="d-inline d-lg-none">Submit</span>
        </button>
      </div>
    </div>

    <span v-if="form.errors.last_name" class="text-danger">{{ form.errors.last_name }}</span>
    <span v-if="form.errors.first_name" class="text-danger">{{ form.errors.first_name }}</span>
    <span v-if="form.errors.githubUsername" class="text-danger">{{ form.errors.githubUsername }}</span>
    <span v-if="form.errors.course_id" class="text-danger">{{ form.errors.course_id }}</span>
  </form>
</template>

<style scoped>
@media (max-width: 1398px) {
  .w-variant {
    width: 100%;
  }
}
</style>
