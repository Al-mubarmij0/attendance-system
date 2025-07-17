<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    // Display the list of students
    public function index()
    {
        $students = Student::with('user')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    // Show form to create a new student
    public function create()
    {
        return view('admin.students.create');
    }

    // Store the new student and generate barcode + QR code
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'index_number' => 'required|string|unique:students,index_number',
            'department' => 'required|string',
            'level' => 'required|string',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        // Generate and save barcode
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcode = $barcodeGenerator->getBarcode($validated['index_number'], $barcodeGenerator::TYPE_CODE_128);
        $barcodePath = 'barcodes/' . str_replace('/', '_', $validated['index_number']) . '.png';
        Storage::disk('public')->put($barcodePath, $barcode);

        // Generate and save QR code
        $qrCodePath = 'qrcodes/' . $user->id . '.png';
       $qrImage = \QrCode::format('png')->size(200)->generate($validated['index_number']);
        Storage::disk('public')->put($qrCodePath, $qrImage);

        // Create student and store paths
        $student = Student::create([
            'user_id' => $user->id,
            'index_number' => $validated['index_number'],
            'department' => $validated['department'],
            'level' => $validated['level'],
            'barcode_path' => $barcodePath,
            'qrcode_path' => $qrCodePath,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student registered with barcode and QR code.');
    }

    // Show form to edit student
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    // Update student info (optional)
    public function update(Request $request, Student $student)
    {
        // Add logic if needed
    }

    // Delete a student
    public function destroy(Student $student)
    {
        // Delete barcode file if exists
        if ($student->barcode_path && Storage::disk('public')->exists($student->barcode_path)) {
            Storage::disk('public')->delete($student->barcode_path);
        }

        // Delete QR code file if exists
        if ($student->qrcode_path && Storage::disk('public')->exists($student->qrcode_path)) {
            Storage::disk('public')->delete($student->qrcode_path);
        }

        // Delete user and student records
        $student->user()->delete();
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
