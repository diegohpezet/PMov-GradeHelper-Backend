<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { formatDate, getDefaultDueDate, getDueDate, setDueDate } from './utils/dates.js';

const props = defineProps({ exercise: Object });
const courses = usePage().props.courses;

const form = useForm({
  ...props.exercise,
  courses: props.exercise.courses.map(course => ({
    course_id: course.id,
    due_date: formatDate(course.pivot?.due_date) || getDefaultDueDate(),
  })),
  selectedCourses: props.exercise.courses.map(course => course.id),
})

watch(() => form.selectedCourses, (newSelectedCourses) => {
  form.courses = form.courses.filter(course =>
    newSelectedCourses.includes(course.course_id)
  )

  newSelectedCourses.forEach(courseId => {
    if (!form.courses.some(course => course.course_id === courseId)) {
      form.courses.push({
        course_id: courseId,
        due_date: getDefaultDueDate(),
      })
    }
  })
})

const editExercise = (id) => {
  form.put(`/exercises/${id}`)
}
</script>

<template>
  <form @submit.prevent="editExercise(exercise.id)">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" v-model="form.title">
      <span v-if="form.errors.title" class="text-danger">{{ form.errors.title }}</span>
    </div>

    <div class="mb-3">
      <label for="path" class="form-label">Path</label>
      <input type="text" class="form-control" id="path" v-model="form.path">
      <span v-if="form.errors.path" class="text-danger">{{ form.errors.path }}</span>
    </div>

    <div class="mb-3">
      <label for="courses" class="form-label">Courses:</label>
      <ul class="list-group">
        <li v-for="(course, index) in courses" :key="course.id" class="list-group-item">
          <input 
            type="checkbox" 
            :value="course.id" 
            v-model="form.selectedCourses" 
            class="form-check-input" 
            :id="`checkbox-${course.id}`"
          >
          <label class="form-check-label ms-2" :for="`checkbox-${course.id}`">{{ course.name }}</label>

          <div v-if="form.selectedCourses.includes(course.id)">
            <label :for="`due-at-${course.id}`">Due at</label>
            <input 
              type="datetime-local"
              :id="`due-at-${course.id}`"
              :value="getDueDate(form.courses, course.id)"
              @input="setDueDate(form.courses, course.id, $event.target.value)"
              class="form-control"
            />
          </div>
        </li>
      </ul>
      <span v-if="form.errors.courses" class="text-danger">{{ form.errors.courses }}</span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</template>
