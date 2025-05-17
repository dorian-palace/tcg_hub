<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Forum;
use App\Models\ForumTopic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ForumTopicController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Forum $forum)
    {
        $topics = $forum->topics()
            ->with(['user', 'posts'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('topics.index', compact('forum', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Forum $forum)
    {
        return view('topics.create', compact('forum'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        $topic = $forum->topics()->create($validated);

        return redirect()->route('topics.show', [$forum, $topic])
            ->with('success', 'Sujet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum, ForumTopic $topic)
    {
        $topic->load(['user', 'posts.user']);
        $topic->increment('views_count');

        return view('topics.show', compact('forum', 'topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum, ForumTopic $topic)
    {
        $this->authorize('update', $topic);
        return view('topics.edit', compact('forum', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum, ForumTopic $topic)
    {
        $this->authorize('update', $topic);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $topic->update($validated);

        return redirect()->route('topics.show', [$forum, $topic])
            ->with('success', 'Sujet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum, ForumTopic $topic)
    {
        $this->authorize('delete', $topic);
        
        $topic->delete();

        return redirect()->route('forums.show', $forum)
            ->with('success', 'Sujet supprimé avec succès.');
    }
}
