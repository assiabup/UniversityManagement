<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImporte1;
use App\Models\Module;
use App\Models\Grade;
use App\Models\Student;
use App\models\FieldOfStudy;
use App\models\Level;


class Studentimporte2 extends Controller
{
    public function show5()
    {
        return view('import');
    }

    public function store5(Request $request)
{
    $file = $request->file('file');
    
    if ($file) {
        try {
            // Importer le fichier Excel
            Excel::import(new StudentImporte1(), $file);
            
            // Rediriger avec un message de succès
            return back()->with('status', 'Le fichier Excel a été importé avec succès.');
        } catch (\Exception $e) {
            // Afficher une erreur en cas d'échec de l'importation
            return back()->with('error', 'Une erreur s\'est produite lors de l\'importation du fichier Excel : ' . $e->getMessage());
        }
    } else {
        // Retourner avec un message si aucun fichier n'a été sélectionné
        return back()->with('error', 'Veuillez sélectionner un fichier Excel.');
    }
}
public function showFieldAndLevelSelection()
    {
        $fieldsOfStudy = FieldOfStudy::all();
        $levelsByFieldOfStudy = [];

        foreach ($fieldsOfStudy as $field) {
            $levelsByFieldOfStudy[$field->name] = $field->levels;
        }

        return view('select_fields', [
            'fieldsOfStudy' => $fieldsOfStudy,
            'levelsByFieldOfStudy' => $levelsByFieldOfStudy,
        ]);
    }
    public function showStudents(Request $request)
    {
        // Récupérer le nom de la filière et le nom du niveau de filière depuis la requête
        $fieldOfStudyName = $request->input('field_of_study');
        $levelName = $request->input('level');

        // Trouver la filière par son nom
        $fieldOfStudy = FieldOfStudy::where('name', $fieldOfStudyName)->first();

        if (!$fieldOfStudy) {
            abort(404, 'La filière spécifiée n\'existe pas.');
        }

        // Trouver le niveau de filière par son nom et l'ID de la filière
        $level = Level::where('name', $levelName)->where('field_of_study_id', $fieldOfStudy->id)->first();

        if (!$level) {
            abort(404, 'Le niveau de filière spécifié n\'existe pas pour cette filière.');
        }

        // Récupérer les étudiants associés à cette filière et ce niveau
        $students = $level->students;

        // Retourner la vue avec les étudiants
        return view('student_index', [
            'students' => $students,
            'fieldOfStudy' => $fieldOfStudy,
            'level' => $level,
        ]);
    }
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cne' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255', // Nom du champ d'études (filière)
            'level' => 'required|string|max:255', // Nom du niveau
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Nouvelle image
        ]);

        // Rechercher la filière par son nom
        $fieldOfStudy = FieldOfStudy::where('name', $request->input('field_of_study'))->first();

        if (!$fieldOfStudy) {
            return redirect()->back()->withErrors(['field_of_study' => 'La filière spécifiée n\'existe pas.']);
        }

        // Rechercher le niveau par son nom et l'ID de la filière
        $level = Level::where('name', $request->input('level'))
                     ->where('field_of_study_id', $fieldOfStudy->id)
                     ->first();

        if (!$level) {
            return redirect()->back()->withErrors(['level' => 'Le niveau spécifié n\'existe pas pour cette filière.']);
        }

        // Mettre à jour les informations de l'étudiant
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->cne = $request->input('cne');
        $student->field_of_study_id = $fieldOfStudy->id;
        $student->level_id = $level->id;

        // Gérer le téléchargement de la nouvelle image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $student->image = basename($imagePath);
        }

        $student->save();

        return redirect()->route('salam')
            ->with('success', 'Les informations de l\'étudiant ont été mises à jour avec succès.');
    }
    public function edit1($id)
    {
        // Récupérer l'étudiant à modifier par son ID
        $student = Student::findOrFail($id);

        // Récupérer les informations de la filière associée à cet étudiant
        $fieldOfStudy = FieldOfStudy::findOrFail($student->field_of_study_id);

        // Récupérer les informations du niveau associé à cet étudiant
        $level = Level::findOrFail($student->level_id);

        // Retourner la vue 'edit' avec les données de l'étudiant, de la filière et du niveau
        return view('edit', [
            'student' => $student,
            'fieldOfStudy' => $fieldOfStudy,
            'level' => $level,
        ]);
    }
    // Supprimer un étudiant
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('salam')
            ->with('success', 'L\'étudiant a été supprimé avec succès.');
    }
    public function showSearchByNameForm()
    {
        return view('students.search_by_name');
    }

    public function showSearchByCneForm()
    {
        return view('students.search_by_cne');
    }

    public function search(Request $request)
    {
        // Récupérer le terme de recherche et le critère de recherche (name ou cne)
        $searchTerm = $request->input('search_term');
        $searchBy = $request->input('search_by');
    
        // Nettoyer le terme de recherche en supprimant les espaces inutiles
        $cleanedSearchTerm = trim($searchTerm);
    
        // Initialiser la variable qui contiendra les résultats de la recherche
        $students = [];
    
        // Vérifier le critère de recherche et effectuer la requête correspondante
        if ($searchBy === 'name') {
            // Recherche par nom
            $students = Student::where('name', 'like', '%' . $cleanedSearchTerm . '%')->get();
        } elseif ($searchBy === 'cne') {
            // Recherche par CNE
            $students = Student::where('cne', 'like', '%' . $cleanedSearchTerm . '%')->get();
        }
    
        // Retourner la vue des résultats de la recherche avec les étudiants trouvés
        return view('students_search_results1', compact('students'));
    }
    
    public function showSearchForm(){
        return view('students_search_form');
    }
    public function showDetails($id)
    {
        $student = Student::findOrFail($id);
        return view('student_details', compact('student'));
    }
}
