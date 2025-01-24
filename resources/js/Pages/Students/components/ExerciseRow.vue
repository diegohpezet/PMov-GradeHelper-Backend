<script setup>
import { ref } from 'vue'

const props = defineProps({
  exercise: Object,
});

const showGradeForm = ref(false);
</script>

<template>
  <div>
    <div class="d-flex mb-2">
      <h2 class="h3">{{ exercise.title }}</h2>
      <button class="btn btn-sm btn-outline-secondary" v-if="!showGradeForm" @click="showGradeForm = true">Add
        Grade</button>
    </div>

    <form class="mb-3 row g-3 align-items-center" action="" v-if="showGradeForm">
      <div class="col-auto">
        <div class="form-check">
          <input class="form-check-input" type="radio" :name="`result-radio-${exercise.id}`" :id="`result-radio-passed-${exercise.id}`">
          <label class="form-check-label" :for="`result-radio-passed-${exercise.id}`">
            Aprobado
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" :name="`result-radio-${exercise.id}`" :id="`result-radio-failed-${exercise.id}`">
          <label class="form-check-label" :for="`result-radio-failed-${exercise.id}`">
            Desaprobado
          </label>
        </div>
      </div>
      <div class="col">
          <textarea class="form-control" id="comment" rows="3"></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary me-3" type="submit">Add Grade</button>
        <button class="btn btn-secondary" type="cancel" @click="showGradeForm = false">Cancel</button>
      </div>
    </form>

    <ul class="list-group" v-if="exercise.grades.length">
      <li class="list-group-item" v-for="gr in exercise.grades">
        <div class="row align-items-center">
          <div class="col-1" :class="{
            'text-danger': gr.result == 'failed',
            'text-success': gr.result == 'passed',
          }">
            {{ gr.result }}
          </div>
          <div class="col">{{ gr.comment }}</div>
          <div class="col-2">{{ (new Date(gr.created_at)).toLocaleString() }}</div>
        </div>
      </li>
    </ul>
    <p v-else>No grades for this exercise.</p>
  </div>
</template>