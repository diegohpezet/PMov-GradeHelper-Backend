<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

const props = defineProps({
  studentId: String,
  exerciseId: String,
});

const page = usePage()
const gradeResultOptions = page.props.gradeResultOptions

const form = useForm({
  student_id: props.studentId,
  exercise_id: props.exerciseId,
  result: undefined,
  comment: ''
});

const saveGrade = () => {
  form.post('/grades', {
    onSuccess: () => {
      form.reset();
      emit('close');
    }
  });
};
</script>

<template>
  <form class="row g-3 align-items-center" @submit.prevent="saveGrade">
    <div class="col-auto">
      <div class="form-check" v-for="option in gradeResultOptions">
        <input class="form-check-input" v-model="form.result" :value="option" type="radio"
          :name="`result-radio-${exerciseId}`" :id="`result-radio-${option}-${exerciseId}`" :disabled="form.processing">
        <label class="form-check-label" :for="`result-radio-${option}-${exerciseId}`">
          {{ option }}
        </label>
      </div>
    </div>
    <div class="col">
      <textarea class="form-control" :name="`comment-${exerciseId}`" :id="`comment-${exerciseId}`" rows="3"
        v-model="form.comment" :disabled="form.processing"></textarea>
    </div>
    <div class="col-12">
      <button class="btn btn-primary me-3" type="submit" :disabled="form.processing">
        <i class="ri-add-line"></i>
        Add Grade
      </button>
      <button class="btn btn-secondary" type="button" @click="$emit('close')"
        :disabled="form.processing">Cancel</button>
    </div>
  </form>
</template>