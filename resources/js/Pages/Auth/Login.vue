<script setup>
import { Link, useForm } from '@inertiajs/vue3';
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
  <div class="container">
    <div v-if="status" class="mb-4 text-success text-center">
      {{ status }}
    </div>

    <div class="card mx-auto shadow-sm">
      <div class="card-body">
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="email" value="Email" class="form-label">
              {{ $t('login.fields.email') }}
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="form-control"
              :disabled="form.processing"
              autofocus
            />
            <span v-if="form.errors.email" class="text-danger">{{
              form.errors.email
            }}</span>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">
              {{ $t('login.fields.password') }}
            </label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              class="form-control"
              :disabled="form.processing"
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
            <label class="form-check-label ms-2" for="checkbox-remember">
              {{ $t('login.fields.remember') }}
            </label>
          </div>

          <div class="mb-3 d-flex align-items-center justify-content-end">
            <button
              type="submit"
              class="btn btn-primary ms-4"
              :disabled="form.processing"
            >
              {{ $t('login') }}
            </button>
          </div>
        </form>

        <hr />

        <div class="d-flex align-items-center justify-content-center">
          <Link href="/register" class="me-3">
            {{ $t('register') }}
          </Link>
          <Link href="/forgot-password" class="me-3">
            {{ $t('password.forgot') }}
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped type="text/css">
div.card {
  max-width: 400px;
}
</style>
