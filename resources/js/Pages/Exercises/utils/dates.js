export const formatDate = (dateString) => {
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '';
    return date.toISOString().slice(0, 16);
};

export const getDefaultDueDate = () => {
    const date = new Date();
    date.setDate(date.getDate() + 14);
    date.setHours(23, 59, 0, 0);
    return date.toISOString().slice(0, 16);
};

export const getDueDate = (courses, courseId) => {
    const course = courses.find((c) => c.course_id === courseId);
    return course ? course.due_at : getDefaultDueDate();
};

export const setDueDate = (courses, courseId, newDate) => {
    const course = courses.find((c) => c.course_id === courseId);
    if (course) {
        course.due_at = newDate;
    }
};
