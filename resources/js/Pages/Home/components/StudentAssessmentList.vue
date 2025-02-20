<script setup>
import { useI18n } from 'vue-i18n';
import AssessmentItem from './AssessmentItem.vue';

const { t } = useI18n();

const props = defineProps({
  student: { type: Object, required: true },
});

const assessments = props.student.course.assessments;
</script>

<template>
  <h2>{{ t('exercises') }}</h2>

  <p v-if="!assessments.length">{{ t('exercises.empty') }}</p>
  <div id="assessmentsAccordion" class="accordion">
    <AssessmentItem
      v-for="assessment in assessments"
      :key="assessment.id"
      :student="student"
      :assessment="assessment"
    />
  </div>
</template>
