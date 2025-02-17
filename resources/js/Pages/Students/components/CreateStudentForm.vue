<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const form = useForm({
  first_name: '',
  last_name: '',
  github_username: '',
  course_id: ''
})

// Get courses information
const page = usePage()
const courses = page.props.courses

// Get current course if on the course page
const courseUrlParam = page.url.split('/')[2]
const currentCourse = courses.find(course => course.id === courseUrlParam)

if (currentCourse) {
  form.course_id = currentCourse.id
}

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
        <label for="last_name" class="visually-hidden">
          {{ $t('students.field.last_name') }}
        </label>
        <input
          type="text"
          id="last_name"
          class="form-control"
          v-model="form.last_name"
          :placeholder="$t('students.field.last_name')"
        />
      </div>

      <div class="col-12 col-sm-6 col-xxl-3 my-3">
        <label for="first_name" class="visually-hidden">
          {{ $t('students.field.first_name') }}
        </label>
        <input
          type="text"
          id="first_name"
          class="form-control"
          v-model="form.first_name"
          :placeholder="$t('students.field.first_name')"
        />
      </div>

      <div class="col-12 col-sm-6 col-xxl-3 my-3">
        <label for="github_username" class="visually-hidden">
          {{ $t('students.field.github_username') }}
        </label>
        <input
          type="text"
          id="github_username"
          class="form-control"
          v-model="form.github_username"
          :placeholder="$t('students.field.github_username')"
        />
      </div>

      <div class="col-12 col-sm-6 col-xxl-2 my-3">
        <label for="course_id" class="visually-hidden">
          {{ $t('students.field.course') }}
        </label>
        <select id="course_id" class="form-select" v-model="form.course_id">
          <option value="" disabled>
            {{ $t('students.field.course_select') }}
          </option>
          <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.name }}</option>
        </select>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          {{ $t('students.submit') }}
        </button>
      </div>
    </div>

    <ul v-if="form.errors">
      <li v-for="error in form.errors" :key="error" class="text-danger">{{ error }}</li>
    </ul>
  </form>
</template>
