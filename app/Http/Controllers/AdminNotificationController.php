<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('admin.notifications.index', compact('notifications'));
    }
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['status' => 'success']);
    }
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Dapatkan notifikasi berdasarkan ID
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            // Tandai notifikasi sebagai sudah dibaca
            $notification->markAsRead();

            // Dapatkan transaksi berdasarkan ID notifikasi
            $transactionId = $notification->data['transaction_id'];
            $transaction = Transactions::with('user', 'district')->findOrFail($transactionId);

            // Dapatkan semua transaksi dari pengguna yang sama
            $query = Transactions::where('user_id', $transaction->user_id);
            $data['transactions'] = $query->get();
            $user = Auth::user();
            $data['getRecord'] = User::find($user->id);

            // Tampilkan view dengan transaksi yang sesuai
            return view('layouts.admin.transaksi.transaksi', $data);
        }

        return redirect()->route('admin.transactions.index')->with('error', 'Notifikasi tidak ditemukan.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
