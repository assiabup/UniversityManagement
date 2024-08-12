<?php

use App\models\FieldOfStudy;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\Studentimporte2;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AnnonceController;

use App\Http\Controllers\TeacherController;

use App\Http\Controllers\HomeworkController;

use App\Http\Controllers\Auth\LoginController;



use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentSpaceController;
use App\Http\Controllers\FeildofStudysController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/contenue', function () {
        return view('contenue');
    })->name('contenue');
});
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Route pour la vue contenue
Route::get('/contenue', function () {
    return view('contenue');
})->name('contenue1');

// Route pour la vue home
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/salam', [HomeController::class, 'index'])->name('salam');
// pour fficher la forme pour importer les etudients :
Route::post('/import/etudiant', [Studentimporte2::class, 'store5'])->name("etudient_importer");
//aficher les filieres 
Route::get('/show', [FeildofStudysController::class, 'index'])->name('show.filiere');
Route::post('/create1', [FeildofStudysController::class, 'store1'])->name("create_Filiere");

Route::post('/create_module', [ModuleController::class, 'store'])->name('modules.store1'); ////j'ai changer ca !!!!!!!!!!!!!!
Route::get('/create', [ModuleController::class, 'add'])->name("create_module");
Route::get('/filiere/{id}/modules', [ModuleController::class, 'showModulesForFieldOfStudy'])
    ->name('field_of_study.modules');
//aficher les modules de chaque filiere ;
Route::get('/forme_choix_filiere', [ModuleController::class, 'choixfiliere'])->name("choix_filiere");
Route::get('/forme_filiere', [FeildofStudysController::class, 'showFieldOfStudySelectionForm'])->name('select_field_of_study');
Route::get('/field-of-study/{id}/students', [FeildofStudysController::class, 'showStudentsByFieldOfStudy'])->name('field_of_study.students');
Route::get('/importe_grades', [GradesController::class, 'index']);
Route::post('/importe_notes', [GradesController::class, 'store2'])->name("importe_grades");
Route::get('/afficher_notes', [Studentimporte2::class, 'index'])->name("efficher_notes");

// Route pour afficher le formulaire de sélection de filière pour affucher les note 
Route::get('/select-field-of-study', [GradesController::class, 'showFieldOfStudySelection'])
    ->name('select.field.of.study');

// Route pour traiter le formulaire et afficher les notes des étudiants de la filière sélectionnée
Route::post('/show-grades', [GradesController::class, 'showGradesByFieldOfStudy'])
    ->name('show.grades');
Route::get('show_ratt2', [GradesController::class, 'show_ratt1'])->name('show_ratt');
Route::post('/importe_ratt', [GradesController::class, 'store3'])->name("importe_ratt");



Route::middleware(['auth'])->group(function () {
    Route::post('/courses/upload', [CoursController::class, 'upload'])->name('courses.upload');
});
Route::get('/importe_pdf', [CoursController::class, 'index']);
Route::get('/show_cours', [CoursController::class, 'show']);
// routes/web.php


// routes/web.php

Route::get('/afficher-cours-par-module', [ModuleController::class, 'afficherCoursParModule'])->name('afficher.cours.par.module');
//pour afficher ls cours de chaque modules :
Route::get('/select-module', [ModuleController::class, 'showModuleSelectionForm'])->name('select.module');

Route::put('/course/archive/{id}', [CoursController::class, 'archive'])->name('course.archive');
Route::put('/course/restore/{id}', [CoursController::class, 'restore'])->name('course.restore');
// routes/web.php
// pour afficher le cours de chaque module lorce que je clique sur tous les cours dnas la bare 
Route::get('/load-module-courses', [CoursController::class, 'loadModuleCourses'])->name('load.module.courses');
Route::get('/afficher_filiere', [FeildofStudysController::class, 'index1'])->name('afficher_filiere_par_group');
///////////////midellware/////////////////////////
Route::group(['middleware' => ['auth', 'role:1']], function () {
    Route::get('niveau/{filiereId}/ajouter-module/{niveauId}', [ModuleController::class, 'create'])->name('modules.create');
    Route::get('/filiere-niveaux', [FeildofStudysController::class, 'index2'])->name('filiere_niveaux');
});



Route::post('niveau/{filiereId}/ajouter-module/{niveauId}', [ModuleController::class, 'store3'])->name('modules.store');
Route::get('/modules/{niveauId}', [ModuleController::class, 'show3'])->name('modules.show2002');
// Route pour afficher les cours d'un module


// Route pour afficher le formulaire d'ajout de cours pour un module

// Route pour traiter l'ajout de cours pour un module



Route::get('/courses/{courseId}/download', [CoursController::class, 'downloadCourse'])->name('courses.download');

Route::delete('/courses/{courseId}', [CoursController::class, 'destroy'])->name('courses.destroy');
Route::delete('/modules/{moduleId}', [ModuleController::class, 'destroy'])->name('modules.destroy');
Route::delete('/filiere/{filiereId}', [FeildofStudysController::class, 'destroy'])->name('filiere.destroy');
// routes/web.php
//afficher vue pour selectionner filiere pour afficher les etudients

Route::post('/students/{id}', [Studentimporte2::class, 'update'])->name('students.update');

Route::post('/students/{id}/edit', [Studentimporte2::class, 'edit1'])->name('students.edit');
Route::delete('/students/{id}', [Studentimporte2::class, 'destroy'])->name('students.destroy');
Route::get('/grades/import', [FeildofStudysController::class, 'showImportForm'])->name('grades.import');
Route::post('/grades/import', [FeildofStudysController::class, 'store6'])->name('grades.import.post');


// Afficher la vue pour sélectionner la filière et le niveau


// Afficher les notes des étudiants pour la filière et le niveau sélectionnés

// Route pour afficher le formulaire d'importation

// Route pour traiter l'importation du fichier de rattrapage
Route::post('/store_rattrapage', [FeildofStudysController::class, 'store7'])->name('store_rattrapage');
// Route pour afficher les notes de rattrapage
Route::get('/notes_rattrapage', [FeildofStudysController::class, 'showRattrapage'])->name('notes_rattrapage');

Route::get('/final-results', [FeildofStudysController::class, 'showSelectionForm'])->name('display.final.results.form');
Route::post('/final-results/show', [FeildofStudysController::class, 'showFinalResults'])->name('display.final.results.show');


// Route pour afficher les résultats en fonction de la sélection


Route::get('/api/modules', [FeildofStudysController::class, 'getModulesByLevel'])->name('api.modules');
Route::post('/courses/{courseId}/archive', [CoursController::class, 'archive'])->name('courses.archive');
Route::post('/courses/{courseId}/unarchive', [CoursController::class, 'unarchive'])->name('courses.unarchive');
//pour ajouter un prof ///////////////////////////////////////////////////////////////////////////////////////
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');

// Route pour enregistrer un nouvel enseignant
//Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');

// Route pour afficher les détails d'un enseignant spécifique


// Route pour afficher le formulaire d'édition d'un enseignant spécifique
Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');

// Route pour mettre à jour les informations d'un enseignant spécifique
Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');


// Route pour afficher les modules en fonction de la filière et du niveau sélectionnés
Route::post('/show-modules', [TeacherController::class, 'showModules'])->name('modules.show');

// Route pour afficher les professeurs associés à un module spécifique
Route::get('/module/{module}', [TeacherController::class, 'showTeachersByModule'])->name('module.teachers');

// Route pour afficher tous les professeurs
Route::get('/teachers', [TeacherController::class, 'index_teacher'])->name('teachers.index');

// Route pour supprimer un professeur
Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy_teacher'])->name('teachers.destroy');
Route::middleware('auth')->group(function () {
    Route::get('/space', [SpaceController::class, 'index'])->name('space.index');
    Route::post('/space/toggle/{levelId}', [SpaceController::class, 'toggleSpace'])->name('space.toggle');
    Route::post('/space/submit/{levelId}', [SpaceController::class, 'submitAssignment'])->name('space.submit');
});




// Route pour ouvrir ou fermer l'espace d'un niveau spécifique
Route::post('/professeur/toggle-space/{level_id}/{action}', [SpaceController::class, 'toggleSpace'])->name('professor.toggleSpace');
Route::middleware(['auth'])->group(function () {
    Route::get('/etudiant/espace', [StudentSpaceController::class, 'index'])->name('student.space');
    Route::post('/etudiant/soumettre-devoir', [HomeworkController::class, 'submitHomework1'])->name('student.submitHomework');
});
Route::get('/professor/download/{homeworkId}', [TeacherController::class, 'downloadHomework'])->name('professor.download');
Route::get('/notifications', [CoursController::class, 'showNotifications'])->name('notifications.index');
Route::get('/show_Module', [ModuleController::class, 'showModule'])->name('Module_filiere');
Route::get('/announcements', [AnnonceController::class, 'index'])->name('announcements.index');
/*Route::middleware(['auth'])->group(function () {
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
});
Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
Route::post('/annonces/upload', [AnnonceController::class, 'upload'])->name('annonces.upload');
Route::get('/annonces/download/{id}', [AnnonceController::class, 'download'])->name('annonces.download');*/


Route::middleware('auth')->group(function () {



    Route::post('/cours_cours/store/{moduleId}', [CoursController::class, 'store41'])->name('cours.store1');
    Route::delete('/cours_cours/destroy/{courseId}', [CoursController::class, 'destroy1'])->name('cours.destroy1');
    Route::post('/cours_cours/archive/{courseId}', [CoursController::class, 'archive1'])->name('cours.archive1');
    Route::post('/cours_cours/unarchive/{courseId}', [CoursController::class, 'unarchive1'])->name('cours.unarchive1');
});


Route::get('/download/{courseId}', [CoursController::class, 'download'])->name('download.course');
//Route::post('/get-levels-by-field', [TeacherController::class, 'getLevelsByField'])->name('getLevelsByField');
//Route::post('/get-modules-by-level', [TeacherController::class, 'getModulesByLevel'])->name('getModulesByLevel');
//Route::post('/teachers/get-modules-by-field-and-level', [TeacherController::class, 'getModulesByFieldAndLevel'])->name('teachers.getModulesByFieldAndLevel');
////////////////////////////////
Route::get('/teachers/select-field-of-studies', [TeacherController::class, 'selectFieldOfStudies'])->name('teachers.selectFieldOfStudies');
Route::get('/teachers/select-levels', [TeacherController::class, 'selectLevels'])->name('teachers.selectLevels');
Route::get('/teachers/select-modules', [TeacherController::class, 'selectModules1'])->name('teachers.selectModules1');
//Route::get('/teachers/create-teacher-form-skhb', [TeacherController::class, 'createTeacherForm'])->name('teachers.createTeacherForm');
////////////////////////////////
Route::get('/enseignants/create', [TeacherController::class, 'create'])->name('teachers.createTeacherForm');
Route::post('/enseignants/store', [TeacherController::class, 'store'])->name('teachers.store');

//Route::get('/get-levels/{fieldOfStudyId}', [TeacherController::class, 'getLevels']);
//Route::get('/get-modules/{levelId}', [TeacherController::class, 'getModules']);
Route::post('/get-levels', [App\Http\Controllers\TeacherController::class, 'getLevels']);
Route::post('/get-modules', [App\Http\Controllers\TeacherController::class, 'getModules']);

////////////////////////la securisation ///////////////////////////////////////////////
///////////////midellware/////////////////////////
Route::group(['middleware' => ['auth', 'role:1']], function () {
    Route::get('/students/{id}/details', [Studentimporte2::class, 'showDetails'])->name('students.details');
    Route::get('niveau/{filiereId}/ajouter-module/{niveauId}', [ModuleController::class, 'create'])->name('modules.create');
    Route::get('/filiere-niveaux', [FeildofStudysController::class, 'index2'])->name('filiere_niveaux');
    Route::get('/modules/{niveauId}', [ModuleController::class, 'show3'])->name('modules.show2002');
    Route::post('/modules/{moduleId}/cours', [CoursController::class, 'store4'])->name('cours.store');
    Route::get('/modules/{moduleId}/cours', [CoursController::class, 'show4'])->name('modules.cours');
    Route::get('/modules/{moduleId}/cours/ajouter', [CoursController::class, 'create4'])->name('cours.create');
    Route::delete('/courses/{courseId}', [CoursController::class, 'destroy'])->name('courses.destroy');
    Route::delete('/modules/{moduleId}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::get('/ajouter', [Studentimporte2::class, 'show5'])->name('importe_Student');
    Route::get('/select-fields', [Studentimporte2::class, 'showFieldAndLevelSelection'])->name('select.fields');
    Route::post('/students', [Studentimporte2::class, 'showStudents'])->name('students.index1');

    Route::get('/students/search', [Studentimporte2::class, 'showSearchForm'])->name('students.search1');
    Route::post('/students/search/form', [Studentimporte2::class, 'search'])->name('students.search');
    Route::get('/importe-type', [FeildofStudysController::class, 'chooseImportType'])->name('ImporteType');
    Route::get('/grades/import', [FeildofStudysController::class, 'showImportForm'])->name('grades.import');
    Route::get('/import_rattrapage', [FeildofStudysController::class, 'showImportForm1'])->name('import_rattrapage');
    Route::get('/choose-display', [FeildofStudysController::class, 'chooseDisplay'])->name('choose.display');
    Route::get('/select-filiere-niveau', [FeildofStudysController::class, 'selectFiliereNiveauForm'])->name('selectFiliereNiveauForm');
    Route::post('/show-student-grades', [FeildofStudysController::class, 'showStudentGrades'])->name('showStudentGrades');
    Route::get('/results', [FeildofStudysController::class, 'index9'])->name('results.index');
    Route::post('/results/select-module', [FeildofStudysController::class, 'selectModule'])->name('results.selectModule');
    Route::post('/results/show', [FeildofStudysController::class, 'show9'])->name('results.show');
    Route::get('/enseignants/create', [TeacherController::class, 'create'])->name('teachers.createTeacherForm');
    Route::get('/teachers', [TeacherController::class, 'index_teacher'])->name('teachers.index');
    Route::get('/create_filiere', [FeildofStudysController::class, 'show_forme'])->name("show_forme_filiere");
    Route::get('/select-jsgvchsc,k', [TeacherController::class, 'selectModulesForm'])->name('modules.select1');
    // e::get('/students/{id}/details', [Studentimporte2::class, 'showDetails'])->name('students.details'); Rout
});

/////////////////////////////////////////////////////////////////////////////////////
Route::group(['middleware' => ['auth', 'role:2']], function () {

    Route::get('/teachers/niveaux-filieres', [CoursController::class, 'showNiveauxFiliere1'])->name('prof.niveaux-filieres1');
    Route::get('/enseignants/modules/{niveauId}/{filiereId}', [CoursController::class, 'showModules1'])->name('prof.modules1');
    Route::get('/cours_cours/{moduleId}', [CoursController::class, 'show41'])->name('modules.courses1');
    Route::get('/cours_cours/create/{moduleId}', [CoursController::class, 'create41'])->name('cours.create1');
    Route::get('/professor/modules', [TeacherController::class, 'showTeachingModules'])->name('professor.modules');

    Route::get('/professor/modules/{moduleId}/submissions', [TeacherController::class, 'showSubmissions'])->name('professor.submissions');
    Route::get('/professeur/espaces', [SpaceController::class, 'espaces'])->name('professor.spaces');
    Route::get('/etudiants', [TeacherController::class, 'showStudentsByTeacherAndLevel'])->name('showStudentsByTeacherAndLevel');

    Route::post('/students-by-field-and-level', [TeacherController::class, 'showStudentsByFieldAndLevel'])->name('studentsByFieldAndLevel');
    Route::get('/etudiants_filiere', [TeacherController::class, 'showStudentsByTeacherAndLevel1'])->name('showStudentsByTeacherAndLevel1');

    Route::post('/students-absence', [TeacherController::class, 'afficherAbsence'])->name('afficherAbsence');


    Route::get('/absence/form', [TeacherController::class, 'showForm'])->name('absenceForm');
    Route::post('/absence/save', [TeacherController::class, 'saveAbsences'])->name('saveAbsences');

    Route::get('/students-with-absences', [TeacherController::class, 'showStudentsWithAbsences'])->name('studentsWithAbsences');
    //
    Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');
    Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
    Route::get('/absences/create', [AbsenceController::class, 'create'])->name('absences.create');

    Route::get('/select-criteria', [AbsenceController::class, 'showCriteriaForm'])->name('select-criteria');
    Route::post('/get-absences-list', [AbsenceController::class, 'getAbsencesList'])->name('get-absences-list');
});



Route::get('/contenue/{page}', [NotificationController::class, 'index'])->name('contenue.index');



Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
Route::post('/annonces/store', [AnnonceController::class, 'store'])->name('annonces.store');

Route::get('/annonces/download/{id}', [AnnonceController::class, 'download'])->name('annonces.download');
Route::post('/annonces/upload', [AnnonceController::class, 'upload'])->name('annonces.upload');


Route::group(['middleware' => ['auth', 'role:0']], function () {
    Route::get('/show_module', [ModuleController::class, 'index'])->name("show_module");
    Route::get('/show_Module', [ModuleController::class, 'showModule'])->name('Module_filiere');
   
    
    Route::get('/mes-notes', [GradesController::class, 'showStudentGrades'])->name('grades.student');
    Route::get('/deliberation', [GradesController::class, 'showDeliberation'])->name('deliberation.student');
    Route::get('/student/submit-homework', [HomeworkController::class, 'showSubmitHomeworkForm1'])->name('student.submitHomeworkForm');
    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/notif', [NotificationController::class, 'show1'])->name('notif');
   

});
Route::post('/modules/{moduleId}/cours', [CoursController::class, 'store4'])->name('cours.store');
Route::get('/modules1/{moduleId}/cours', [CoursController::class, 'show4'])->name('modules.cours');