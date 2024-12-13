<script setup>
import { ref, computed } from 'vue';
import { filterStudents, filterExercises } from './utils/filters';
import CheckOnlineStatus from './components/CheckOnlineStatus.vue';
import CreateGradeForm from './components/CreateGradeForm.vue';
import GradesHistory from './components/GradesHistory.vue';

const props = defineProps({ students: [Object], exercises: [Object] });

// Filter functionality
const selectedExercise = ref(null);
const selectedStudent = ref(null);

const filteredStudents = computed(() => {
  return filterStudents(props.students, selectedStudent.value, selectedExercise.value);
});

const filteredExercises = computed(() => {
  return filterExercises(props.exercises, selectedExercise.value);
});

const applyExerciseListFilter = (exercise) => {
  selectedExercise.value =
    selectedExercise.value && selectedExercise.value.id === exercise.id ? null : exercise;
};

const applyStudentListFilter = (student) => {
  selectedStudent.value =
    selectedStudent.value && selectedStudent.value.id === student.id ? null : student;
};

function getLastGrade(student, exercise) {
  const grades = student.grades.find((grade) => grade.exercise_id === exercise.id)?.grades;

  return grades?.length ? grades[grades.length - 1] : null;
}

// Form functionality
const studentToGrade = ref(null);
const exerciseToGrade = ref(null);
const setGradeFormValues = (student, exercise) => {
  studentToGrade.value = student;
  exerciseToGrade.value = exercise;
}
</script>

<template>
  <CreateGradeForm :student="studentToGrade" :exercise="exerciseToGrade" />
  <GradesHistory :student="studentToGrade" :exercise="exerciseToGrade" />
  
  <table class="table table-striped border">
    <thead class="table-primary">
      <tr>
        <th scope="col">Student</th>
        <th scope="col" class="hoverable" v-for="exercise in filteredExercises" :key="exercise.id" @click="applyExerciseListFilter(exercise)">
          {{ exercise.title }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="student in filteredStudents" :key="student.id">
        <th scope="row" class="hoverable" @click="applyStudentListFilter(student)">
          {{ student.last_name }} {{ student.first_name }}
        </th>

        <td class="hoverable" v-for="exercise in filteredExercises" :key="exercise.id" @click="setGradeFormValues(student, exercise)">
          <div class="d-flex">
            <CheckOnlineStatus :studentUsername="student.githubUsername" :exercisePath="exercise?.path"/>
            <span>
              <a v-if="exercise" :href="`https://${student.githubUsername}.github.io/plataformas-moviles-entregas/${exercise.path}`"class="mx-1">
                Link
              </a> | {{ getLastGrade(student, exercise)?.score ?? '-' }}
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
