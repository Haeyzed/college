# Assignment Service Usage Guide

This document provides comprehensive examples of how to use the AssignmentService in the College Management System.

## Overview

The AssignmentService follows the same architectural pattern as the BookService, providing a clean separation of concerns with comprehensive CRUD operations, filtering, and business logic for assignment management.

## Service Methods

### Core Assignment Operations

#### 1. Get All Assignments
```php
use App\Services\v1\AssignmentService;
use Illuminate\Http\Request;

$assignmentService = new AssignmentService();
$request = new Request([
    'per_page' => 15,
    'faculty_id' => 1,
    'program_id' => 2,
    'session_id' => 3,
    'semester_id' => 4,
    'section_id' => 5,
    'subject_id' => 6,
    'teacher_id' => 7,
    'status' => 'active',
    'search' => 'math assignment',
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31'
]);

$assignments = $assignmentService->getAssignments($request);
```

#### 2. Create Assignment
```php
$assignmentData = [
    'faculty_id' => 1,
    'program_id' => 2,
    'session_id' => 3,
    'semester_id' => 4,
    'section_id' => 5,
    'subject_id' => 6,
    'title' => 'Mathematics Assignment 1',
    'description' => 'Solve the following mathematical problems',
    'total_marks' => 100,
    'start_date' => '2024-01-15',
    'end_date' => '2024-01-30',
    'attach' => 'assignment_file.pdf',
    'status' => 'active'
];

$assignment = $assignmentService->createAssignment($assignmentData);
```

#### 3. Get Specific Assignment
```php
$assignment = $assignmentService->getAssignment($assignmentId);
```

#### 4. Update Assignment
```php
$updateData = [
    'title' => 'Updated Mathematics Assignment',
    'description' => 'Updated description',
    'total_marks' => 150,
    'end_date' => '2024-02-15',
    'status' => 'active'
];

$assignment = $assignmentService->updateAssignment($updateData, $assignmentId);
```

#### 5. Delete Assignment
```php
$deleted = $assignmentService->deleteAssignment($assignmentId);
```

### Student Assignment Operations

#### 6. Get Student Assignments
```php
$request = new Request([
    'per_page' => 10,
    'session_id' => 3,
    'semester_id' => 4,
    'subject_id' => 6,
    'status' => 'submitted',
    'search' => 'math'
]);

$studentAssignments = $assignmentService->getStudentAssignments($request, $studentId);
```

#### 7. Submit Assignment
```php
$submissionData = [
    'student_id' => 123,
    'submission' => 'Here is my solution to the assignment...',
    'attach' => 'submission_file.pdf'
];

$studentAssignment = $assignmentService->submitAssignment($submissionData, $assignmentId);
```

#### 8. Grade Assignment
```php
$gradingData = [
    'marks' => 85,
    'feedback' => 'Good work! You showed excellent understanding of the concepts.'
];

$gradedAssignment = $assignmentService->gradeAssignment($gradingData, $assignmentId, $studentId);
```

### Advanced Operations

#### 9. Get Subject Assignments
```php
$request = new Request([
    'per_page' => 15,
    'faculty_id' => 1,
    'program_id' => 2,
    'session_id' => 3,
    'semester_id' => 4,
    'status' => 'active'
]);

$subjectAssignments = $assignmentService->getSubjectAssignments($request, $subjectId);
```

#### 10. Get Teacher Assignments
```php
$request = new Request([
    'per_page' => 20,
    'status' => 'active',
    'search' => 'mathematics',
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31'
]);

$teacherAssignments = $assignmentService->getTeacherAssignments($request, $teacherId);
```

#### 11. Get Assignment Statistics
```php
$statistics = $assignmentService->getAssignmentStatistics($assignmentId);
// Returns:
// [
//     'total_students' => 50,
//     'submitted' => 45,
//     'graded' => 40,
//     'pending' => 5,
//     'submission_rate' => 90.0,
//     'grading_rate' => 88.89
// ]
```

## Controller Usage

### API Endpoints

```php
// Get all assignments
GET /api/v1/assignments

// Create assignment
POST /api/v1/assignments
{
    "faculty_id": 1,
    "program_id": 2,
    "session_id": 3,
    "semester_id": 4,
    "section_id": 5,
    "subject_id": 6,
    "title": "Mathematics Assignment",
    "description": "Solve the problems",
    "total_marks": 100,
    "end_date": "2024-01-30"
}

// Get specific assignment
GET /api/v1/assignments/{id}

// Update assignment
PUT /api/v1/assignments/{id}
{
    "title": "Updated Assignment Title",
    "total_marks": 150
}

// Delete assignment
DELETE /api/v1/assignments/{id}

// Get student assignments
GET /api/v1/students/{studentId}/assignments

// Get subject assignments
GET /api/v1/subjects/{subjectId}/assignments

// Get teacher assignments
GET /api/v1/teachers/{teacherId}/assignments

// Submit assignment
POST /api/v1/assignments/{assignmentId}/submit
{
    "student_id": 123,
    "submission": "My solution...",
    "attach": "file.pdf"
}

// Grade assignment
POST /api/v1/assignments/{assignmentId}/students/{studentId}/grade
{
    "marks": 85,
    "feedback": "Good work!"
}

// Get assignment statistics
GET /api/v1/assignments/{id}/statistics
```

## Key Features

### 1. Comprehensive Filtering
- Filter by faculty, program, session, semester, section, subject
- Filter by teacher, status, date ranges
- Search by title and description
- Pagination support

### 2. Student Assignment Management
- Automatic student assignment creation based on enrollment
- Submission tracking with file attachments
- Grading system with feedback
- Status tracking (pending, submitted, graded)

### 3. Notification System
- Automatic notifications to students when assignments are created
- Integration with Laravel's notification system

### 4. Statistics and Analytics
- Submission rates
- Grading progress
- Student performance tracking

### 5. File Management
- Support for multiple file types
- File size validation
- Secure file storage

## Database Relationships

The AssignmentService works with the following relationships:

- **Assignment** belongs to Faculty, Program, Session, Semester, Section, Subject, Teacher
- **StudentAssignment** belongs to Assignment and Student
- **Student** has many StudentAssignments through enrollments

## Error Handling

All methods include comprehensive error handling:

```php
try {
    $assignment = $assignmentService->createAssignment($data);
} catch (Exception $e) {
    Log::error('Assignment creation failed', [
        'error' => $e->getMessage(),
        'data' => $data
    ]);
    // Handle error appropriately
}
```

## Best Practices

1. **Always use transactions** for operations that modify multiple records
2. **Validate input data** using the provided Request classes
3. **Handle exceptions** gracefully with proper logging
4. **Use eager loading** to avoid N+1 query problems
5. **Implement proper authorization** checks in controllers
6. **Use pagination** for large datasets
7. **Cache frequently accessed data** when appropriate

## Integration with University System

The service is designed to work seamlessly with the existing University System patterns:

- Follows the same architectural structure as BookService
- Uses similar validation and resource patterns
- Maintains consistency with existing API responses
- Supports the same filtering and pagination mechanisms

This comprehensive AssignmentService provides all the functionality needed for managing assignments in a college management system while maintaining clean, maintainable, and scalable code.
