<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  path: '',
});

function submit() {
  form.post('/exercises', {
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <div class="row g-2">
      <div class="col-12 col-sm-6 col-lg-4 col-xxl-3 my-3">
        <label for="title" class="visually-hidden">Title</label>
        <input
          id="title"
          v-model="form.title"
          type="text"
          class="form-control"
          placeholder="Title"
        />
      </div>

      <div class="col-12 col-sm-6 col-lg-4 col-xxl-3 my-3">
        <label for="path" class="visually-hidden">Path</label>
        <input
          id="path"
          v-model="form.path"
          type="text"
          class="form-control"
          placeholder="Path"
        />
      </div>

      <div class="col-12 col-lg-1 my-lg-3 d-flex">
        <button type="submit" class="btn btn-primary text-white w-variant">
          <i class="ri-add-line"></i>
          <span class="d-inline d-lg-none">Submit</span>
        </button>
      </div>
    </div>

    <ul v-if="form.errors">
      <li v-for="error in form.errors" :key="error" class="text-danger">
        {{ error }}
      </li>
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
