<script setup>
import { useI18n } from 'vue-i18n';
import AssessmentItem from './AssessmentItem.vue';

const { t } = useI18n();

const { student } = defineProps({
  student: { type: Object, required: true },
});

const { exercises } = student.course;
</script>

<template>
  <h2>{{ t('exercises') }}</h2>

  <p v-if="!exercises.length">{{ t('exercises.empty') }}</p>
  <div id="assessmentsAccordion" class="accordion">
    <AssessmentItem
      v-for="exercise in exercises"
      :key="exercise.id"
      :student="student"
      :exercise="exercise"
    />
  </div>
</template>
