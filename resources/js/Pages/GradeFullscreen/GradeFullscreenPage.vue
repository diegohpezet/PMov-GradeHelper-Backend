<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import FullscreenLayout from '../../Layouts/FullscreenLayout.vue';
import StudentExerciseGradeForm from './StudentExerciseGradeForm.vue';
import { useArrayFilter } from '../../Utils/useArrayFilter.js';

defineOptions({ layout: FullscreenLayout });

const { course } = defineProps({
  course: {
    type: Object,
    required: true,
  },
});

const { exercises, students } = course;

const [filteredExercise, applyExerciseFilter, selectedExercise] =
  useArrayFilter({
    array: exercises,
  });

const [filteredStudents, applyStudentFilter, selectedStudent] = useArrayFilter({
  array: students,
});

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
            <th
              v-for="exercise in filteredExercise"
              :key="exercise.id"
              scope="col"
            >
              {{ exercise.title }}

              <button
                class="btn btn-secondary btn-sm"
                @click="applyExerciseFilter(exercise.id)"
              >
                {{ selectedExercise === exercise.id ? 'show all' : 'solo' }}
              </button>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in filteredStudents" :key="student.id">
            <td class="sticky-top">
              {{ getStudentName(student) }}
              <button
                class="btn btn-secondary btn-sm"
                @click="applyStudentFilter(student.id)"
              >
                {{ selectedStudent === student.id ? 'show all' : 'solo' }}
              </button>
            </td>
            <td v-for="exercise in filteredExercise" :key="exercise.id">
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
        <Link :href="`/courses/${course.id}`" class="btn btn-outline-secondary">
          {{ $t('cancel') }}
        </Link>
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
