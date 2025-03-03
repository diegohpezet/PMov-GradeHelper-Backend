<script setup>
import { Head } from '@inertiajs/vue3';
import FullscreenLayout from '../../Layouts/FullscreenLayout.vue';
defineOptions({ layout: FullscreenLayout });

const { course } = defineProps({
  course: {
    type: Object,
    required: true,
  },
});
const { exercises, students } = course;

const getStudentName = (student) => {
  return `${student.last_name}, ${student.first_name}`;
};
</script>

<template>
  <Head title="Full Screen - Grade Helper" />

  <div class="container-fluid">
    <table class="table table-borderless">
      <thead>
        <tr>
          <th scope="col" width="10%"></th>
          <th
            v-for="exercise in exercises"
            :key="exercise.id"
            scope="col"
            class="sticky-top"
          >
            {{ exercise.title }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="student in students" :key="student.id">
          <th scope="row" class="sticky-top">
            {{ getStudentName(student) }}
          </th>
          <td v-for="exercise in exercises" :key="exercise.id">
            <div class="mb-3">
              <label
                :for="`comment-feedback-${student.id}-${exercise.id}`"
                class="form-label"
              >
                <span>{{ $t('grades.field.comment') }}</span>
              </label>
              <textarea
                :id="`comment-feedback-${student.id}-${exercise.id}`"
                class="form-control"
                rows="3"
              ></textarea>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="sticky-bottom bg-body bg-body-tertiary">
    <div class="container-fluid py-2">
      <div class="d-flex gap-1 justify-content-end">
        <button type="button" class="btn btn-outline-secondary">
          {{ $t('cancel') }}
        </button>
        <button type="button" class="btn btn-primary">
          {{ $t('grades.submit_all') }}
        </button>
      </div>
    </div>
  </div>
</template>
