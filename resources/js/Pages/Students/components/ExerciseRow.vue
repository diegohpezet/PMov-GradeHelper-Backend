<script setup>
import { ref } from 'vue'
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
        class="btn btn-sm btn-outline-secondary ms-1"
        v-if="!showGradeForm"
        @click="showGradeForm = true"
      >
        {{ $t('grades.add') }}
      </button>
    </div>

    <AddGradeForm
      class="mb-3"
      v-if="showGradeForm"
      :studentId="studentId"
      :exerciseId="exercise.id"
      @close="showGradeForm = false"
    />

    <ul class="list-group" v-if="exercise.grades.length">
      <li class="list-group-item" v-for="gr in exercise.grades">
        <GradeRow :grade="gr" />
      </li>
    </ul>
    <p
      class="text-muted"
      v-else
    >
      {{ $t('grades.empty') }}
    </p>
  </div>
</template>
