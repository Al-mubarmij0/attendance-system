<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming your students and lecturers are in the User model
use App\Models\Lecturer;
use App\Models\Course;
use App\Models\Department;
use App\Models\Registration; // If you have this model for handling registrations

class AdminController extends Controller
{
    // Dashboard
    public function index()
    {
        // Fetching actual data
        $totalStudents = User::where('role', 'student')->count(); // Counting students
        $totalLecturers = Lecturer::count(); // Counting lecturers
        $totalCourses = Course::count(); // Counting courses
        $totalDepartments = Department::count(); // Counting departments
        $pendingRegistrations = Registration::where('status', 'pending')->count(); // Counting pending registrations

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalLecturers',
            'totalCourses',
            'totalDepartments',
            'pendingRegistrations'
        ));
    }

    // Students Management Index
    public function studentsIndex()
    {
        // Fetching actual students data
        $students = User::where('role', 'student')->paginate(10); // Paginate students, 10 per page
        return view('admin.students.index', compact('students'));
    }

    // Students Create Form
    public function studentsCreate()
    {
        return view('admin.students.create');
    }

    // Store New Student
    public function studentsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Add other student-specific fields here
        ]);

        // Store the new student
        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student', // Set the role as student
            // Add other student-specific fields here
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
    }

    // Edit Student Form
    public function studentsEdit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    // Update Student Details
    public function studentsUpdate(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            // Add other student-specific validation rules here
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            // Update other fields as necessary
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    // Delete Student
    public function studentsDestroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }

    // Lecturers Management Index
    public function lecturersIndex()
    {
        $lecturers = Lecturer::paginate(10); // Paginate lecturers, 10 per page
        return view('admin.lecturers.index', compact('lecturers'));
    }

    // Create Lecturer Form
    public function lecturersCreate()
    {
        return view('admin.lecturers.create');
    }

    // Store New Lecturer
    public function lecturersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers',
            // Add other lecturer-specific fields here
        ]);

        // Store the new lecturer
        Lecturer::create([
            'name' => $request->name,
            'email' => $request->email,
            // Add other lecturer-specific fields here
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer created successfully!');
    }

    // Edit Lecturer Form
    public function lecturersEdit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    // Update Lecturer Details
    public function lecturersUpdate(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            // Add other lecturer-specific validation rules here
        ]);

        $lecturer->update([
            'name' => $request->name,
            'email' => $request->email,
            // Update other fields as necessary
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer updated successfully!');
    }

    // Delete Lecturer
    public function lecturersDestroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer deleted successfully!');
    }

    // Courses Management Index
    public function coursesIndex()
    {
        $courses = Course::paginate(10); // Paginate courses, 10 per page
        return view('admin.courses.index', compact('courses'));
    }

    // Create Course Form
    public function coursesCreate()
    {
        return view('admin.courses.create');
    }

    // Store New Course
    public function coursesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|string',
            'level' => 'required|string',
            // Add other course-specific fields here
        ]);

        // Store the new course
        Course::create([
            'name' => $request->name,
            'semester' => $request->semester,
            'level' => $request->level,
            // Add other course-specific fields here
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    // Edit Course Form
    public function coursesEdit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    // Update Course Details
    public function coursesUpdate(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|string',
            'level' => 'required|string',
            // Add other course-specific validation rules here
        ]);

        $course->update([
            'name' => $request->name,
            'semester' => $request->semester,
            'level' => $request->level,
            // Update other fields as necessary
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    // Delete Course
    public function coursesDestroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    // Departments Management Index
    public function departmentsIndex()
    {
        $departments = Department::paginate(10); // Paginate departments, 10 per page
        return view('admin.departments.index', compact('departments'));
    }

    // Create Department Form
    public function departmentsCreate()
    {
        return view('admin.departments.create');
    }

    // Store New Department
    public function departmentsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully!');
    }

    // Edit Department Form
    public function departmentsEdit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    // Update Department Details
    public function departmentsUpdate(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully!');
    }

    // Delete Department
    public function departmentsDestroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully!');
    }
}
