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
  <form class="my-3" @submit.prevent="submit">
    <div class="row g-2">
      <div class="col-12 col-md-6">
        <label for="title" class="visually-hidden">
          {{ $t('exercises.field.title') }}
        </label>
        <input
          id="title"
          v-model="form.title"
          type="text"
          class="form-control"
          :placeholder="$t('exercises.field.title_placeholder')"
        />
      </div>

      <div class="col-12 col-md-6">
        <label for="path" class="visually-hidden">
          {{ $t('exercises.field.path') }}
        </label>
        <input
          id="path"
          v-model="form.path"
          type="text"
          class="form-control"
          :placeholder="$t('exercises.field.path_placeholder')"
        />
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          {{ $t('exercises.submit') }}
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
