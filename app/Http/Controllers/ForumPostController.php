<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\ForumTopic;
use App\Models\ForumPost;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ForumPostController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Forum $forum, ForumTopic $topic)
    {
        if ($topic->is_locked) {
            return back()->with('error', 'Ce sujet est verrouillé.');
        }

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $validated['user_id'] = auth()->id();

        $topic->posts()->create($validated);

        return redirect()->route('topics.show', [$forum, $topic])
            ->with('success', 'Votre réponse a été publiée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum, ForumTopic $topic, ForumPost $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('forum', 'topic', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum, ForumTopic $topic, ForumPost $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $post->update($validated);

        return redirect()->route('topics.show', [$forum, $topic])
            ->with('success', 'Votre réponse a été mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum, ForumTopic $topic, ForumPost $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();

        return redirect()->route('topics.show', [$forum, $topic])
            ->with('success', 'Votre réponse a été supprimée.');
    }

    public function markAsSolution(Forum $forum, ForumTopic $topic, ForumPost $post)
    {
        $this->authorize('update', $topic);

        // Désactiver toutes les autres solutions
        $topic->posts()->update(['is_solution' => false]);

        // Marquer cette réponse comme solution
        $post->update(['is_solution' => true]);

        return redirect()->route('topics.show', [$forum, $topic])
            ->with('success', 'Cette réponse a été marquée comme solution.');
    }
}
