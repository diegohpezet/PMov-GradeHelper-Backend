<script setup>
import { ref } from 'vue';
import GradeRow from './GradeRow.vue';
import AddGradeForm from './AddGradeForm.vue';

const { studentId, exercise } = defineProps({
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
        {{ $t('grades.add') }}
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
      <li v-for="gr in exercise.grades" :key="gr" class="list-group-item">
        <pre>{{ gr }}</pre>
        <GradeRow :grade="gr" />
      </li>
    </ul>
    <p v-else class="text-muted">
      {{ $t('grades.empty') }}
    </p>
  </div>
</template>
