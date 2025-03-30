<script setup>
import { useForm } from '@inertiajs/vue3';
import { formatDate, getDefaultDueDate } from './utils/dates.js';

const { exercise, courses, gradeTypes } = defineProps({
  exercise: {
    type: Object,
    required: true,
  },
  courses: {
    type: Array,
    required: true,
  },
  gradeTypes: {
    type: Array,
    required: true,
  },
});

// Generates initial value for `form.courses`
// using a combination of all courses + exercise courses
const getMergedCourses = () => {
  return courses.map((c) => {
    const exerciseCourse = exercise.courses.find((ec) => ec.id === c.id);
    return {
      id: c.id,
      name: c.name,
      description: c.description,
      school_year: c.school_year,
      selected: Boolean(exerciseCourse),
      grade_type: exerciseCourse?.assessment?.grade_type || gradeTypes[0],
      due_at:
        formatDate(exerciseCourse?.assessment?.due_at) || getDefaultDueDate(),
    };
  });
};

const form = useForm({
  title: exercise.title,
  path: exercise.path,
  courses: getMergedCourses(),
});

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
          v-for="(course, index) in form.courses"
          :key="course.id"
          class="list-group-item"
        >
          <input
            :id="`checkbox-${course.id}`"
            v-model="course.selected"
            type="checkbox"
            class="form-check-input"
          />
          <label class="form-check-label ms-2" :for="`checkbox-${course.id}`">{{
            course.name
          }}</label>

          <div v-if="course.selected">
            <div>
              <label :for="`due-at-${course.id}`">{{
                $t('exercises.field.due_at')
              }}</label>
              <input
                :id="`due-at-${course.id}`"
                v-model="course.due_at"
                type="datetime-local"
                class="form-control"
              />
              <span
                v-if="form.errors[`courses.${index}.due_at`]"
                class="text-danger"
              >
                {{ form.errors[`courses.${index}.due_at`] }}
              </span>
            </div>
            <div>
              <label :for="`grade_type-${course.id}`">{{
                $t('exercises.field.grade_type')
              }}</label>
              <select
                :id="`grade_type-${course.id}`"
                v-model="course.grade_type"
                class="form-select"
              >
                <option v-for="gradeType in gradeTypes" :key="gradeType">
                  {{ gradeType }}
                </option>
              </select>
              <span
                v-if="form.errors[`courses.${index}.grade_type`]"
                class="text-danger"
              >
                {{ form.errors[`courses.${index}.grade_type`] }}
              </span>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <button type="submit" class="btn btn-primary">
      {{ $t('exercises.submit_edit') }}
    </button>
  </form>
</template>
