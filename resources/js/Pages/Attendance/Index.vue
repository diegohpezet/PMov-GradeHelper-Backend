<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { shortDateFormat } from '../../Utils/dates.js';
import AttendanceRow from './components/AttendanceRow.vue';

const { students, attendances } = defineProps({
  students: [Object],
  attendances: [Object],
});

const page = usePage();
const isAdmin = page.props.auth.isAdmin;
const error = ref('');

const sortedStudents = [...students].sort((a, b) =>
  a.last_name.localeCompare(b.last_name),
);

// Get unique attendance dates and sort them
const sortedDates = ref(
  Array.from(
    new Set(
      attendances.map((attendance) => new Date(attendance.date).getTime()),
    ),
  )
    .sort((a, b) => a - b)
    .map((timestamp) => new Date(timestamp)),
);

const createAttendanceDate = () => {
  const today = new Date();
  const todayString = today.toISOString().slice(0, 10);

  if (
    sortedDates.value.find(
      (date) => date.toISOString().slice(0, 10) === todayString,
    )
  ) {
    return (error.value = 'You already took attendance today');
  }

  sortedDates.value.push(today);
};

// TODO: refactor this to avoid mutating prop
const updateAttendance = ({ studentId, date, isNowChecked }) => {
  const method = isNowChecked ? 'POST' : 'DELETE';

  fetch(`/attendances`, {
    method: method,
    credentials: 'include',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
        .content,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      student_id: studentId,
      course_id: page.props.course.id,
      date: date.toISOString().slice(0, 10),
    }),
  }).then(() => {
    if (isNowChecked) {
      attendances.push({
        student_id: studentId,
        course_id: page.props.course.id,
        date: date.toISOString().slice(0, 10),
      });
    } else {
      const index = attendances.findIndex(
        (attendance) =>
          attendance.student_id === studentId &&
          attendance.date === date.toISOString().slice(0, 10),
      );
      if (index > -1) attendances.splice(index, 1);
    }
  });
};
</script>

<template>
  <h1 class="h2">{{ $t('attendances') }}</h1>

  <button
    v-if="isAdmin"
    class="btn btn-primary text-white"
    @click="createAttendanceDate"
  >
    {{ $t('attendances.take') }}
  </button>

  <br />

  <span v-if="error" class="text-danger">{{ error }}</span>

  <table class="table table-striped border mt-3">
    <thead class="table-primary">
      <tr>
        <th scope="col">
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
        @update-attendance="updateAttendance"
      />
    </tbody>
  </table>
</template>
