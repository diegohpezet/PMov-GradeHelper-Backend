<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

function handleSubmit() {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
}
</script>

<template>
  <div class="container bg-light p-3 rounded border">
    <form @submit.prevent="handleSubmit">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          class="form-control"
          required
        />
        <span v-if="form.errors.name" class="text-danger">{{
          form.errors.name
        }}</span>
      </div>

      <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="form-control"
          required
        />
        <span v-if="form.errors.email" class="text-danger">{{
          form.errors.email
        }}</span>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
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
        <label for="password_confirmation" class="form-label"
          >Confirm Password</label
        >
        <input
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          class="form-control"
          required
        />
        <span v-if="form.errors.password_confirmation" class="text-danger">{{
          form.errors.password_confirmation
        }}</span>
      </div>

      <div class="d-flex align-items-center justify-content-end">
        <Link href="/login">Already registered?</Link>
        <input
          type="submit"
          class="btn btn-primary ms-3"
          :disabled="form.processing"
          value="Register"
        />
      </div>
    </form>
  </div>
</template>
