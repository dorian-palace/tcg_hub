<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransactionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = Auth::user()->transactions()
            ->with('card')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $collections = Auth::user()->collections()
            ->with(['card' => function($query) {
                $query->orderBy('name');
            }])
            ->get()
            ->groupBy(function($collection) {
                return $collection->card->game->name;
            });

        return view('transactions.create', compact('collections'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'type' => 'required|in:sale,trade',
            'amount' => 'required_if:type,sale|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:mint,near_mint,excellent,good,played,poor',
            'notes' => 'nullable|string|max:500',
        ]);

        $transaction = new Transaction($validated);
        $transaction->user_id = Auth::id();
        $transaction->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction créée avec succès.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('transactions.show', compact('transaction'));
    }

    public function complete(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Cette transaction ne peut pas être complétée.');
        }

        $transaction->update(['status' => 'completed']);

        return back()->with('success', 'La transaction a été marquée comme terminée.');
    }

    public function cancel(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Cette transaction ne peut pas être annulée.');
        }

        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', 'La transaction a été annulée.');
    }
} 