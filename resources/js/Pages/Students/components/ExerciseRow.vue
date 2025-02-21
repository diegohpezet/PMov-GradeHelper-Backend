<script setup>
import { ref } from 'vue';
import GradeRow from './GradeRow.vue';
import AddGradeForm from './AddGradeForm.vue';
import { usePage } from '@inertiajs/vue3';

const { studentId, assessment } = defineProps({
  studentId: String,
  assessment: Object,
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const showGradeForm = ref(false);
</script>

<template>
  <div class="mb-3">
    <div class="d-flex align-items-center mb-2">
      <h2 class="h3">{{ assessment.exercise.title }}</h2>
      <button
        v-if="isAdmin && !showGradeForm"
        class="btn btn-sm btn-outline-secondary ms-1"
        @click="showGradeForm = true"
      >
        Add Grade
      </button>
    </div>

    <AddGradeForm
      v-if="isAdmin && showGradeForm"
      class="mb-3"
      :student-id="studentId"
      :exercise-id="assessment.id"
      @close="showGradeForm = false"
    />

    <ul v-if="assessment.gradeables.length" class="list-group">
      <li
        v-for="gradable in assessment.gradeables"
        :key="gradable.id"
        class="list-group-item"
      >
        <GradeRow :grade="gradable" />
      </li>
    </ul>
    <p v-else>{{ $t('grades.empty') }}</p>
  </div>
</template>
