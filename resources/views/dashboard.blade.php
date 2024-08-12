<x-app-layout>
    <x-slot name="header">
        <!-- Barre de navigation principale -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div id="bar1">
                    <ul>
                        <!-- Accueil -->
                        <li>
                            <a class="navbar-brand" href="{{ route('dashboard') }}">HOME</a>
                        </li>

                        <!-- Cours -->
                        
                            <li>
                                <div class="contant">
                                    <div id="ensemble">
                                        <button id="btnCours">Cours</button>
                                        <p id="par1">></p>
                                        <p id="par2">^</p>
                                    </div>
                                    <ul id="listeCours" class="style">
                                        <li><a href="{{ route('filiere_niveaux') }}">Cours de toutes les filières</a></li>
                                        <li><button>Tous les cours</button></li>
                                       
                                    </ul>
                                </div>
                            </li>
                            @if(auth()->user()->role == 1)
                            <li>
                                <div class="contant">
                                    <div id="ensemble">
                                        <button id="btnStudent">Espace Étudiant</button>
                                        <p id="par1">></p>
                                        <p id="par2">^</p>
                                    </div>
                                    <ul id="listeStudent" class="style">
                                        <li><a href="{{ route('select.fields') }}">Liste des étudiants</a></li>
                                        <li><a href="{{ route('importe_Student') }}">Ajouter des étudiants</a></li>
                                        <li><a href="{{ route('students.search1') }}">Chercher un étudiant</a></li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        @if(auth()->user()->role == 0)
                        <li>
                            <div class="contant">
                                <div id="ensemble">
                                    <button id="btnCours">Cours</button>
                                    <p id="par1">></p>
                                    <p id="par2">^</p>
                                </div>
                                <ul id="listeCours" class="style">
                                    <li><a href="{{ route('Module_filiere') }}">Cours de  ma classe</a></li>
                            
                                   
                                </ul>
                            </div>
                        </li>
                  @endif
                  
                    <div class="contant">
                        <div id="ensemble">
                        <li><a href="{{route('professor.spaces')}}">Espace devoire etudient</a></li>
                            <p id="par1">></p>
                            <p id="par2">^</p>
                        </div>
                        <div class="contant">
                        <div id="ensemble">
                        <li><a href="{{route('professor.modules')}}">voir les devpiors des etudients</a></li>
                            <p id="par1">></p>
                            <p id="par2">^</p>
                        </div>
                        <div class="contant">
                        <div id="ensemble">
                        <li><a href="{{route('student.submitHomeworkForm')}}">Espace rendre  devoire </a></li>
                            <p id="par1">></p>
                            <p id="par2">^</p>
                        </div>
                        <ul>
                            <li><a href="{{ route('annonces.create') }}">Créer une annonce</a></li>
                            <li><a href="{{ route('annonces.index') }}">Voir les annonces</a></li>


                        </ul>
                            
                        <!-- Stages -->
                        <li>
                            <button id="stage">Stages</button>
                        </li>

                        <!-- Bibliothèque -->
                        <li>
                            <button id="biblio">Bibliothèque</button>
                        </li>

                        <!-- Activités parascolaires -->
                        <li>
                            <button id="activite">Activité parascolaire</button>
                        </li>

                        
                       
                        
                        <!-- Affichage des notes -->
                        <li>
                            <div class="contant">
                                <div id="ensemble">
                                    <button id="btn_note">Affichage des notes</button>
                                    <p id="par1">></p>
                                    <p id="par2">^</p>
                                </div>
                                <ul id="listeNote" class="style">
                                    <li><a href="#">Délibération</a></li>
                                    @if(auth()->user()->role == 0)
                                    <li><a href="{{ route('grades.student') }}">Affichage des notes</a></li>
                                    @endif
                                    @if(auth()->user()->role == 1)
                                    <li><a href="{{ route('choose.display') }}">Affichage des notes</a></li>
                                    <li><a href="{{ route('ImporteType') }}">Ajouter les notes</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>

                        <!-- Espace Prof -->
                        <li>
                            <div class="contant">
                                <div id="ensemble">
                                    <button id="btn_prof">Espace Prof</button>
                                    <p id="par1">></p>
                                    <p id="par2">^</p>
                                </div>
                                <ul id="listeprof" class="style">
                                    <li><a href="{{route('modules.select1')}}">Afficher les professeurs</a></li>
                                    @if(auth()->user()->role == 1)
                                    <li><a href="{{ route('teachers.create') }}">Ajouter un professeur</a></li>
                                    <li><a href="{{ route('choose.display') }}">Supprimer un professeur</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </x-slot>

    <!-- Contenu de la page -->
    <style>
    /* Style pour masquer la liste au chargement de la page */
    .style {
        display: none;
        list-style-type: none;
        padding-left: 0;
    }

    /* Style pour les boutons principaux */
    #btnCours,
    #btnStudent,
    #btn_note,
    #btn_prof {
        display: block;
        margin-bottom: 10px;
        background-color: blue;
        color: white;
        border: none;
        padding: 8px 3px;
        cursor: pointer;
    }

    /* Style pour la barre de navigation principale */
    #bar1 {
        display: inline-flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: blue;
        padding: 40px;
        margin-left: -75px;
        margin-top: -20px;
    }

    #bar1 ul {
        padding: 0;
        margin: 0;
    }

    #bar1 li {
        list-style: none;
        margin-bottom: 10px;
    }

    /* Style pour les conteneurs des boutons et des listes déroulantes */
    .contant {
        display: flex;
        flex-direction: column;
        color: black;
    }

    #ensemble {
        display: flex;
        color: black;
    }

    #ensemble p {
        padding-left: 10px;
        padding-top: 7px;
    }

    /* Style pour les listes déroulantes */
    .style li {
        text-align: center;
        padding-left: 20px;
    }

    /* Style pour les éléments des listes déroulantes */
    #listeCours,
    #listeStudent,
    #listeNote,
    #listeprof {
        background-color: white;
    }

    /* Style pour les boutons de navigation principaux */
    #btnStudent,
    #btn_note,
    #btn_prof {
        color: white;
    }
</style>


    <!-- Script JavaScript pour gérer les interactions avec le bouton et la liste -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let btnCours = document.getElementById('btnCours');
            let listeCours = document.getElementById('listeCours');
            btnCours.addEventListener('click', function() {
                toggleDisplay(listeCours);
            });

            let btnStudent = document.getElementById('btnStudent');
            let listeStudent = document.getElementById('listeStudent');
            btnStudent.addEventListener('click', function() {
                toggleDisplay(listeStudent);
            });

            let btnNote = document.getElementById('btn_note');
            let listeNote = document.getElementById('listeNote');
            btnNote.addEventListener('click', function() {
                toggleDisplay(listeNote);
            });

            let btnProf = document.getElementById('btn_prof');
            let listeProf = document.getElementById('listeprof');
            btnProf.addEventListener('click', function() {
                toggleDisplay(listeProf);
            });

            function toggleDisplay(element) {
                if (element.style.display === 'none') {
                    element.style.display = 'block';
                } else {
                    element.style.display = 'none';
                }
            }
        });
    </script>
</x-app-layout>
