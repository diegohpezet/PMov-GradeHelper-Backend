<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  school_year: new Date().getFullYear()
})

function submit() {
  form.post('/courses', {
    onSuccess: () => form.reset()
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <div class="row g-2">
      <div class="col-12 col-sm-6 col-lg-4 col-xxl-3 my-3">
        <label for="name" class="visually-hidden">Name</label>
        <input type="text" id="name" class="form-control" v-model="form.name" placeholder="Name"/>
      </div>

      <div class="col-12 col-sm-6 col-lg-4 col-xxl-3 my-3">
        <label for="school_year" class="visually-hidden">School year</label>
        <input type="text" id="school_year" class="form-control" v-model="form.school_year" placeholder="School Year" />
      </div>

      <div class="col-12 col-lg-1 my-lg-3 d-flex">
        <button type="submit" class="btn btn-primary text-white w-variant">
          <i class="ri-add-line"></i>
          <span class="d-inline d-lg-none">Submit</span>
        </button>
      </div>
    </div>

    <ul v-if="form.errors">
      <li v-for="error in form.errors" :key="error" class="text-danger">{{ error }}</li>
    </ul>
  </form>
</template>

<style scoped>
@media (max-width: 992px) {
  .w-variant {
    width: 100%;
  }
}
</style>
