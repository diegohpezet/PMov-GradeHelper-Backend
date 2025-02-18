<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { shortDateFormat } from '@/Utils/dates.js';
import AttendanceRow from './AttendanceRow.vue';

const props = defineProps({
  students: [Object],
  attendances: [Object],
  showNames: { type: Boolean, default: true },
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const emit = defineEmits(['update-attendance']);

const sortedStudents = computed(() =>
  props.students.sort((a, b) => a.last_name.localeCompare(b.last_name)),
);

const sortedDates = computed(() => {
  return Array.from(
    new Set(
      props.attendances.map((attendance) =>
        new Date(attendance.date).getTime(),
      ),
    ),
  )
    .sort((a, b) => a - b)
    .map((timestamp) => new Date(timestamp));
});
</script>

<template>
  <table class="table table-striped border mt-3">
    <thead class="table-primary">
      <tr>
        <th v-if="showNames" scope="col">
          {{ $t('attendances.student') }}
        </th>
        <th scope="col" class="hoverable text-center">
          {{ $t('attendances.total') }}
        </th>
        <th
          v-for="date in sortedDates"
          :key="date"
          scope="col"
          class="hoverable text-center"
        >
          {{ shortDateFormat(date) }}
        </th>
      </tr>
    </thead>
    <tbody>
      <AttendanceRow
        v-for="student in sortedStudents"
        :key="student.id"
        :student="student"
        :dates="sortedDates"
        :attendances="attendances"
        :is-admin="isAdmin"
        :showNames="showNames"
        @update-attendance="emit('update-attendance', $event)"
      />
    </tbody>
  </table>
</template>
