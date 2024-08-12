<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\Module;
use App\Models\Level;

class HomeworkController extends Controller
{
    public function submitHomework1(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'homework_pdf' => 'required|mimes:pdf|max:2048', // PDF max size 2MB
        ]);

        $homeworkPdf = $request->file('homework_pdf');
        $filePath = $homeworkPdf->store('homeworks', 'public');

        Homework::create([
            'module_id' => $request->module_id,
            'student_id' => auth()->user()->student->id,
            'pdf_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Devoir soumis avec succès.');
    }


    public function showSubmitHomeworkForm1()
    {
        $user = Auth::user();

        if ($user && $user->student) {
            $student = $user->student;

            if ($student->level_id) {
                $level = $student->level;

                if ($level && $level->is_open) {
                    $modules = Module::where('niveau_id', $level->id)->get();

                    return view('student_submit_homework', ['modules' => $modules]);
                } else {
                    return view('error', ['message' => 'L\'espace pour soumettre les devoirs est actuellement fermé.']);
                }
            }
        }

        return view('error_page', ['message' => 'Niveau d\'étude non défini pour cet étudiant.']);
    }
}