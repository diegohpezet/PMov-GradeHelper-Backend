<script setup>
import { watchEffect } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  student: Object,
  exercise: Object
});

const form = useForm({
  student_id: props.student?.id || '',
  exercise_id: props.exercise?.id || '',
  score: 0,
  comment: ''
});

watchEffect(() => {
  if (props.student && props.exercise) {
    form.student_id = props.student.id;
    form.exercise_id = props.exercise.id;
  }
});

const saveGrade = () => {
  form.post('/grades', {
    onSuccess: () => {
      form.reset();
    }
  });
};
</script>

<template>
  <form @submit.prevent="saveGrade">
    <div class="row mb-3">
      <div class="col-2">
        <label for="student_id" class="visually-hidden">Student</label>
        <input type="text" id="student_id" :value="props.student?.last_name || ''" disabled class="form-control">
      </div>
      <div class="col-2">
        <label for="exercise_id" class="visually-hidden">Exercise</label>
        <input type="text" id="exercise_id" :value="props.exercise?.title || ''" disabled class="form-control">
      </div>
      <div class="col-1">
        <label for="score" class="visually-hidden">Score</label>
        <input type="number" id="score" class="form-control" v-model="form.score" min="0" max="10">
      </div>
      <div class="col-4">
        <label for="comment" class="visually-hidden">Comment</label>
        <input type="text" id="comment" class="form-control" placeholder="Comment" v-model="form.comment">
      </div>
      <div class="col-1">
        <button type="submit" class="btn btn-primary text-white w-variant">
          <i class="ri-add-line"></i>
          <span class="d-inline d-lg-none">Submit</span>
        </button>
      </div>
    </div>

    <ul v-if="form.errors">
      <li v-for="error in form.errors" :key="error" class="text-danger">{{ error }}</li>
    </ul>
  </form>
</template>
