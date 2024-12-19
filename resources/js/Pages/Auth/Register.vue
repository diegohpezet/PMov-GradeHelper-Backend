<script>
import { Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';

export default {
  layout: GuestLayout,
  data() {
    return {
      form: useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      }),
    };
  },
  methods: {
    submit() {
      this.form.post('/register', {
        onFinish: () => this.form.reset('password', 'password_confirmation'),
      });
    },
  },
  components: {
    Link,
  }
};
</script>


<template>
  <div class="container bg-light p-3 rounded border">
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" class="form-control" v-model="form.name" required />
        <span v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</span>
      </div>

      <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control" v-model="form.email" required />
        <span v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</span>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" class="form-control" v-model="form.password" required />
        <span v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</span>
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" id="password_confirmation" class="form-control" v-model="form.password_confirmation"
          required />
        <span v-if="form.errors.password_confirmation" class="text-danger">{{ form.errors.password_confirmation
          }}</span>
      </div>

      <div class="d-flex align-items-center justify-content-end">
        <Link href="/login">Already registered?</Link>
        <input type="submit" class="btn btn-primary ms-3" :disabled="form.processing" value="Register" />
      </div>
    </form>
  </div>
</template>
