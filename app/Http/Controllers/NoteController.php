<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\User;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();
        $note = $notes->first();
        return view('welcome', compact('notes', 'note'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // create a new note for the authenticated user
        auth()->user()->notes()->create($validated);

        return redirect()->back()->with('success', 'Note Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        // abort_unless($note->user_id === auth()->id(), 403);
        $this->authorize('view', $note);
        $notes = auth()->user()->notes()->latest()->get();

        return view('welcome', [
            'notes' => $notes,
            'note' => $note
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        // ensure user owns the note
       // abort_unless($note->user_id === auth()->id(), 403);
        $this->authorize('update', $note);
        
        // validate input

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // update note

        $note->update($validated);
        return redirect()->back()->with('success', 'Note Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // abort_unless($note->user_id === auth()->id(), 403);
        $this->authorize('delete', $note);
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note Deleted Successfully!');
    }
}
