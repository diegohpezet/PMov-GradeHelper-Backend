<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({ students: [Object], attendances: [Object] });

const page = usePage();
const isAdmin = page.props.auth.isAdmin;

const error = ref('');

const sortedStudents = props.students.sort((a, b) => a.last_name.localeCompare(b.last_name));
const sortedDates = ref(
  props.attendances
    .map(attendance => new Date(attendance.date))
    .filter((date, index, self) =>
      self.findIndex(d => d.getTime() === date.getTime()) === index // Filtrar duplicados por timestamp
    )
    .sort((a, b) => a.date.localeCompare(b.date))
);

const formatDate = (date) => date.toISOString().slice(0, 10).split('-').slice(1).reverse().join('-');

const isStudentPresent = (student_id, date) => {
  return Boolean(props.attendances.find(attendance => attendance.date === date.toISOString().slice(0, 10) && attendance.student_id === student_id));
};

const createAttendanceDate = () => {
  // DD-MM
  const today = new Date();
  const todayString = today.toISOString().slice(0, 10);

  if (sortedDates.value.find(date => date.toISOString().slice(0, 10) === todayString)) {
    return error.value = 'You already took attendance today';
  }

  sortedDates.value.push(today);
};

const updateAttendance = (student_id, date, isNowChecked) => {
  const method = isNowChecked ? 'POST' : 'DELETE';

  fetch(`/attendances`, {
    method: method,
    credentials: 'include',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      student_id,
      course_id: page.props.course.id,
      date: date.toISOString().slice(0, 10)
    })
  });
};
</script>


<template>
  <h1 class="h2">Attendance</h1>

  <button v-if="isAdmin" class="btn btn-primary text-white" @click="createAttendanceDate">
    Take attendance
  </button>

  <br />

  <span v-if="error" class="text-danger">{{ error }}</span>

  <table class="table table-striped border mt-3">
    <thead class="table-primary">
      <tr>
        <th scope="col">Student</th>
        <th scope="col" class="hoverable text-center">Total</th>
        <th scope="col" class="hoverable text-center" v-for="date in sortedDates">{{ formatDate(date) }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="student in sortedStudents" :key="student.id">
        <td>{{ student.last_name + ' ' + student.first_name }}</td>
        <td class="text-center">0%</td>
        <td class="text-center" v-for="date in sortedDates">
          <input type="checkbox" class="form-check-input" :checked="isStudentPresent(student.id, date)"
            :disabled="!isAdmin" @change="updateAttendance(student.id, date, $event.target.checked)">
        </td>
      </tr>
    </tbody>
  </table>
</template>