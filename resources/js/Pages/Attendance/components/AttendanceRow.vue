<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  student: { type: Object, required: true },
  dates: { type: Array, required: true },
  attendances: { type: Array, required: true },
  showNames: { type: Boolean, default: true },
});

const emit = defineEmits(['update-attendance']);

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const attendancePercentage = computed(() => {
  const totalDates = props.dates.length;
  const attendedDates = props.attendances.filter(
    (attendance) =>
      attendance.student_id === props.student.id &&
      props.dates.some(
        (date) => date.toISOString().slice(0, 10) === attendance.date,
      ),
  ).length;

  return totalDates > 0 ? Math.round((attendedDates / totalDates) * 100) : 0;
});

const isStudentPresent = (date) => {
  return Boolean(
    props.attendances.find(
      (attendance) =>
        attendance.date === date.toISOString().slice(0, 10) &&
        attendance.student_id === props.student.id,
    ),
  );
};

const handleAttendanceChange = (date, isNowChecked) => {
  emit('update-attendance', {
    studentId: props.student.id,
    date,
    isNowChecked,
  });
};
</script>

<template>
  <tr>
    <td v-if="showNames">{{ student.last_name + ' ' + student.first_name }}</td>
    <td class="text-center">{{ attendancePercentage }}%</td>
    <td v-for="date in dates" :key="date" class="text-center">
      <input
        type="checkbox"
        class="form-check-input"
        :checked="isStudentPresent(date)"
        :disabled="!isAdmin"
        @change="handleAttendanceChange(date, $event.target.checked)"
      />
    </td>
  </tr>
</template>
