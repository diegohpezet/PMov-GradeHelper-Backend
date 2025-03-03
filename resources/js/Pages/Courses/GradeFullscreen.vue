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
    <div class="table-container">
      <table class="table table-borderless table-striped m-0">
        <thead>
          <tr>
            <th scope="col"></th>
            <th v-for="exercise in exercises" :key="exercise.id" scope="col">
              {{ exercise.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.id">
            <td class="sticky-top">
              {{ getStudentName(student) }}
            </td>
            <td v-for="exercise in exercises" :key="exercise.id">
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
            </td>
          </tr>
        </tbody>
      </table>
    </div>
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

<style lang="scss">
.table-container {
  overflow: auto;
  height: calc(100vh - 3rem);
}

.table {
  table-layout: fixed;

  td,
  th {
    width: max(300px, 35vw);
  }

  td:nth-child(1),
  th:nth-child(1) {
    width: 150px;
    position: sticky;
    left: 0;
    z-index: 3;
  }

  th {
    position: sticky;
    top: 0;
    z-index: 2;
  }
}
</style>
