<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({ grade: Object });

const page = usePage();
const gradeResultOptions = page.props.gradeResultOptions;

const form = useForm(props.grade);

const editGrade = (gradeId) => {
  form.put(`/grades/${gradeId}`);
};
</script>

<template>
  <h1>Edit grade</h1>

  <form @submit.prevent="editGrade(grade.id)">
    <div class="mb-3">
      <label for="score" class="visually-hidden">Result</label>
      <div v-for="option in gradeResultOptions" class="form-check">
        <input
          :id="`result-${option}`"
          v-model="form.result"
          class="form-check-input"
          type="radio"
          name="result"
          :value="option"
        />
        <label class="form-check-label" :for="`result-${option}`">
          {{ option }}
        </label>
      </div>
    </div>

    <div class="mb-3">
      <label for="comment" class="form-label">Comment</label>
      <input
        id="comment"
        v-model="form.comment"
        type="text"
        class="form-control"
      />
      <span v-if="form.errors.comment" class="text-danger">{{
        form.errors.comment
      }}</span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>
