<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $this->authorize('viewAny', Note::class);
        $notes = Note::query()
            ->select(['id', 'user_id', 'title', 'body', 'status', 'is_pinned', 'created_at'])
            ->with([
                'user:id,first_name,last_name',
                'categories:id,name,color',
            ])
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->get()
            ->whereIn('status', ['published', 'archived']);

        return response()->json([
            'notes' => $notes,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $this->authorize('create', Note::class);
        $validated = $request->validate([

            'title' => ['required', 'string', 'min:3', 'max:255'],
            'body'  => ['nullable', 'string'],
            'status' => ['sometimes', 'required', 'string', Rule::in(['draft', 'published', 'archived'])],
            'is_pinned' => ['sometimes', 'boolean'],

            'categories' => ['sometimes', 'array', 'max:3'],
            'categories.*' => ['integer', 'distinct', 'exists:categories,id'],
        ]);

        $note = $request->user()->notes()->create([
            'title'     => $validated['title'],
            'body'      => $validated['body'] ?? null,
            'status'    => $validated['status'] ?? 'draft',
            'is_pinned' => $validated['is_pinned'] ?? false,
        ]);


        if (!empty($validated['categories'])) {
            $note->categories()->sync($validated['categories']);
        }

        return response()->json([
            'message' => 'Poznámka bola úspešne vytvorená.',
            'note' => $note->load([
                'user:id,first_name,last_name',
                'categories:id,name,color',
            ]),
        ], Response::HTTP_CREATED);
    }

    public function myNotes(Request $request)
    {
        $this->authorize('viewAny', Note::class);

        $notes = $request->user()
            ->notes()
            ->select(['id', 'user_id', 'title', 'body', 'status', 'is_pinned', 'created_at'])
            ->with([
                'categories:id,name,color',
            ])
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(5);

        return response()->json([
            'notes' => $notes,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $note = Note::query()
            ->with([
                'user',
                'categories',
                'tasks.comments',
                'comments'
            ])
            ->where('id', $id)
            ->first();
        if (!$note) {
            return response()->json([
                'message' => 'Poznamka nenajdena'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('view', $note);

        return response()->json([
            'note' => $note,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nenájdená.'], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('update', $note);

        $note->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json(['note' => $note], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nenájdená.'], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('delete', $note);

        $note->delete(); // soft delete

        return response()->json(['message' => 'Poznámka bola úspešne odstránená.'], Response::HTTP_OK);
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $notes = Note::searchPublished($q);

        return response()->json(['query' => $q, 'notes' => $notes], Response::HTTP_OK);
    }

    public function pin(string $id) {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Poznámka nenájdená'], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('update', $note);
        $note->pin();

        return response()->json([
            'message' => 'Poznamka bola pripnuta',
            'note' => $note
        ]);
    }

    public function unpin(string $id) {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nenájdená'], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('update', $note);

        $note->unpin();
        return response()->json([
           'message' => 'Poznamka bola odopnuta',
           'note' => $note
        ]);
    }

    public function publish(string $id) {
        $note = Note::find($id);
        $this->authorize('publish', $note);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nenájdená'], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('update', $note);
        $note->publish();
        return response()->json([
            'message' => 'Poznamka bola publikovana',
            'note' => $note
        ]);
    }

    public function archive(string $id) {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Poznámka nenájdená'], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('update', $note);

        $note->archive();
        return response()->json([
            'message' => 'Poznamka bola archivovana',
            'note' => $note
        ]);
    }

}
