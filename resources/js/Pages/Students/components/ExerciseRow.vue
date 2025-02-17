<script setup>
import { ref } from 'vue';
import GradeRow from './GradeRow.vue';
import AddGradeForm from './AddGradeForm.vue';

const props = defineProps({
  studentId: String,
  exercise: Object,
});

const showGradeForm = ref(false);
</script>

<template>
  <div class="mb-3">
    <div class="d-flex align-items-center mb-2">
      <h2 class="h3">{{ exercise.title }}</h2>
      <button
        v-if="!showGradeForm"
        class="btn btn-sm btn-outline-secondary ms-1"
        @click="showGradeForm = true"
      >
        Add Grade
      </button>
    </div>

    <AddGradeForm
      v-if="showGradeForm"
      class="mb-3"
      :student-id="studentId"
      :exercise-id="exercise.id"
      @close="showGradeForm = false"
    />

    <ul v-if="exercise.grades.length" class="list-group">
      <li v-for="gr in exercise.grades" class="list-group-item">
        <GradeRow :grade="gr" />
      </li>
    </ul>
    <p v-else>No grades for this exercise.</p>
  </div>
</template>
