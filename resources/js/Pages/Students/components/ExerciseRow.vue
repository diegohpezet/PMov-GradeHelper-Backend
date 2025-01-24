<script setup>
import { ref } from 'vue'

const props = defineProps({
  exercise: Object,
});
</script>

<template>
  <div>
    <div class="d-flex mb-2">
      <h2 class="h3">{{ exercise.title }}</h2>
    </div>

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