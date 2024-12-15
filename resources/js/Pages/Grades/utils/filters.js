export function filterStudents(students, selectedStudent, selectedExercise) {
  return students
    .filter((student) => {
      if (selectedStudent && student.id !== selectedStudent.id) {
        return false;
      }
      return true;
    })
    .map((student) => ({
      ...student,
      grades: selectedExercise
        ? student.grades.filter((grade) => grade.exercise_id === selectedExercise.id)
        : student.grades,
    }));
}


export function filterExercises(exercises, selectedExercise) {
  if (!selectedExercise) {
    return exercises;
  }
  return exercises.filter((exercise) => exercise.id === selectedExercise.id);
}
