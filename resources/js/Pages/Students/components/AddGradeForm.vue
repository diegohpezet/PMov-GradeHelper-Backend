<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

const props = defineProps({
  studentId: String,
  exerciseId: String,
});

const page = usePage();
const gradeResultOptions = page.props.gradeResultOptions;

const form = useForm({
  student_id: props.studentId,
  exercise_id: props.exerciseId,
  result: undefined,
  comment: '',
});

const saveGrade = () => {
  form.post('/grades', {
    onSuccess: () => {
      form.reset();
      emit('close');
    },
  });
};
</script>

<template>
  <form class="row g-3 align-items-center" @submit.prevent="saveGrade">
    <div class="col-auto">
      <div v-for="option in gradeResultOptions" class="form-check">
        <input
          :id="`result-radio-${option}-${exerciseId}`"
          v-model="form.result"
          class="form-check-input"
          :value="option"
          type="radio"
          :name="`result-radio-${exerciseId}`"
          :disabled="form.processing"
        />
        <label
          class="form-check-label"
          :for="`result-radio-${option}-${exerciseId}`"
        >
          {{ option }}
        </label>
      </div>
    </div>
    <div class="col">
      <textarea
        :id="`comment-${exerciseId}`"
        v-model="form.comment"
        class="form-control"
        :name="`comment-${exerciseId}`"
        rows="3"
        :disabled="form.processing"
      ></textarea>
    </div>
    <div class="col-12">
      <button
        class="btn btn-primary me-3"
        type="submit"
        :disabled="form.processing"
      >
        {{ $t('grades.submit') }}
      </button>
      <button
        class="btn btn-secondary"
        type="button"
        :disabled="form.processing"
        @click="$emit('close')"
      >
        >
        {{ $t('cancel') }}
      </button>
    </div>
  </form>
</template>
