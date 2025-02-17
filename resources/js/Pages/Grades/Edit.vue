<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ grade: Object });
const form = useForm({
  value: props.grade.gradable.value,
  comment: props.grade.gradable.comment,
});
const gradableType = props.grade.gradable_type.split('\\').pop();

const options = {
  TEGrade: ["TEA", "TEP", "TED"],
  PassFailGrade: [true, false]
};

const editGrade = () => form.put(`/grades/${props.grade.id}`);
</script>

<template>
  <h1>Edit grade</h1>
  <form @submit.prevent="editGrade">
    <div v-if="gradableType in options" class="mb-3">
      <label class="form-label">Value</label>
      <div v-for="option in options[gradableType]" :key="option" class="form-check">
        <input class="form-check-input" type="radio" v-model="form.value" :value="option">
        <label class="form-check-label">{{ option === true ? "Passed" : option === false ? "Failed" : option }}</label>
      </div>
    </div>

    <div v-else-if="gradableType === 'NumericGrade'" class="mb-3">
      <label class="form-label" for="value">Value</label>
      <input type="number" class="form-control" id="value" v-model="form.value">
    </div>

    <div class="mb-3">
      <label class="form-label" for="comment">Comment</label>
      <input type="text" class="form-control" id="comment" v-model="form.comment">
    </div>

    <button type="submit" class="btn btn-primary text-white">Submit</button>
  </form>
</template>