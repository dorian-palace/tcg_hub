<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:comments,id'
            ]);

            $comment = new Comment($validated);
            $comment->user_id = Auth::id();
            $comment->event_id = $event->id;
            $comment->save();

            Log::info('Comment created successfully', [
                'comment_id' => $comment->id,
                'user_id' => Auth::id(),
                'event_id' => $event->id
            ]);

            return back()->with('success', 'Commentaire ajouté avec succès !');

        } catch (\Exception $e) {
            Log::error('Error creating comment', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'request_data' => $request->except(['_token'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'ajout du commentaire. Veuillez réessayer.');
        }
    }

    public function update(Request $request, Comment $comment)
    {
        try {
            // Vérifier que l'utilisateur est l'auteur du commentaire
            if ($comment->user_id !== Auth::id()) {
                return back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire.');
            }

            $validated = $request->validate([
                'content' => 'required|string|max:1000'
            ]);

            $comment->update($validated);

            Log::info('Comment updated successfully', [
                'comment_id' => $comment->id,
                'user_id' => Auth::id()
            ]);

            return back()->with('success', 'Commentaire modifié avec succès !');

        } catch (\Exception $e) {
            Log::error('Error updating comment', [
                'error' => $e->getMessage(),
                'comment_id' => $comment->id,
                'user_id' => Auth::id(),
                'request_data' => $request->except(['_token'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la modification du commentaire. Veuillez réessayer.');
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            // Vérifier que l'utilisateur est l'auteur du commentaire ou un admin
            if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
            }

            $comment->delete();

            Log::info('Comment deleted successfully', [
                'comment_id' => $comment->id,
                'user_id' => Auth::id()
            ]);

            return back()->with('success', 'Commentaire supprimé avec succès !');

        } catch (\Exception $e) {
            Log::error('Error deleting comment', [
                'error' => $e->getMessage(),
                'comment_id' => $comment->id,
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Une erreur est survenue lors de la suppression du commentaire. Veuillez réessayer.');
        }
    }
}
