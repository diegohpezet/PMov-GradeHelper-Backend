<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ gradeable: Object });
const form = useForm({
  value: props.gradeable.gradable.value,
  comment: props.gradeable.gradable.comment,
});
const gradableType = props.gradeable.gradable_type.split('\\').pop();

const options = {
  TEGrade: ['TEA', 'TEP', 'TED'],
  PassFailGrade: [true, false],
};

const editGradeable = () => form.put(`/gradeables/${props.gradeable.id}`);
</script>

<template>
  <h1>{{ $t('grades.edit') }}</h1>
  <form @submit.prevent="editGradeable">
    <div v-if="gradableType in options" class="mb-3">
      <label class="form-label">Value</label>
      <div
        v-for="option in options[gradableType]"
        :key="option"
        class="form-check"
      >
        <input
          v-model="form.value"
          class="form-check-input"
          type="radio"
          :value="option"
        />
        <label class="form-check-label">{{
          option === true ? 'Passed' : option === false ? 'Failed' : option
        }}</label>
      </div>
    </div>

    <div v-else-if="gradableType === 'NumericGrade'" class="mb-3">
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
