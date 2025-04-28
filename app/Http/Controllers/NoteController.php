<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Create a new note
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Create the note, associating it with the authenticated user
        $note = Note::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $request->user()->id,  // Automatically associate with the authenticated user
        ]);

        // Return the response with the created note
        return response()->json([
            'message' => 'Note created successfully',
            'note' => $note
        ], 201);
    }


    // Read (list) all notes
    public function index()
    {
        $notes = Note::all();  // You can add pagination or filter logic here

        return response()->json(['notes' => $notes], 200);
    }

    // Read a single note
    public function show($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        return response()->json(['note' => $note], 200);
    }

    // Update an existing note
    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Update the note
        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Note updated successfully', 'note' => $note], 200);
    }

    // Delete a note
    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
