<script setup>
import StudentsList from '../Students/Index.vue';
import AttendanceIndex from '../Attendance/Index.vue';

const props = defineProps({ course: Object })

const sortedCourseExercises = props.course.exercises.sort((a, b) => a.title.localeCompare(b.title))
</script>

<template>
  <h1>{{ course.name }}</h1>

  <ul class="nav nav-tabs" id="courseTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students-tab-pane"
        type="button" role="tab" aria-controls="students-tab-pane" aria-selected="true">Students</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="exercises-tab" data-bs-toggle="tab" data-bs-target="#exercises-tab-pane" type="button"
        role="tab" aria-controls="exercises-tab-pane" aria-selected="false">Exercises</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="grades-tab" data-bs-toggle="tab" data-bs-target="#grades-tab-pane" type="button"
        role="tab" aria-controls="grades-tab-pane" aria-selected="false">Grades</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance-tab-pane" type="button"
        role="tab" aria-controls="attendance-tab-pane" aria-selected="false">Attendance</button>
    </li>
  </ul>

  <div class="tab-content p-3" id="courseTabsContent">
    <div class="tab-pane fade show active" id="students-tab-pane" role="tabpanel" aria-labelledby="students-tab"
      tabindex="0">
      <StudentsList :students="course.students" />
    </div>
    
    <div class="tab-pane fade" id="exercises-tab-pane" role="tabpanel" aria-labelledby="exercises-tab" tabindex="0">
      <h2 class="mb-3">Exercises</h2>
      <ul class="list-group">
        <li v-for="exercise in sortedCourseExercises" :key="exercise.id" class="list-group-item">
          <span class="lead me-3">{{  exercise.title }}</span>
          <span class="text-muted">Due Date {{ (new Date(exercise.pivot.due_date)).toLocaleString() }}</span>
        </li>
      </ul>
    </div>
    
    <div class="tab-pane fade" id="grades-tab-pane" role="tabpanel" aria-labelledby="grades-tab" tabindex="0">
      <h2>Grades</h2>
      <!-- <GradesStudentsMatrix :course_id="course.id" /> -->
      <!-- Course id is intended to be passed to the GradesStudentsMatrix component -->
    </div>

    <div class="tab-pane fade" id="attendance-tab-pane" role="tabpanel" aria-labelledby="attendance-tab" tabindex="0">
      <AttendanceIndex :students="course.students" :attendances="course.attendances"/>
    </div>
  </div>
</template>
