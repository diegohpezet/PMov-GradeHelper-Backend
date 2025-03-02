<script setup>
import { computed, ref } from 'vue';
import { filterStudents, filterAssessments } from './utils/filters';
import CheckOnlineStatus from './components/CheckOnlineStatus.vue';
import CreateGradeableForm from './components/CreateGradeableForm.vue';
import GradeablesHistory from './components/GradeablesHistory.vue';
import { usePage } from '@inertiajs/vue3';

const { students, exercises } = defineProps({
  students: {
    type: Array,
    default: () => [],
  },
  exercises: {
    type: Array,
    default: () => [],
  },
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

// Filter functionality
const selectedExercise = ref(null);
const selectedStudent = ref(null);

const filteredStudents = computed(() => {
  return students;
});

const filteredExercises = computed(() => {
  return exercises;
});

const applyStudentListFilter = (student) => {
  selectedStudent.value =
    selectedStudent.value && selectedStudent.value.id === student.id
      ? null
      : student;
};

const applyExerciseListFilter = (exercise) => {
  selectedExercise.value =
    selectedExercise.value && selectedExercise.value.id === exercise.id
      ? null
      : exercise;
};

// Get gradeable value for exercise
const getLastGradeable = (student, exercise) => {
  const firstExerciseGrade = student.grades.find(
    (grade) => grade.assessment_id === exercise.assessment.id
  );
  return firstExerciseGrade?.gradeable?.value;
};

// Form functionality
const studentToGrade = ref(null);
const exerciseToGrade = ref(null);

const setGradeFormValues = (student, exercise) => {
  studentToGrade.value = student;
  exerciseToGrade.value = exercise;
};
</script>

<template>
  <h1 class="h2">{{ $t('grades') }}</h1>

  <CreateGradeableForm
    v-if="isAdmin"
    :student="studentToGrade"
    :exercise="exerciseToGrade"
  />

  <GradeablesHistory
    :student="studentToGrade"
    :exercise="exerciseToGrade"
  />

  <table class="table table-striped border">
    <thead class="table-primary">
      <tr>
        <th scope="col">{{ $t('grades.student') }}</th>
        <th
          v-for="excercise in filteredExercises"
          :key="excercise.id"
          scope="col"
          class="hoverable"
          @click="applyExerciseListFilter(excercise)"
        >
          {{ excercise.title }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="student in filteredStudents" :key="student.id">
        <th
          scope="row"
          class="hoverable"
          @click="applyStudentListFilter(student)"
        >
          {{ student.last_name }} {{ student.first_name }}
        </th>

        <td
          v-for="excercise in filteredExercises"
          :key="excercise.id"
          class="hoverable"
          @click="setGradeFormValues(student, excercise)"
        >
          <div class="d-flex">
            <CheckOnlineStatus
              :student-username="student.github_username"
              :exercise-path="assesment?.exercise?.path"
            />
            <span>
              <a
                v-if="excercise"
                :href="`https://${student.github_username}.github.io/plataformas-moviles-entregas/${excercise.path}`"
                class="mx-1"
              >
                Link
              </a>
              | {{ getLastGradeable(student, excercise) }}
            </span>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>
.hoverable:hover {
  cursor: pointer;
  filter: brightness(0.9);
}
</style>
