<script setup>
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
  </ul>

  <div class="tab-content p-3" id="courseTabsContent">
    <div class="tab-pane fade show active" id="students-tab-pane" role="tabpanel" aria-labelledby="students-tab"
      tabindex="0">
      <h2 class="mb-3 ">Students</h2>
      <!-- <StudentsList :course_id="course.id" /> --><!-- Course id is intended to be passed to the StudentsList component -->
    </div>
    
    <div class="tab-pane fade" id="exercises-tab-pane" role="tabpanel" aria-labelledby="exercises-tab" tabindex="0">
      <h2 class="mb-3">Exercises</h2>
      <ul class="list-group">
        <li v-for="exercise in sortedCourseExercises" :key="exercise.id" class="list-group-item">
          {{ exercise.title }}
        </li>
      </ul>
    </div>
    
    <div class="tab-pane fade" id="grades-tab-pane" role="tabpanel" aria-labelledby="grades-tab" tabindex="0">
      <h2>Grades</h2>
      <!-- <GradesStudentsMatrix :course_id="course.id" /> -->
      <!-- Course id is intended to be passed to the GradesStudentsMatrix component -->
    </div>
  </div>
</template>
