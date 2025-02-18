<script setup>
import { useI18n } from 'vue-i18n';
import AttendanceTable from '../../Attendance/components/AttendanceTable.vue';

const { t } = useI18n();

const props = defineProps({ 
  attendances: { type: Array, required: true },
  student: { type: Object, required: true } 
});
</script>

<template>
  <h2>{{ t('attendances') }}</h2>
  
  <p v-if="!attendances.length">{{ t('attendances.empty') }}</p>
  <AttendanceTable :students="[student]" :attendances="attendances" :showNames="false"/>
</template>