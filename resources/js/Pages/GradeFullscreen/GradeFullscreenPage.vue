<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import FullscreenLayout from '../../Layouts/FullscreenLayout.vue';
import StudentExerciseGradeForm from './StudentExerciseGradeForm.vue';

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

const getFormKey = (student, exercise) => `${student.id}-${exercise.id}`;

const getInitialFormData = () => {
  const formData = {};
  students.forEach((student) => {
    exercises.forEach((exercise) => {
      const key = getFormKey(student, exercise);
      formData[key] = {
        comment: null,
      };
    });
  });
  return formData;
};

const form = useForm(getInitialFormData());

const handleSubmit = () => {
  console.log('handleSubmit', form);
};
</script>

<template>
  <Head title="Full Screen - Grade Helper" />
  <div class="d-flex flex-column flex-grow-1 vh-100">
    <div class="flex-grow-1 overflow-auto" style="">
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
              <StudentExerciseGradeForm
                v-model="form[getFormKey(student, exercise)]"
                :form-key="getFormKey(student, exercise)"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="container-fluid">
      <form
        class="d-flex gap-3 justify-content-end py-2"
        @submit.prevent="handleSubmit"
      >
        <button type="button" class="btn btn-outline-secondary">
          {{ $t('cancel') }}
        </button>
        <button type="submit" class="btn btn-primary">
          {{ $t('grades.submit_all') }}
        </button>
      </form>
    </div>
  </div>
</template>

<style lang="scss">
table.table {
  table-layout: fixed;

  td,
  th {
    width: max(300px, 35vw);
  }

  // fixed first column
  td:nth-child(1),
  th:nth-child(1) {
    width: 150px;
    position: sticky;
    left: 0;
    z-index: 3;
  }

  // fixed column headers
  th {
    position: sticky;
    top: 0;
    z-index: 2;
  }
}
</style>
