<script setup>
import { computed, ref } from 'vue';
import { filterStudents, filterAssessments } from './utils/filters';
import CheckOnlineStatus from './components/CheckOnlineStatus.vue';
import CreateGradeableForm from './components/CreateGradeableForm.vue';
import GradeablesHistory from './components/GradeablesHistory.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  students: [Object],
  assessments: [Object]
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

// Filter functionality
const selectedAssessment = ref(null);
const selectedStudent = ref(null);

const filteredStudents = computed(() => {
  return filterStudents(props.students, selectedStudent.value, selectedAssessment.value);
});

const filteredAssessments = computed(() => {
  return filterAssessments(props.assessments, selectedAssessment.value);
});

const applyAssessmentListFilter = (assessment) => {
  selectedAssessment.value =
    selectedAssessment.value && selectedAssessment.value.id === assessment.id ? null : assessment;
};

const applyStudentListFilter = (student) => {
  selectedStudent.value =
    selectedStudent.value && selectedStudent.value.id === student.id ? null : student;
};

// Get gradeable value for assessment
const getLastGradeable = (student, assessment) => {
  const gradeable = student.gradeables.find((gradeable) => gradeable.assessment_id === assessment.id);

  if (gradeable && gradeable.gradable_type === 'App\\Models\\PassFailGrade') {
    return gradeable.gradable.value ? 'Passed' : 'Failed';
  }
  
  return gradeable ? gradeable.gradable.value : '-';
};

// Form functionality
const studentToGrade = ref(null);
const assessmentToGrade = ref(null);

const setGradeFormValues = (student, assessment) => {
  studentToGrade.value = student;
  assessmentToGrade.value = assessment;
};
</script>

<template>
  <h1 class="h2">Grades</h1>
  <CreateGradeableForm v-if="isAdmin" :student="studentToGrade" :assessment="assessmentToGrade" />
  <GradeablesHistory :student="studentToGrade" :assessment="assessmentToGrade" />

  <table class="table table-striped border">
    <thead class="table-primary">
      <tr>
        <th scope="col">Student</th>
        <th scope="col" class="hoverable" v-for="assessment in filteredAssessments" :key="assessment.id"
          @click="applyAssessmentListFilter(assessment)">
          {{ assessment.exercise.title }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="student in filteredStudents" :key="student.id">
        <th scope="row" class="hoverable" @click="applyStudentListFilter(student)">
          {{ student.last_name }} {{ student.first_name }}
        </th>

        <td class="hoverable" v-for="assessment in filteredAssessments" :key="assessment.id"
          @click="setGradeFormValues(student, assessment)">
          <div class="d-flex">
            <CheckOnlineStatus :studentUsername="student.github_username" :exercisePath="assesment?.exercise?.path" />
            <span>
              <a v-if="assessment"
                :href="`https://${student.github_username}.github.io/plataformas-moviles-entregas/${assessment.exercise.path}`"
                class="mx-1">
                Link
              </a> | {{ getLastGradeable(student, assessment) }}
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
