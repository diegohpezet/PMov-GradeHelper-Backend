<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ course: Object });

const form = useForm(props.course);

const editCourse = (id) => {
  form.put(`/courses/${id}`);
};
</script>

<template>
  <form @submit.prevent="editCourse(course.id)">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input id="name" v-model="form.name" type="text" class="form-control" />
      <span v-if="form.errors.name" class="text-danger">{{
        form.errors.name
      }}</span>
    </div>

    <div class="mb-3">
      <label for="school_year" class="form-label">School year</label>
      <input
        id="school_year"
        v-model="form.school_year"
        type="text"
        class="form-control"
      />
      <span v-if="form.errors.school_year" class="text-danger">{{
        form.errors.school_year
      }}</span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>
