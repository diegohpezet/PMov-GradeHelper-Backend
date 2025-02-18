<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AttendanceTable from './components/AttendanceTable.vue';

const props = defineProps({ students: [Object], attendances: [Object] });

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const error = ref('');

const createAttendanceDate = () => {
  const today = new Date();
  const todayString = today.toISOString().slice(0, 10);

  if (
    props.attendances.find((attendance) => attendance.date === todayString)
  ) {
    return (error.value = 'You already took attendance today');
  }

  props.attendances.push({ date: todayString });
};

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
      props.attendances.push({
        student_id: studentId,
        course_id: page.props.course.id,
        date: date.toISOString().slice(0, 10),
      });
    } else {
      const index = props.attendances.findIndex(
        (attendance) =>
          attendance.student_id === studentId &&
          attendance.date === date.toISOString().slice(0, 10),
      );
      if (index > -1) props.attendances.splice(index, 1);
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

  <AttendanceTable
    :students="students"
    :attendances="attendances"
  />
</template>
