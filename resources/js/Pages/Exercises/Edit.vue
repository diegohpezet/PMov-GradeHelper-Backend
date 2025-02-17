<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import {
  formatDate,
  getDefaultDueDate,
  getDueDate,
  setDueDate,
} from './utils/dates.js';

const props = defineProps({ exercise: Object });
const courses = usePage().props.courses;

const form = useForm({
  ...props.exercise,
  courses: props.exercise.courses.map((course) => ({
    course_id: course.id,
    due_at: formatDate(course.pivot?.due_at) || getDefaultDueDate(),
  })),
  selectedCourses: props.exercise.courses.map((course) => course.id),
});

watch(
  () => form.selectedCourses,
  (newSelectedCourses) => {
    form.courses = form.courses.filter((course) =>
      newSelectedCourses.includes(course.course_id),
    );

    newSelectedCourses.forEach((courseId) => {
      if (!form.courses.some((course) => course.course_id === courseId)) {
        form.courses.push({
          course_id: courseId,
          due_at: getDefaultDueDate(),
        });
      }
    });
  },
);

const editExercise = (id) => {
  form.put(`/exercises/${id}`);
};
</script>

<template>
  <form @submit.prevent="editExercise(exercise.id)">
    <div class="mb-3">
      <label for="title" class="form-label">
        {{ $t('exercises.field.title') }}
      </label>
      <input
        id="title"
        v-model="form.title"
        type="text"
        class="form-control"
        :placeholder="$t('exercises.field.title_placeholder')"
      />
      <span v-if="form.errors.title" class="text-danger">{{
        form.errors.title
      }}</span>
    </div>

    <div class="mb-3">
      <label for="path" class="form-label">
        {{ $t('exercises.field.path') }}
      </label>
      <input
        id="path"
        v-model="form.path"
        type="text"
        class="form-control"
        :placeholder="$t('exercises.field.path_placeholder')"
      />
      <span v-if="form.errors.path" class="text-danger">{{
        form.errors.path
      }}</span>
    </div>

    <div class="mb-3">
      <label for="courses" class="form-label">{{ $t('courses') }}</label>
      <p class="text-muted">{{ $t('exercises.field.courses_description') }}</p>
      <ul class="list-group">
        <li
          v-for="(course, index) in courses"
          :key="course.id"
          class="list-group-item"
        >
          <input
            :id="`checkbox-${course.id}`"
            v-model="form.selectedCourses"
            type="checkbox"
            :value="course.id"
            class="form-check-input"
          />
          <label class="form-check-label ms-2" :for="`checkbox-${course.id}`">{{
            course.name
          }}</label>

          <div v-if="form.selectedCourses.includes(course.id)">
            <label :for="`due-at-${course.id}`">{{
              $t('exercises.field.due_at')
            }}</label>
            <input
              :id="`due-at-${course.id}`"
              type="datetime-local"
              :value="getDueDate(form.courses, course.id)"
              class="form-control"
              @input="setDueDate(form.courses, course.id, $event.target.value)"
            />
          </div>
        </li>
      </ul>
      <span v-if="form.errors.courses" class="text-danger">{{
        form.errors.courses
      }}</span>
    </div>

    <button type="submit" class="btn btn-primary">
      {{ $t('exercises.submit_edit') }}
    </button>
  </form>
</template>
