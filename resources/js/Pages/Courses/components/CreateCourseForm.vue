<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  school_year: new Date().getFullYear(),
});

function submit() {
  form.post('/courses', {
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <form class="my-3" @submit.prevent="submit">
    <div class="row g-1">
      <div class="col-12 col-md-6">
        <label for="name" class="visually-hidden">
          {{ $t('courses.field.name') }}
        </label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          class="form-control"
          :placeholder="$t('courses.field.name_placeholder')"
        />
      </div>

      <div class="col-12 col-md-6">
        <label for="school_year" class="visually-hidden">
          {{ $t('courses.field.school_year') }}
        </label>
        <input
          id="school_year"
          v-model="form.school_year"
          type="text"
          class="form-control"
          :placeholder="$t('courses.field.school_year_placeholder')"
        />
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          {{ $t('courses.submit') }}
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
