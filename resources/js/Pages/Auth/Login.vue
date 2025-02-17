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
  password: '',
  remember: false,
});

function handleSubmit() {
  form.post('/login', {
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <div class="container bg-light p-3 rounded border">
    <div v-if="status" class="mb-4 text-success">
      {{ status }}
    </div>

    <form @submit.prevent="handleSubmit">
      <div class="mb-3">
        <label for="email" value="Email" class="form-label">Email</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="form-control"
          autofocus
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
        />
        <span v-if="form.errors.password" class="text-danger">{{
          form.errors.password
        }}</span>
      </div>

      <div class="mb-3">
        <input
          :id="`checkbox-remember`"
          type="checkbox"
          v-model:="form.remember"
          class="form-check-input"
        />
        <label class="form-check-label ms-2" :for="`checkbox-remember`"
          >Remember me</label
        >
      </div>

      <div class="mb-3 d-flex align-items-center justify-content-end">
        <input
          type="submit"
          class="btn btn-primary ms-4"
          :disabled="form.processing"
          value="Log in"
        />
      </div>
    </form>
  </div>
</template>
