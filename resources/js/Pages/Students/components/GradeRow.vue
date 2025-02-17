<script setup>
import { ref } from 'vue';

const props = defineProps({
  grade: Object,
});

const showTruncated = ref(true);

const dateFormatter = new Intl.DateTimeFormat('es-AR', {
  dateStyle: 'short',
  timeStyle: 'short',
});
</script>

<template>
  <div class="row align-items-top" @click="showTruncated = !showTruncated">
    <div
      class="col-1"
      :class="{
        'text-danger': grade.result == 'failed',
        'text-success': grade.result == 'passed',
      }"
    >
      {{ grade.result }}
    </div>
    <div
      class="col"
      :class="{
        'text-truncate': showTruncated,
      }"
    >
      {{ grade.comment }}
    </div>
    <div class="col-auto">
      {{ dateFormatter.format(new Date(grade.created_at)) }}
    </div>
  </div>
</template>
