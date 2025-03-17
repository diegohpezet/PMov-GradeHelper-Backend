<script setup>
import { useForm } from '@inertiajs/vue3';
import { formatDate } from './utils/dates';

const props = defineProps({
  course: { type: Object, required: true },
  linkedExercises: { type: Array, required: true },
  unlinkedExercises: { type: Array, required: true },
});

const form = useForm({
  exercise: '',
  due_at: '',
});

const handleSubmit = () => {
  form.post(`/courses/${props.course.id}/exercises/link`, {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <h1 class="h2">Link new exercise to {{ course.name }}</h1>

  <form class="row g-3" @submit.prevent="handleSubmit">
    <div class="col-12 col-lg-6">
      <select id="exercise" v-model="form.exercise" class="form-select">
        <option value="">Select an exercise to link</option>
        <option
          v-for="exercise in unlinkedExercises"
          :key="exercise.id"
          :value="exercise.id"
        >
          {{ exercise.title }}
        </option>
      </select>
      <span v-if="form.errors.exercise" class="text-danger">{{
        form.errors.exercise
      }}</span>
    </div>

    <div class="col-12 col-lg-4">
      <label for="due-date" class="form-label d-none">Due date:</label>
      <input
        id="due-date"
        v-model="form.due_at"
        type="datetime-local"
        class="form-control"
      />
      <span v-if="form.errors.due_at" class="text-danger">{{
        form.errors.due_at
      }}</span>
    </div>

    <div class="col-12 col-lg-2">
      <button type="submit" class="btn btn-primary text-white">Link</button>
    </div>
  </form>

  <section class="mt-5">
    <h3 class="h5">Current exercises</h3>
    <ul class="list-group list-group-flush">
      <li
        v-for="exercise in linkedExercises"
        :key="exercise.id"
        class="list-group-item list-group-item-action d-flex justify-content-between"
      >
        <div class="ms-2 me-auto">
          <div class="fw-bold">{{ exercise.title }}</div>
          {{ exercise.path }}
        </div>
        <span>
          Due at:
          {{
            new Date(formatDate(exercise.assessment.due_at)).toLocaleString()
          }}
        </span>
      </li>
    </ul>
  </section>
</template>
