<script setup>
import { computed, ref } from 'vue';
import CheckOnlineStatus from './components/CheckOnlineStatus.vue';
import CreateGradeForm from './components/CreateGradeForm.vue';
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
  return selectedStudent.value
    ? students.filter((s) => s.id === selectedStudent.value.id)
    : students;
});

const filteredExercises = computed(() => {
  return selectedExercise.value
    ? exercises.filter((e) => e.id === selectedExercise.value.id)
    : exercises;
});

const applyStudentListFilter = (student) => {
  selectedStudent.value =
    selectedStudent.value?.id === student.id ? null : student;
};

const applyExerciseListFilter = (exercise) => {
  selectedExercise.value =
    selectedExercise.value?.id === exercise.id ? null : exercise;
};

// Get gradeable value for exercise
const getLastGradeable = (student, exercise) => {
  const firstExerciseGrade = student.grades.find(
    (grade) => grade.assessment_id === exercise.assessment.id,
  );
  // TODO(Tehuel): format gradeable by type
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

  <p v-if="!students.length">{{ $t('grades.no_students') }}</p>

  <p v-else-if="!exercises.length">{{ $t('grades.no_exercises') }}</p>

  <div v-else>
    <CreateGradeForm
      v-if="isAdmin"
      :student="studentToGrade"
      :exercise="exerciseToGrade"
    />

    <GradeablesHistory :student="studentToGrade" :exercise="exerciseToGrade" />

    <table class="table table-striped border">
      <thead class="table-primary">
        <tr>
          <th scope="col">{{ $t('grades.student') }}</th>
          <th
            v-for="exercise in filteredExercises"
            :key="exercise.id"
            scope="col"
            class="hoverable"
            @click="applyExerciseListFilter(exercise)"
          >
            {{ exercise.title }}
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
            v-for="exercise in filteredExercises"
            :key="exercise.id"
            class="hoverable"
            @click="setGradeFormValues(student, exercise)"
          >
            <div class="d-flex">
              <CheckOnlineStatus
                :student-username="student.github_username"
                :exercise-path="exercise?.path"
              />
              <span>
                <a
                  v-if="exercise"
                  :href="`https://${student.github_username}.github.io/plataformas-moviles-entregas/${exercise.path}`"
                  class="mx-1"
                >
                  Link
                </a>
                | {{ getLastGradeable(student, exercise) }}
              </span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.hoverable:hover {
  cursor: pointer;
  filter: brightness(0.9);
}
</style>
