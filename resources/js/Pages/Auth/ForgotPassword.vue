<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

const { status } = defineProps({
  status: {
    type: String,
    default: null,
  },
});

const form = useForm({
  email: '',
});

const handleSubmit = () => {
  form.post('/forgot-password');
};
</script>

<template>
  <div class="container">
    <div v-if="status" class="mb-4 text-success text-center">
      {{ status }}
    </div>

    <div class="card mx-auto shadow-sm">
      <div class="card-body">
        <p class="">{{ $t('password.description') }}</p>
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="email" class="form-label">
              {{ $t('password.email') }}
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              name="email"
              :focused="true"
              placeholder="email@example.com"
              class="form-control"
            />
            <span v-if="form.errors.email" class="text-danger">
              {{ form.errors.email }}
            </span>
          </div>

          <div class="d-flex justify-content-end">
            <button
              class="btn btn-primary text-white"
              :disabled="form.processing"
            >
              {{ $t('password.send') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped type="text/css">
div.card {
  max-width: 400px;
}
</style>
