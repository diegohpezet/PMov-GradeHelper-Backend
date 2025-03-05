<script setup>
import { useForm } from '@inertiajs/vue3';

const { grade } = defineProps({
  grade: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  value: grade.gradeable.value,
  comment: grade.gradeable.comment,
});
const gradeableType = grade.gradeable_type.split('\\').pop();

const options = {
  TEGrade: ['TEA', 'TEP', 'TED'],
  PassFailGrade: [true, false],
};

const handleSubmit = () => form.put(`/grades/${grade.id}`);
</script>

<template>
  <h1>{{ $t('grades.edit') }}</h1>
  <form @submit.prevent="handleSubmit">
    <div v-if="gradeableType in options" class="mb-3">
      <label class="form-label">Value</label>
      <div
        v-for="option in options[gradeableType]"
        :key="option"
        class="form-check"
      >
        <input
          v-model="form.value"
          class="form-check-input"
          type="radio"
          :value="option"
          :checked="option == form.value"
        />
        <label class="form-check-label">{{
          option === true ? 'Passed' : option === false ? 'Failed' : option
        }}</label>
      </div>
    </div>

    <div v-else-if="gradeableType === 'NumericGrade'" class="mb-3">
      <label class="form-label" for="value">Value</label>
      <input
        id="value"
        v-model="form.value"
        type="number"
        class="form-control"
      />
    </div>

    <div class="mb-3">
      <label class="form-label" for="comment">
        {{ $t('grades.field.comment') }}
      </label>
      <input
        id="comment"
        v-model="form.comment"
        type="text"
        class="form-control"
      />
    </div>

    <button type="submit" class="btn btn-primary text-white">
      {{ $t('grades.submit_edit') }}
    </button>
  </form>
</template>
