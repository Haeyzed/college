<?php

use App\Http\Controllers\v1\AcademicController;
use App\Http\Controllers\v1\AttendanceController;
use App\Http\Controllers\v1\BatchController;
use App\Http\Controllers\v1\DashboardController;
use App\Http\Controllers\v1\DistrictController;
use App\Http\Controllers\v1\EventController;
use App\Http\Controllers\v1\ExamController;
use App\Http\Controllers\v1\FacultyController;
use App\Http\Controllers\v1\HostelController;
use App\Http\Controllers\v1\LibraryController;
use App\Http\Controllers\v1\NoticeController;
use App\Http\Controllers\v1\ProgramController;
use App\Http\Controllers\v1\ProvinceController;
use App\Http\Controllers\v1\ReportController;
use App\Http\Controllers\v1\SemesterController;
use App\Http\Controllers\v1\SessionController;
use App\Http\Controllers\v1\StudentController;
use App\Http\Controllers\v1\SubjectController;
use App\Http\Controllers\v1\TransportController;
use App\Http\Controllers\v1\UtilityController;
use Illuminate\Support\Facades\Route;

/**
 * College Management System API Routes - Version 1
 *
 * This file contains all API routes for version 1 of the College Management System.
 * Routes are organized by functionality and include proper middleware for authentication
 * and authorization using Laravel Sanctum.
 *
 * @package Routes\Api\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */

// API Version 1 Routes
Route::prefix('v1')->group(function () {

    // Authentication Routes
//    Route::prefix('auth')->group(function () {
//        // Public authentication routes
//        Route::post('/login', [AuthController::class, 'login']);
//        Route::post('/register', [AuthController::class, 'register']);
//        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
//        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
//
//        // Protected authentication routes
//        Route::middleware(['auth:sanctum'])->group(function () {
//            Route::post('/logout', [AuthController::class, 'logout']);
//            Route::get('/user', [AuthController::class, 'user']);
//            Route::post('/change-password', [AuthController::class, 'changePassword']);
//            Route::post('/refresh', [AuthController::class, 'refresh']);
//        });
//    });

    // Public Routes (No Authentication Required)
    // Route::prefix('public')->group(function () {
    //     // Get active faculties
    //     Route::get('/faculties', [FacultyController::class, 'getActiveFaculties']);

    //     // Get active programs by faculty
    //     Route::get('/faculties/{facultyId}/programs', [ProgramController::class, 'getProgramsByFaculty']);

    //     // Get active batches
    //     Route::get('/batches', [BatchController::class, 'getActiveBatches']);

    //     // Get provinces and districts
    //     Route::get('/provinces', [ProvinceController::class, 'getActiveProvinces']);
    //     Route::get('/provinces/{provinceId}/districts', [DistrictController::class, 'getDistrictsByProvince']);
    // });

    // Protected Routes (Authentication Required)
    // Route::middleware(['auth:sanctum'])->group(function () {

    // Application Management Routes
    // Route::prefix('applications')->group(function () {
    //     Route::get('/', [ApplicationController::class, 'index']);
    //     Route::post('/', [ApplicationController::class, 'store']);
    //     Route::get('/{id}', [ApplicationController::class, 'show']);
    //     Route::put('/{id}', [ApplicationController::class, 'update']);
    //     Route::delete('/{id}', [ApplicationController::class, 'destroy']);

    //     // Application specific actions
    //     Route::post('/{id}/approve', [ApplicationController::class, 'approve']);
    //     Route::post('/{id}/reject', [ApplicationController::class, 'reject']);
    //     Route::get('/statistics/overview', [ApplicationController::class, 'statistics']);

    //     // Convert application to student
    //     Route::post('/{id}/convert-to-student', [ApplicationController::class, 'convertToStudent']);
    // });

    // Student Management Routes
    // Route::prefix('students')->group(function () {
    //     Route::get('/', [StudentController::class, 'index']);
    //     Route::post('/', [StudentController::class, 'store']);
    //     Route::get('/{id}', [StudentController::class, 'show']);
    //     Route::put('/{id}', [StudentController::class, 'update']);
    //     Route::delete('/{id}', [StudentController::class, 'destroy']);

    //     // Student specific actions
    //     Route::post('/{id}/enroll', [StudentController::class, 'enroll']);
    //     Route::post('/{id}/transfer', [StudentController::class, 'transfer']);
    //     Route::post('/{id}/activate', [StudentController::class, 'activate']);
    //     Route::post('/{id}/deactivate', [StudentController::class, 'deactivate']);
    //     Route::get('/statistics/overview', [StudentController::class, 'statistics']);

    //     // Student enrollments
    //     Route::get('/{id}/enrollments', [StudentController::class, 'getEnrollments']);
    //     Route::get('/{id}/current-enrollment', [StudentController::class, 'getCurrentEnrollment']);
    // });

    // Program Management Routes
    // Route::prefix('programs')->group(function () {
    //     Route::get('/', [ProgramController::class, 'index']);
    //     Route::post('/', [ProgramController::class, 'store']);
    //     Route::get('/{id}', [ProgramController::class, 'show']);
    //     Route::put('/{id}', [ProgramController::class, 'update']);
    //     Route::delete('/{id}', [ProgramController::class, 'destroy']);

    //     // Program relationships
    //     Route::post('/{id}/batches', [ProgramController::class, 'attachBatches']);
    //     Route::delete('/{id}/batches', [ProgramController::class, 'detachBatches']);
    //     Route::post('/{id}/subjects', [ProgramController::class, 'attachSubjects']);
    //     Route::delete('/{id}/subjects', [ProgramController::class, 'detachSubjects']);
    //     Route::post('/{id}/semesters', [ProgramController::class, 'attachSemesters']);
    //     Route::delete('/{id}/semesters', [ProgramController::class, 'detachSemesters']);
    //     Route::post('/{id}/sessions', [ProgramController::class, 'attachSessions']);
    //     Route::delete('/{id}/sessions', [ProgramController::class, 'detachSessions']);

    //     Route::get('/statistics/overview', [ProgramController::class, 'statistics']);
    // });

    // Faculty Management Routes
    // Route::prefix('faculties')->group(function () {
    //     Route::get('/', [FacultyController::class, 'index']);
    //     Route::post('/', [FacultyController::class, 'store']);
    //     Route::get('/{id}', [FacultyController::class, 'show']);
    //     Route::put('/{id}', [FacultyController::class, 'update']);
    //     Route::delete('/{id}', [FacultyController::class, 'destroy']);
    //     Route::get('/statistics/overview', [FacultyController::class, 'statistics']);
    // });

    // Batch Management Routes
    // Route::prefix('batches')->group(function () {
    //     Route::get('/', [BatchController::class, 'index']);
    //     Route::post('/', [BatchController::class, 'store']);
    //     Route::get('/{id}', [BatchController::class, 'show']);
    //     Route::put('/{id}', [BatchController::class, 'update']);
    //     Route::delete('/{id}', [BatchController::class, 'destroy']);
    //     Route::get('/statistics/overview', [BatchController::class, 'statistics']);
    // });

    // Session Management Routes
    // Route::prefix('sessions')->group(function () {
    //     Route::get('/', [SessionController::class, 'index']);
    //     Route::post('/', [SessionController::class, 'store']);
    //     Route::get('/{id}', [SessionController::class, 'show']);
    //     Route::put('/{id}', [SessionController::class, 'update']);
    //     Route::delete('/{id}', [SessionController::class, 'destroy']);
    //     Route::get('/statistics/overview', [SessionController::class, 'statistics']);
    // });

    // Semester Management Routes
    // Route::prefix('semesters')->group(function () {
    //     Route::get('/', [SemesterController::class, 'index']);
    //     Route::post('/', [SemesterController::class, 'store']);
    //     Route::get('/{id}', [SemesterController::class, 'show']);
    //     Route::put('/{id}', [SemesterController::class, 'update']);
    //     Route::delete('/{id}', [SemesterController::class, 'destroy']);
    //     Route::get('/statistics/overview', [SemesterController::class, 'statistics']);
    // });

    // Subject Management Routes
    // Route::prefix('subjects')->group(function () {
    //     Route::get('/', [SubjectController::class, 'index']);
    //     Route::post('/', [SubjectController::class, 'store']);
    //     Route::get('/{id}', [SubjectController::class, 'show']);
    //     Route::put('/{id}', [SubjectController::class, 'update']);
    //     Route::delete('/{id}', [SubjectController::class, 'destroy']);
    //     Route::get('/statistics/overview', [SubjectController::class, 'statistics']);
    // });

    // Province Management Routes
    // Route::prefix('provinces')->group(function () {
    //     Route::get('/', [ProvinceController::class, 'index']);
    //     Route::post('/', [ProvinceController::class, 'store']);
    //     Route::get('/{id}', [ProvinceController::class, 'show']);
    //     Route::put('/{id}', [ProvinceController::class, 'update']);
    //     Route::delete('/{id}', [ProvinceController::class, 'destroy']);
    // });

    // District Management Routes
    // Route::prefix('districts')->group(function () {
    //     Route::get('/', [DistrictController::class, 'index']);
    //     Route::post('/', [DistrictController::class, 'store']);
    //     Route::get('/{id}', [DistrictController::class, 'show']);
    //     Route::put('/{id}', [DistrictController::class, 'update']);
    //     Route::delete('/{id}', [DistrictController::class, 'destroy']);
    // });

    // Assignment Management Routes
    // Route::prefix('assignments')->group(function () {
    //     Route::get('/', [AssignmentController::class, 'index']);
    //     Route::post('/', [AssignmentController::class, 'store']);
    //     Route::get('/{id}', [AssignmentController::class, 'show']);
    //     Route::put('/{id}', [AssignmentController::class, 'update']);
    //     Route::delete('/{id}', [AssignmentController::class, 'destroy']);
    //     Route::get('/student/{studentId}', [AssignmentController::class, 'getStudentAssignments']);
    //     Route::get('/subject/{subjectId}', [AssignmentController::class, 'getSubjectAssignments']);
    //     Route::post('/{id}/submit', [AssignmentController::class, 'submitAssignment']);
    //     Route::post('/{id}/grade/{studentId}', [AssignmentController::class, 'gradeAssignment']);
    // });

    // Academic Routes
    Route::prefix('academic')->group(function () {
        // Faculty Routes
        Route::get('/faculties', [AcademicController::class, 'getFaculties']);
        Route::get('/faculties/{id}', [AcademicController::class, 'getFaculty']);
        Route::post('/faculties', [AcademicController::class, 'createFaculty']);
        Route::put('/faculties/{id}', [AcademicController::class, 'updateFaculty']);
        Route::delete('/faculties/{id}', [AcademicController::class, 'deleteFaculty']);
        Route::post('/faculties/bulk-status', [AcademicController::class, 'bulkUpdateFacultyStatus']);
        Route::delete('/faculties/bulk-delete', [AcademicController::class, 'bulkDeleteFaculties']);

        // Program Routes
        Route::get('/programs', [AcademicController::class, 'getPrograms']);
        Route::get('/programs/{id}', [AcademicController::class, 'getProgram']);
        Route::post('/programs', [AcademicController::class, 'createProgram']);
        Route::put('/programs/{id}', [AcademicController::class, 'updateProgram']);
        Route::delete('/programs/{id}', [AcademicController::class, 'deleteProgram']);
        Route::post('/programs/bulk-status', [AcademicController::class, 'bulkUpdateProgramStatus']);
        Route::delete('/programs/bulk-delete', [AcademicController::class, 'bulkDeletePrograms']);

        // Batch Routes
        Route::get('/batches', [AcademicController::class, 'getBatches']);
        Route::get('/batches/{id}', [AcademicController::class, 'getBatch']);
        Route::post('/batches', [AcademicController::class, 'createBatch']);
        Route::put('/batches/{id}', [AcademicController::class, 'updateBatch']);
        Route::delete('/batches/{id}', [AcademicController::class, 'deleteBatch']);
        Route::post('/batches/bulk-status', [AcademicController::class, 'bulkUpdateBatchStatus']);
        Route::delete('/batches/bulk-delete', [AcademicController::class, 'bulkDeleteBatches']);

        // Section Routes
        Route::get('/sections', [AcademicController::class, 'getSections']);
        Route::get('/sections/{id}', [AcademicController::class, 'getSection']);
        Route::post('/sections', [AcademicController::class, 'createSection']);
        Route::put('/sections/{id}', [AcademicController::class, 'updateSection']);
        Route::delete('/sections/{id}', [AcademicController::class, 'deleteSection']);
        Route::post('/sections/bulk-status', [AcademicController::class, 'bulkUpdateSectionStatus']);
        Route::delete('/sections/bulk-delete', [AcademicController::class, 'bulkDeleteSections']);

        // Semester Routes
        Route::get('/semesters', [AcademicController::class, 'getSemesters']);
        Route::get('/semesters/{id}', [AcademicController::class, 'getSemester']);
        Route::post('/semesters', [AcademicController::class, 'createSemester']);
        Route::put('/semesters/{id}', [AcademicController::class, 'updateSemester']);
        Route::delete('/semesters/{id}', [AcademicController::class, 'deleteSemester']);
        Route::post('/semesters/bulk-status', [AcademicController::class, 'bulkUpdateSemesterStatus']);
        Route::delete('/semesters/bulk-delete', [AcademicController::class, 'bulkDeleteSemesters']);

        // Subject Routes
        Route::get('/subjects', [AcademicController::class, 'getSubjects']);
        Route::get('/subjects/{id}', [AcademicController::class, 'getSubject']);
        Route::post('/subjects', [AcademicController::class, 'createSubject']);
        Route::put('/subjects/{id}', [AcademicController::class, 'updateSubject']);
        Route::delete('/subjects/{id}', [AcademicController::class, 'deleteSubject']);
        Route::post('/subjects/bulk-status', [AcademicController::class, 'bulkUpdateSubjectStatus']);
        Route::delete('/subjects/bulk-delete', [AcademicController::class, 'bulkDeleteSubjects']);

        // Academic Session Routes
        Route::get('/academic-sessions', [AcademicController::class, 'getAcademicSessions']);
        Route::get('/academic-sessions/{id}', [AcademicController::class, 'getAcademicSession']);
        Route::post('/academic-sessions', [AcademicController::class, 'createAcademicSession']);
        Route::put('/academic-sessions/{id}', [AcademicController::class, 'updateAcademicSession']);
        Route::delete('/academic-sessions/{id}', [AcademicController::class, 'deleteAcademicSession']);
        Route::post('/academic-sessions/bulk-status', [AcademicController::class, 'bulkUpdateAcademicSessionStatus']);
        Route::delete('/academic-sessions/bulk-delete', [AcademicController::class, 'bulkDeleteAcademicSessions']);
        Route::post('/academic-sessions/{id}/set-current', [AcademicController::class, 'setCurrentAcademicSession']);

        // Classroom Routes
        Route::get('/classrooms', [AcademicController::class, 'getClassRooms']);
        Route::get('/classrooms/{id}', [AcademicController::class, 'getClassRoom']);
        Route::post('/classrooms', [AcademicController::class, 'createClassRoom']);
        Route::put('/classrooms/{id}', [AcademicController::class, 'updateClassRoom']);
        Route::delete('/classrooms/{id}', [AcademicController::class, 'deleteClassRoom']);
        Route::post('/classrooms/bulk-status', [AcademicController::class, 'bulkUpdateClassRoomStatus']);
        Route::delete('/classrooms/bulk-delete', [AcademicController::class, 'bulkDeleteClassRooms']);

        // Enroll Subject Routes
        Route::get('/enroll-subjects', [AcademicController::class, 'getEnrollSubjects']);
        Route::get('/enroll-subjects/{id}', [AcademicController::class, 'getEnrollSubject']);
        Route::post('/enroll-subjects', [AcademicController::class, 'createEnrollSubject']);
        Route::put('/enroll-subjects/{id}', [AcademicController::class, 'updateEnrollSubject']);
        Route::delete('/enroll-subjects/{id}', [AcademicController::class, 'deleteEnrollSubject']);
        Route::post('/enroll-subjects/bulk-status', [AcademicController::class, 'bulkUpdateEnrollSubjectStatus']);
        Route::delete('/enroll-subjects/bulk-delete', [AcademicController::class, 'bulkDeleteEnrollSubjects']);
    });

    // Library Management Routes
    Route::prefix('library')->group(function () {

        // Books Management
        Route::prefix('books')->group(function () {
            // Individual Book Operations
            Route::get('/', [LibraryController::class, 'getBooks']);
            Route::post('/', [LibraryController::class, 'createBook']);
            Route::get('/{id}', [LibraryController::class, 'getBook']);
            Route::put('/{id}', [LibraryController::class, 'updateBook']);
            Route::delete('/{id}', [LibraryController::class, 'deleteBook']);
            Route::delete('/{id}/force', [LibraryController::class, 'forceDeleteBook']);

            // Bulk Book Operations
            Route::post('/bulk/status', [LibraryController::class, 'bulkUpdateBookStatus']);
            Route::post('/bulk/delete', [LibraryController::class, 'bulkDeleteBooks']);
            Route::post('/bulk/force-delete', [LibraryController::class, 'bulkForceDeleteBooks']);

            // Book Import/Export
            Route::post('/import', [LibraryController::class, 'importBooks']);
            Route::get('/import/template', [LibraryController::class, 'getBookImportTemplate']);
        });

        // Book Categories Management
        Route::prefix('categories')->group(function () {
            // Individual Category Operations
            Route::get('/', [LibraryController::class, 'getBookCategories']);
            Route::post('/', [LibraryController::class, 'createBookCategory']);
            Route::get('/{id}', [LibraryController::class, 'getBookCategory']);
            Route::put('/{id}', [LibraryController::class, 'updateBookCategory']);
            Route::delete('/{id}', [LibraryController::class, 'deleteBookCategory']);

            // Bulk Category Operations
            Route::post('/bulk/status', [LibraryController::class, 'bulkUpdateBookCategoryStatus']);
            Route::post('/bulk/delete', [LibraryController::class, 'bulkDeleteBookCategories']);
        });

        // Book Requests Management
        Route::prefix('requests')->group(function () {
            // Individual Request Operations
            Route::get('/', [LibraryController::class, 'getBookRequests']);
            Route::post('/', [LibraryController::class, 'createBookRequest']);
            Route::get('/{id}', [LibraryController::class, 'getBookRequest']);
            Route::put('/{id}', [LibraryController::class, 'updateBookRequest']);
            Route::delete('/{id}', [LibraryController::class, 'deleteBookRequest']);
            Route::delete('/{id}/force', [LibraryController::class, 'forceDeleteBookRequest']);

            // Bulk Request Operations
            Route::post('/bulk/status', [LibraryController::class, 'bulkUpdateBookRequestStatus']);
            Route::post('/bulk/delete', [LibraryController::class, 'bulkDeleteBookRequests']);
            Route::post('/bulk/force-delete', [LibraryController::class, 'bulkForceDeleteBookRequests']);
        });

        // Book Issues/Returns Management
        Route::prefix('issues')->group(function () {
            // Issue/Return Operations
            Route::post('/issue', [LibraryController::class, 'issueBook']);
            Route::post('/return', [LibraryController::class, 'returnBook']);
            Route::get('/', [LibraryController::class, 'getBookIssues']);
        });

        // Library Settings
        Route::prefix('settings')->group(function () {
            // ID Card Settings
            Route::get('/id-card', [LibraryController::class, 'getIdCardSetting']);
            Route::post('/id-card', [LibraryController::class, 'updateIdCardSetting']);
        });
    });

    // Fee Management Routes
    // Route::prefix('fees')->group(function () {
    //     Route::get('/', [FeeController::class, 'index']);
    //     Route::post('/', [FeeController::class, 'store']);
    //     Route::get('/{id}', [FeeController::class, 'show']);
    //     Route::put('/{id}', [FeeController::class, 'update']);
    //     Route::delete('/{id}', [FeeController::class, 'destroy']);
    //     Route::get('/student/{studentId}', [FeeController::class, 'getStudentFees']);
    //     Route::post('/{id}/pay', [FeeController::class, 'payFee']);
    //     Route::get('/overdue', [FeeController::class, 'getOverdueFees']);
    // });

    // Notice Management Routes
    // Route::prefix('notices')->group(function () {
    //     Route::get('/', [NoticeController::class, 'index']);
    //     Route::post('/', [NoticeController::class, 'store']);
    //     Route::get('/{id}', [NoticeController::class, 'show']);
    //     Route::put('/{id}', [NoticeController::class, 'update']);
    //     Route::delete('/{id}', [NoticeController::class, 'destroy']);
    //     Route::get('/faculty/{facultyId}', [NoticeController::class, 'getFacultyNotices']);
    //     Route::get('/program/{programId}', [NoticeController::class, 'getProgramNotices']);
    // });

    // Event Management Routes
    // Route::prefix('events')->group(function () {
    //     Route::get('/', [EventController::class, 'index']);
    //     Route::post('/', [EventController::class, 'store']);
    //     Route::get('/{id}', [EventController::class, 'show']);
    //     Route::put('/{id}', [EventController::class, 'update']);
    //     Route::delete('/{id}', [EventController::class, 'destroy']);
    //     Route::get('/upcoming', [EventController::class, 'getUpcomingEvents']);
    // });

    // Hostel Management Routes
    // Route::prefix('hostels')->group(function () {
    //     Route::get('/', [HostelController::class, 'index']);
    //     Route::post('/', [HostelController::class, 'store']);
    //     Route::get('/{id}', [HostelController::class, 'show']);
    //     Route::put('/{id}', [HostelController::class, 'update']);
    //     Route::delete('/{id}', [HostelController::class, 'destroy']);
    //     Route::get('/{id}/rooms', [HostelController::class, 'getRooms']);
    //     Route::post('/{id}/allocate', [HostelController::class, 'allocateRoom']);
    // });

    // Attendance Management Routes
    // Route::prefix('attendance')->group(function () {
    //     Route::get('/', [AttendanceController::class, 'index']);
    //     Route::post('/', [AttendanceController::class, 'store']);
    //     Route::get('/{id}', [AttendanceController::class, 'show']);
    //     Route::put('/{id}', [AttendanceController::class, 'update']);
    //     Route::delete('/{id}', [AttendanceController::class, 'destroy']);
    //     Route::get('/student/{studentId}', [AttendanceController::class, 'getStudentAttendance']);
    //     Route::get('/subject/{subjectId}', [AttendanceController::class, 'getSubjectAttendance']);
    // });

    // Exam Management Routes
    // Route::prefix('exams')->group(function () {
    //     Route::get('/', [ExamController::class, 'index']);
    //     Route::post('/', [ExamController::class, 'store']);
    //     Route::get('/{id}', [ExamController::class, 'show']);
    //     Route::put('/{id}', [ExamController::class, 'update']);
    //     Route::delete('/{id}', [ExamController::class, 'destroy']);
    //     Route::get('/student/{studentId}', [ExamController::class, 'getStudentExams']);
    //     Route::post('/{id}/register', [ExamController::class, 'registerStudent']);
    // });

    // Library Management Routes
    // Route::prefix('library')->group(function () {
    //     Route::get('/members', [LibraryController::class, 'getMembers']);
    //     Route::post('/members', [LibraryController::class, 'addMember']);
    //     Route::get('/transactions', [LibraryController::class, 'getTransactions']);
    // });

    // // Transport Management Routes
    // Route::prefix('transport')->group(function () {
    //     Route::get('/', [TransportController::class, 'index']);
    //     Route::post('/', [TransportController::class, 'store']);
    //     Route::get('/{id}', [TransportController::class, 'show']);
    //     Route::put('/{id}', [TransportController::class, 'update']);
    //     Route::delete('/{id}', [TransportController::class, 'destroy']);
    //     Route::get('/routes', [TransportController::class, 'getRoutes']);
    //     Route::get('/vehicles', [TransportController::class, 'getVehicles']);
    // });

    // // Report Routes
    // Route::prefix('reports')->group(function () {
    //     Route::get('/students', [ReportController::class, 'studentsReport']);
    //     Route::get('/fees', [ReportController::class, 'feesReport']);
    //     Route::get('/attendance', [ReportController::class, 'attendanceReport']);
    //     Route::get('/exams', [ReportController::class, 'examsReport']);
    // });

    // // Export/Import Routes
    // Route::prefix('export')->group(function () {
    //     Route::get('/applications', [ApplicationController::class, 'export']);
    //     Route::get('/students', [StudentController::class, 'export']);
    //     Route::get('/programs', [ProgramController::class, 'export']);
    // });

    // Route::prefix('import')->group(function () {
    //     Route::post('/applications', [ApplicationController::class, 'import']);
    //     Route::post('/students', [StudentController::class, 'import']);
    //     Route::post('/programs', [ProgramController::class, 'import']);
    // });

    // // Dashboard and Analytics Routes
    // Route::prefix('dashboard')->group(function () {
    //     Route::get('/overview', [ApplicationController::class, 'dashboardOverview']);
    //     Route::get('/recent-activities', [ApplicationController::class, 'recentActivities']);
    //     Route::get('/statistics', [ApplicationController::class, 'dashboardStatistics']);
    // });

    // // Settings Management Routes
    // Route::prefix('settings')->group(function () {
    //     // Application Settings
    //     Route::get('/application', [ApplicationSettingsController::class, 'index']);
    //     Route::put('/application', [ApplicationSettingsController::class, 'update']);

    //     // Mail Settings
    //     Route::get('/mail', [MailSettingsController::class, 'index']);
    //     Route::put('/mail', [MailSettingsController::class, 'update']);

    //     // SMS Settings
    //     Route::get('/sms', [SmsSettingsController::class, 'index']);
    //     Route::put('/sms', [SmsSettingsController::class, 'update']);

    //     // Social Settings
    //     Route::get('/social', [SocialSettingsController::class, 'index']);
    //     Route::put('/social', [SocialSettingsController::class, 'update']);

    //     // System Settings
    //     Route::get('/system', [SystemSettingsController::class, 'index']);
    //     Route::put('/system', [SystemSettingsController::class, 'update']);

    //     // ID Card Settings
    //     Route::get('/id-card', [IdCardSettingsController::class, 'index']);
    //     Route::put('/id-card', [IdCardSettingsController::class, 'update']);

    //     // Marksheet Settings
    //     Route::get('/marksheet', [MarksheetSettingsController::class, 'index']);
    //     Route::put('/marksheet', [MarksheetSettingsController::class, 'update']);

    //     // Print Settings
    //     Route::get('/print', [PrintSettingsController::class, 'index']);
    //     Route::post('/print', [PrintSettingsController::class, 'update']);

    //     // Tax Settings
    //     Route::get('/tax', [TaxSettingsController::class, 'index']);
    //     Route::put('/tax', [TaxSettingsController::class, 'update']);

    //     // Schedule Settings
    //     Route::get('/schedule', [ScheduleSettingsController::class, 'index']);
    //     Route::put('/schedule', [ScheduleSettingsController::class, 'update']);

    //     // Topbar Settings
    //     Route::get('/topbar', [TopbarSettingsController::class, 'index']);
    //     Route::put('/topbar', [TopbarSettingsController::class, 'update']);
    // });

    // Utility Routes
    Route::prefix('utility')->group(function () {
        Route::get('/book-status-enum', [UtilityController::class, 'getBookStatusEnum']);
        Route::get('/book-category-status-enum', [UtilityController::class, 'getBookCategoryStatusEnum']);
        Route::get('/book-request-status-enum', [UtilityController::class, 'getBookRequestStatusEnum']);
        Route::get('/member-type-enum', [UtilityController::class, 'getMemberTypeEnum']);
        Route::get('/issue-status-enum', [UtilityController::class, 'getIssueStatusEnum']);
        Route::get('/status-enum', [UtilityController::class, 'getStatusEnum']);
        Route::get('/database-stats', [UtilityController::class, 'getDatabaseStats']);
        Route::get('/system-info', [UtilityController::class, 'getSystemInfo']);
    });

    // File Upload Routes
    // Route::prefix('files')->group(function () {
    //     Route::post('/upload/document', [FileUploadController::class, 'uploadDocument']);
    //     Route::post('/upload/image', [FileUploadController::class, 'uploadImage']);
    //     Route::post('/upload/multiple', [FileUploadController::class, 'uploadMultipleFiles']);
    //     Route::put('/update', [FileUploadController::class, 'updateFile']);
    //     Route::delete('/delete', [FileUploadController::class, 'deleteFile']);
    //     Route::get('/info', [FileUploadController::class, 'getFileInfo']);
    //     Route::get('/supported-types', [FileUploadController::class, 'getSupportedFileTypes']);
    //     Route::get('/allowed-extensions', [FileUploadController::class, 'getAllowedExtensions']);
    //     Route::get('/check-type', [FileUploadController::class, 'isFileTypeSupported']);
    // });
    // });
});
