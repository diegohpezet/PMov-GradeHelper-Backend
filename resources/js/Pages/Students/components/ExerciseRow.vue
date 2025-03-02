<script setup>
import { ref } from 'vue';
import GradeRow from './GradeRow.vue';
import AddGradeForm from './AddGradeForm.vue';
import { usePage } from '@inertiajs/vue3';

const { exercise, grades } = defineProps({
  exercise: Object,
  grades: Array,
  student: Object,
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const showGradeForm = ref(false);
</script>

<template>
  <div class="mb-3">
    <div class="d-flex align-items-center mb-2">
      <h2 class="h3">{{ exercise.title }}</h2>
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
      :student-id="student.id"
      :exercise-id="exercise.id"
      @close="showGradeForm = false"
    />

    <ul v-if="grades.length" class="list-group">
      <li
        v-for="grade in grades"
        :key="grade.id"
        class="list-group-item"
      >
        <GradeRow :grade="grade" />
      </li>
    </ul>
    <p v-else>{{ $t('grades.empty') }}</p>
  </div>
</template>
