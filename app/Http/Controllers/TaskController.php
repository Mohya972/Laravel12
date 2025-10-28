<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Affiche la liste des taches de l'utilisateur connecté
    public function index()
    {
        // Récupérer la liste des taches
        $tasks = Task::where('user_id', Auth::id())->get();

        return view('index', compact('tasks'));

    }
    
    // affiche le formulaire de création de tache
    public function create()
    {
        //
        return view('task.create');
        
    }

    // Enregistre une nouvelle tache avec l'id de l'utilisateur connecté
    public function store(Request $request)
    {
        // Validation des champs du formulaire
        $validated = $request->validate([
            'title' => 'required',
            'user_id'=>'required'
        ]);

        // Pour éviter tout message d'erreur due à l'absence du 'state' 
        $validated['state'] = 0;

        // Enregistrement en base
        Task::create($validated);

        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    //public function show(string $id) {}

    // Affiche le formulaire de modification de tache
    public function edit(string $id)
    {
        // Récupérer la tache de l'utilisateur
        $task = Task::findOrFail($id);

        // permet de modifier une tache si elle appartient à l'utilisateur
        if ($task->user_id == Auth::id()) { 
            return view('task.edit');
        } else {
            return redirect()->route('task.edit');
        }
        
    }

    // Met à jour la tache d'un utilisateur
    public function update(Request $request, string $id)
    {
        // Récupérer la tache de l'utilisateur
        $task = Task::findOrFail($id);

        // Changer l'état d'une tache si elle appartient à l'utilisateur
        if ($task->user_id == Auth::id()) { 
            $task->update(['state' => 1]);
        }
        
        // Redirection
        return redirect()->route('task.index');
    }

    // Supprime la tache d'un utilisateur
    public function destroy(string $id)
    {
        // Récupérer la tache de l'utilisateur
        $task = Task::findOrFail($id);

        // Requête pour supprimer la tache si elle appartient à l'utilisateur
        if ($task->user_id == Auth::id()) { 
            $task->delete();
        }
        
        // Redirection
        return redirect()->route('task.index');
    }
}
