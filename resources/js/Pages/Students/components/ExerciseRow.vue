<script setup>
import { ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3';
import GradeRow from './GradeRow.vue';

const props = defineProps({
  studentId: String,
  exercise: Object,
});

const page = usePage()
const gradeResultOptions = page.props.gradeResultOptions

const form = useForm({
  student_id: props.studentId,
  exercise_id: props.exercise?.id,
  result: false,
  comment: ''
});

const saveGrade = () => {
  form.post('/grades', {
    onSuccess: () => {
      form.reset();
      showGradeForm.value = false;
    }
  });
};

const showGradeForm = ref(false);
</script>

<template>
  <div class="mb-3">
    <div class="d-flex align-items-center mb-2">
      <h2 class="h3">{{ exercise.title }}</h2>
      <button class="btn btn-sm btn-outline-secondary ms-1" v-if="!showGradeForm" @click="showGradeForm = true">
        Add Grade
      </button>
    </div>

    <form class="mb-3 row g-3 align-items-center" @submit.prevent="saveGrade" v-if="showGradeForm">
      <div class="col-auto">
        <div class="form-check" v-for="option in gradeResultOptions">
          <input class="form-check-input" v-model="form.result" :value="option" type="radio"
            :name="`result-radio-${exercise.id}`" :id="`result-radio-${option}-${exercise.id}`"
            :disabled="form.processing">
          <label class="form-check-label" :for="`result-radio-${option}-${exercise.id}`">
            {{ option }}
          </label>
        </div>
      </div>
      <div class="col">
        <textarea class="form-control" :name="`comment-${exercise.id}`" :id="`comment-${exercise.id}`" rows="3"
          v-model="form.comment" :disabled="form.processing"></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary me-3" type="submit" :disabled="form.processing">
          <i class="ri-add-line"></i>
          Add Grade
        </button>
        <button class="btn btn-secondary" type="cancel" @click="showGradeForm = false"
          :disabled="form.processing">Cancel</button>
      </div>
    </form>

    <ul class="list-group" v-if="exercise.grades.length">
      <li class="list-group-item" v-for="gr in exercise.grades">
        <GradeRow :grade="gr" />
      </li>
    </ul>
    <p v-else>No grades for this exercise.</p>
  </div>
</template>