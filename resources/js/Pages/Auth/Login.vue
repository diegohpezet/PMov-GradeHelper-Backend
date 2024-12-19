<script>
import { Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';

export default {
  layout: GuestLayout,
  props: {
    canResetPassword: {
      type: Boolean,
      required: true,
    },
    status: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      form: useForm({
        email: '',
        password: '',
        remember: false,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post('/login');
    },
  },
};
</script>

<template>
  <div class="container bg-light p-3 rounded border">
    <div v-if="status" class="mb-4 text-success">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="email" value="Email" class="form-label">Email</label>
        <input id="email" type="email" class="form-control" v-model="form.email" autofocus />
        <span v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</span>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control" v-model="form.password">
        <span v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</span>
      </div>

      <div class="mb-3">
        <input type="checkbox" v-model:="form.remember" class="form-check-input" :id="`checkbox-remember`">
        <label class="form-check-label ms-2" :for="`checkbox-remember`">Remember me</label>
      </div>

      <div class="mb-3 d-flex align-items-center justify-content-end">
        <input type="submit" class="btn btn-primary ms-4" :disabled="form.processing" value="Log in" />
      </div>
    </form>
  </div>
</template>
