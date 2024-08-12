<?php

namespace App\Http\Controllers;
use App\models\level ;

use App\Models\Module;
use App\Models\Student;
use App\models\FieldOfStudy;
use Illuminate\Http\Request;
use App\Imports\StudetImporte1;


class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all(); // Récupérer tous les modules depuis la base de données

        return view('showModule', ['module1' => $modules]);
    }
    public function add()
    {
        $fieldOfStudies = FieldOfStudy::all(); // Récupérer toutes les filières depuis la base de données

        return view('create_module', ['fieldOfStudies' => $fieldOfStudies]);
    }
    public function store(Request $request)
{
    // Validation des données soumises
    $request->validate([
        'name' => 'required|unique:modules,name',
        'code' => 'required|unique:modules,code',
        'description' => 'required',
        'field_of_study_id' => 'required|exists:field_of_studies,id',
    ]);

    try {
        // Création du module associé à la filière sélectionnée
        $module = new Module([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'description' => $request->input('description'),
            'field_of_study_id' => $request->input('field_of_study_id'),
        ]);

        $module->save();

        return redirect()->route('show_module')->with('success', 'Module ajouté avec succès');
    } catch (\Exception $e) {
        // Gestion de l'erreur en cas d'échec de création du module
        $errorMessage = 'Une erreur est survenue lors de l\'ajout du module. Veuillez vérifier que le nom et le code sont uniques.';
        return redirect()->back()->with('error', $errorMessage)->withInput();
    }
}
public function showModulesForFieldOfStudy(Request $request, $id)
{
    $selectedFieldOfStudyId = $request->input('field_of_study_id', $id);
    $fieldOfStudy = FieldOfStudy::find($selectedFieldOfStudyId);

    if (!$fieldOfStudy) {
        abort(404); // Gérer le cas où la filière n'existe pas
    }

    $modules = $fieldOfStudy->modules;

    return view('modules_for_field_of_study', [
        'fieldOfStudy' => $fieldOfStudy,
        'modules' => $modules,
    ]);
}



public function choixfiliere()
{
    $fieldOfStudies = FieldOfStudy::all(); // Récupérer toutes les filières depuis la base de données

    // Définir $selectedFieldOfStudyId avec l'ID de la première filière disponible
    $selectedFieldOfStudyId = $fieldOfStudies->isNotEmpty() ? $fieldOfStudies->first()->id : null;

    return view('forme_choix_filiere', [
        'fieldOfStudies' => $fieldOfStudies,
        'selectedFieldOfStudyId' => $selectedFieldOfStudyId
    ]);
}
public function afficherCoursParModule(Request $request)
{
    $moduleId = $request->input('module_id');
    $module = Module::with('cours')->find($moduleId); // Charger les cours associés au module

    if (!$module) {
        abort(404, 'Module non trouvé');
    }

    return view('afficher_cours_par_module', compact('module'));
}
    public function showModuleSelectionForm()
    {
        $modules = Module::all();
        return view('select_module', ['modules' => $modules]);
    }
    public function create($filiereId, $niveauId)
    {
        $level = Level::findOrFail($niveauId);
        $fieldStudyId = $level->field_of_study_id; // Récupérer l'ID du domaine d'étude du niveau
    
        // Passer les variables à la vue
        return view('formule_module', compact('level', 'filiereId', 'niveauId', 'fieldStudyId'));
    }
    
    public function store3(Request $request, $filiereId, $niveauId)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Autres règles de validation nécessaires
        ]);
    
        // Création d'un nouveau module pour ce niveau
        $module = new Module();
        $module->name= $request->nom;
        $module->description = $request->description;
        $module->field_of_study_id = $filiereId;
        $module->niveau_id = $niveauId;
        $module->code = $request->code;
        $module->save();
    
        // Rediriger avec un message de succès ou afficher une vue appropriée
        return redirect()->route('filiere_niveaux')->with('success', 'Module ajouté avec succès');
    }
    
    public function show3($niveauId)
    {
        $modules = Module::where('niveau_id', $niveauId)->get();
        return view('modules_cours', compact('modules'));
    }
    public function destroy($moduleId)
    {
        try {
            // Recherche du module par son ID
            $module = Module::findOrFail($moduleId);

            // Suppression du module
            $module->delete();

            // Redirection avec un message de succès
            return redirect()->route('filiere_niveaux')->with('success', 'Module supprimé avec succès !');
        } catch (\Exception $e) {
            // Gestion de l'erreur en cas de problème lors de la suppression
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression du module : ' . $e->getMessage());
        }
    }
    public function showModule () {
        $user=auth()->user();
        
    // Vérifier si l'utilisateur est un étudiant
    
         // Récupérer les informations de l'étudiant
         $student = Student::where('user_id', $user->id)->first();

         // Récupérer les modules de la filière et du niveau de l'étudiant
         $modules = Module::where('field_of_study_id', $student->field_of_study_id)
                          ->where('niveau_id', $student->level_id)
                          ->get();
        
         // Retourner la vue avec les modules de l'étudiant
         return view('profile.modules', ['modules' => $modules]);
    }
}

