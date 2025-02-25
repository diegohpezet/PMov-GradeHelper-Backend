<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

const props = defineProps({
  email: { type: String, required: true },
  token: { type: String, required: true },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const handleSubmit = () => {
  form.post('/reset-password', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <div class="container">
    <div class="card mx-auto shadow-sm">
      <div class="card-body">
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="password" class="form-label">
              {{ $t('password.password') }}
            </label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              class="form-control"
              required
            />
            <span v-if="form.errors.password" class="text-danger">{{
              form.errors.password
            }}</span>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">
              {{ $t('password.password_confirmation') }}
            </label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              class="form-control"
              required
            />
            <span v-if="form.errors.password_confirmation" class="text-danger">
              {{ form.errors.password_confirmation }}
            </span>
          </div>

          <div class="d-flex align-items-center justify-content-end">
            <button
              type="submit"
              class="btn btn-primary text-white"
              :disabled="form.processing"
            >
              {{ $t('password.submit') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
