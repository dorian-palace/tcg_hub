<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Facades\TransactionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Default to current user's transactions
        $userId = $request->user_id ?? Auth::id();
        
        // Check if we want sent or received transactions
        $type = $request->input('type', 'all');
        
        // Use our TransactionHelper facade to get transactions
        $transactions = TransactionHelper::getUserTransactions($userId, $type);
        
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_id' => 'required|exists:users,id',
            'buyer_id' => 'required|exists:users,id',
            'transaction_type' => 'required|in:sale,trade',
            'total_amount' => 'required_if:transaction_type,sale|numeric|min:0',
            'cards' => 'required|array',
            'cards.*.collection_id' => 'required|exists:collections,id',
            'cards.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);
        
        // Use our TransactionHelper facade to create a transaction
        $transaction = TransactionHelper::createTransaction($validated);
        
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['seller', 'buyer', 'cards.card'])->findOrFail($id);
        
        // Check if the current user is authorized to view this transaction
        if (!TransactionHelper::canViewTransaction(Auth::id(), $transaction)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     * This is used to change transaction status (confirm, cancel, etc.)
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string'
        ]);
        
        // Use our TransactionHelper facade to update transaction status
        $result = TransactionHelper::updateTransactionStatus(
            Auth::id(),
            $transaction,
            $validated['status'],
            $validated['notes'] ?? null
        );
        
        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 403);
        }
        
        return response()->json($result['transaction']);
    }

    /**
     * Remove the specified resource from storage.
     * This is used to cancel a pending transaction.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Use our TransactionHelper facade to cancel transaction
        $result = TransactionHelper::cancelTransaction(Auth::id(), $transaction);
        
        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 403);
        }
        
        return response()->json(null, 204);
    }
}
