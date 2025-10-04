# Assignment Model Scopes Usage Guide

This document provides comprehensive examples of how to use the Assignment model scopes for efficient querying and filtering.

## Overview

The Assignment model includes comprehensive scopes that follow the same pattern as the Book model, providing clean, reusable query methods for common assignment filtering scenarios.

## Available Scopes

### Basic Filtering Scopes

#### 1. Filter by Status
```php
// Get active assignments
$activeAssignments = Assignment::filterByStatus('active')->get();

// Get inactive assignments
$inactiveAssignments = Assignment::filterByStatus('inactive')->get();
```

#### 2. Filter by Academic Entities
```php
// Filter by faculty
$facultyAssignments = Assignment::filterByFaculty(1)->get();

// Filter by program
$programAssignments = Assignment::filterByProgram(2)->get();

// Filter by session
$sessionAssignments = Assignment::filterBySession(3)->get();

// Filter by semester
$semesterAssignments = Assignment::filterBySemester(4)->get();

// Filter by section
$sectionAssignments = Assignment::filterBySection(5)->get();

// Filter by subject
$subjectAssignments = Assignment::filterBySubject(6)->get();

// Filter by teacher
$teacherAssignments = Assignment::filterByTeacher(7)->get();
```

#### 3. Date-Based Filtering
```php
// Filter by start date
$assignments = Assignment::filterByStartDate('2024-01-01')->get();

// Filter by end date
$assignments = Assignment::filterByEndDate('2024-12-31')->get();

// Filter by date range
$assignments = Assignment::filterByDateRange('2024-01-01', '2024-12-31')->get();
```

### Status-Based Scopes

#### 4. Active Assignments
```php
// Get all active assignments
$activeAssignments = Assignment::active()->get();
```

#### 5. Currently Running Assignments
```php
// Get assignments that are currently running (started but not ended)
$runningAssignments = Assignment::currentlyRunning()->get();
```

#### 6. Overdue Assignments
```php
// Get assignments that are overdue
$overdueAssignments = Assignment::overdue()->get();
```

#### 7. Upcoming Assignments
```php
// Get assignments that haven't started yet
$upcomingAssignments = Assignment::upcoming()->get();
```

### Search Scope

#### 8. Search Assignments
```php
// Search by title, description, or subject
$searchResults = Assignment::search('mathematics')->get();
```

### Comprehensive Filtering

#### 9. Filter by Multiple Criteria
```php
// Use the comprehensive filterBy scope
$assignments = Assignment::filterBy([
    'faculty_id' => 1,
    'program_id' => 2,
    'session_id' => 3,
    'semester_id' => 4,
    'section_id' => 5,
    'subject_id' => 6,
    'teacher_id' => 7,
    'status' => 'active',
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31',
    'search' => 'mathematics'
])->get();
```

## Service Layer Usage

### Using Scopes in AssignmentService

The AssignmentService now utilizes these scopes for cleaner, more maintainable code:

```php
// Before (manual filtering)
$query = Assignment::with(['faculty', 'program', 'session'])
    ->when($facultyId, fn($q) => $q->where('faculty_id', $facultyId))
    ->when($programId, fn($q) => $q->where('program_id', $programId))
    ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
    ->when($status, fn($q) => $q->where('status', $status))
    ->when($search, fn($q) => $q->where(function($query) use ($search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }));

// After (using scopes)
$filters = $request->only([
    'faculty_id', 'program_id', 'session_id', 'status', 'search'
]);
$query = Assignment::with(['faculty', 'program', 'session'])
    ->filterBy($filters);
```

### New Service Methods Using Scopes

```php
// Get currently running assignments
$runningAssignments = $assignmentService->getCurrentlyRunningAssignments($request);

// Get overdue assignments
$overdueAssignments = $assignmentService->getOverdueAssignments($request);

// Get upcoming assignments
$upcomingAssignments = $assignmentService->getUpcomingAssignments($request);

// Get active assignments
$activeAssignments = $assignmentService->getActiveAssignments($request);

// Get assignments by date range
$dateRangeAssignments = $assignmentService->getAssignmentsByDateRange(
    $request, 
    '2024-01-01', 
    '2024-12-31'
);
```

## Advanced Usage Examples

### 1. Complex Filtering with Relationships
```php
// Get active assignments for a specific subject with relationships
$assignments = Assignment::with(['faculty', 'program', 'session', 'semester', 'section', 'subject', 'teacher'])
    ->filterBySubject(6)
    ->active()
    ->currentlyRunning()
    ->orderBy('end_date', 'asc')
    ->get();
```

### 2. Teacher Dashboard Queries
```php
// Get teacher's currently running assignments
$teacherRunningAssignments = Assignment::with(['subject', 'program'])
    ->filterByTeacher($teacherId)
    ->currentlyRunning()
    ->orderBy('end_date', 'asc')
    ->get();

// Get teacher's overdue assignments
$teacherOverdueAssignments = Assignment::with(['subject', 'program'])
    ->filterByTeacher($teacherId)
    ->overdue()
    ->orderBy('end_date', 'desc')
    ->get();
```

### 3. Student Dashboard Queries
```php
// Get student's upcoming assignments
$studentUpcomingAssignments = Assignment::with(['subject', 'teacher'])
    ->whereHas('students', function ($q) use ($studentId) {
        $q->where('student_id', $studentId);
    })
    ->upcoming()
    ->orderBy('start_date', 'asc')
    ->get();

// Get student's currently running assignments
$studentRunningAssignments = Assignment::with(['subject', 'teacher'])
    ->whereHas('students', function ($q) use ($studentId) {
        $q->where('student_id', $studentId);
    })
    ->currentlyRunning()
    ->orderBy('end_date', 'asc')
    ->get();
```

### 4. Academic Calendar Queries
```php
// Get assignments for a specific month
$monthlyAssignments = Assignment::with(['subject', 'teacher'])
    ->filterByDateRange('2024-01-01', '2024-01-31')
    ->active()
    ->orderBy('start_date', 'asc')
    ->get();

// Get assignments for a specific week
$weeklyAssignments = Assignment::with(['subject', 'teacher'])
    ->filterByDateRange('2024-01-15', '2024-01-21')
    ->active()
    ->orderBy('start_date', 'asc')
    ->get();
```

### 5. Analytics and Reporting
```php
// Get assignment statistics by faculty
$facultyStats = Assignment::filterByFaculty(1)
    ->selectRaw('
        COUNT(*) as total_assignments,
        COUNT(CASE WHEN status = "active" THEN 1 END) as active_assignments,
        COUNT(CASE WHEN end_date < CURDATE() THEN 1 END) as overdue_assignments
    ')
    ->first();

// Get assignment trends by month
$monthlyTrends = Assignment::filterByDateRange('2024-01-01', '2024-12-31')
    ->selectRaw('
        MONTH(start_date) as month,
        COUNT(*) as assignment_count
    ')
    ->groupBy('month')
    ->orderBy('month')
    ->get();
```

## Performance Benefits

### 1. Query Optimization
- Scopes are reusable and consistent
- Reduces code duplication
- Better query performance through proper indexing
- Cleaner, more readable code

### 2. Maintainability
- Centralized filtering logic
- Easy to modify filtering behavior
- Consistent API across the application
- Better testing capabilities

### 3. Flexibility
- Easy to combine multiple scopes
- Simple to add new filtering criteria
- Consistent with Laravel conventions
- Follows the same pattern as Book model

## Best Practices

### 1. Scope Naming
- Use descriptive names: `filterByFaculty`, `currentlyRunning`
- Follow consistent naming patterns
- Use camelCase for scope names

### 2. Scope Implementation
- Keep scopes simple and focused
- Use proper type hints
- Include comprehensive documentation
- Handle edge cases appropriately

### 3. Usage Guidelines
- Combine scopes for complex queries
- Use eager loading with scopes
- Consider query performance
- Test scope combinations thoroughly

### 4. Service Integration
- Use scopes in service methods
- Maintain clean separation of concerns
- Document scope usage in services
- Consider caching for frequently used queries

## Migration from Manual Filtering

### Before (Manual Filtering)
```php
$query = Assignment::with(['faculty', 'program', 'session'])
    ->when($facultyId, fn($q) => $q->where('faculty_id', $facultyId))
    ->when($programId, fn($q) => $q->where('program_id', $programId))
    ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
    ->when($status, fn($q) => $q->where('status', $status))
    ->when($search, fn($q) => $q->where(function($query) use ($search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }));
```

### After (Using Scopes)
```php
$filters = $request->only([
    'faculty_id', 'program_id', 'session_id', 'status', 'search'
]);
$query = Assignment::with(['faculty', 'program', 'session'])
    ->filterBy($filters);
```

This approach provides:
- **Cleaner Code**: Less repetitive filtering logic
- **Better Maintainability**: Centralized scope definitions
- **Consistency**: Same pattern as Book model
- **Performance**: Optimized queries through proper scoping
- **Flexibility**: Easy to combine and extend scopes

The Assignment model scopes provide a powerful, flexible, and maintainable way to query assignments while following Laravel best practices and maintaining consistency with your existing Book model implementation.
