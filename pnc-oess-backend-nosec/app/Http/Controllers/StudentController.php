<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::orderBy('seq')->get();
    }

    // NO-SECURITY VERSION: any student record can be fetched by anyone
    public function show(Request $request, string $studentNumber)
    {
        return Student::where('studentNumber', $studentNumber)->first() ?? response()->json(null);
    }
}
