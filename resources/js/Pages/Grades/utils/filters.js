export function filterStudents(students, selectedStudent, selectedAssessment) {
  return students
    .filter((student) => {
      if (selectedStudent && student.id !== selectedStudent.id) {
        return false;
      }
      return true;
    })
    .map((student) => ({
      ...student,
      gradeables: selectedAssessment
        ? student.gradeables.filter((gradeable) => gradeable.assessment_id === selectedAssessment.id)
        : student.gradeables,
    }))
    .sort((a, b) => a.last_name.localeCompare(b.last_name));
}

export function filterAssessments(assessments, selectedAssessment) {
  if (!selectedAssessment) {
    return assessments;
  }
  return assessments.filter((assessment) => assessment.id === selectedAssessment.id);
}
