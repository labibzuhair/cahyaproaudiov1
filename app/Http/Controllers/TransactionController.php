<?php

namespace App\Http\Controllers;

use Exception;

use Carbon\Carbon;
use App\Models\User;
use App\Models\produk;
use App\Models\Rentals;
use App\Models\District;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\TransactionChanges;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TransactionRequestNotification;
use App\Notifications\DeleteTransactionRequestNotification;
use App\Notifications\UpdateTransactionRequestNotification;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = Transactions::where('user_id', $user->id)->with('rentals.produk', 'district')->get();
        return view('layouts.main.transaksi.transaksi', compact('transactions'));
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
        $transaction = Transactions::with('user', 'district')->findOrFail($id);
        $changes = TransactionChanges::where('transaction_id', $id)->get();

        return view('layouts.main.transaksi.show', compact('transaction', 'changes'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data transaksi beserta rentals dan produk yang terkait
        $transaction = Transactions::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('rentals.produk')
            ->firstOrFail();

        // Ambil semua distrik
        $districts = District::all();

        // Ambil produk yang tidak termasuk dalam rental untuk transaksi ini
        $produks = Produk::whereNotIn('id', $transaction->rentals->pluck('produk_id'))
            ->get();

        // Ambil data rentals dengan status tertentu beserta produk dan transaksi terkait
        $rentals = Rentals::with(['produk', 'transaction'])
            ->whereHas('transaction', function ($query) {
                $query->whereIn('status', ['disetujui', 'diproses', 'selesai']);
            })
            ->get();


        // Siapkan data untuk dikirim ke view
        $data = [
            'getRecord' => Auth::user(),
            'transaction' => $transaction,
            'produks' => $produks,
            'districts' => $districts,
            'rentals' => $rentals,
        ];

        // Kirim data ke view
        return view('layouts.main.transaksi.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $transaction = Transactions::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'order_name' => 'required|string|max:255',
            'order_whatsapp' => 'required|string|max:15',
            'district_id' => 'required|exists:districts,id',
            'installation_address' => 'required|string',
            'rental_date' => 'required|date',
            'rental_days' => 'required|integer|min:1',
            'products' => 'required|array',
            'products.*.produk_id' => 'required|exists:produks,id',
        ]);

        try {
            // Simpan perubahan yang dilakukan oleh user
            $changes = [];
            $fieldsToExclude = ['_token', '_method', 'products'];

            foreach ($request->except($fieldsToExclude) as $key => $value) {
                if (in_array($key, ['rental_date', 'rental_days'])) {
                    $originalValue = $transaction->rentals->first()->$key;
                } else {
                    $originalValue = $transaction->$key;
                }

                if (is_array($originalValue)) {
                    $originalValue = json_encode($originalValue);
                }

                if (is_array($value)) {
                    $value = json_encode($value);
                }

                if ($originalValue != $value) {
                    $changes[] = [
                        'transaction_id' => $transaction->id,
                        'user_id' => Auth::id(),
                        'field' => $key,
                        'old_value' => $originalValue,
                        'new_value' => $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Simpan perubahan produk yang disewa
            $existingRentals = $transaction->rentals->pluck('produk_id')->toArray();

            // Produk yang dihapus atau dikurangi
            foreach ($transaction->rentals as $rental) {
                if (!in_array($rental->produk_id, array_column($request->products, 'produk_id'))) {
                    $changes[] = [
                        'transaction_id' => $transaction->id,
                        'user_id' => Auth::id(),
                        'field' => 'produk_id_removed',
                        'old_value' => $rental->produk_id,
                        'new_value' => '',  // Beri nilai kosong, bukan null
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Produk yang ditambah
            foreach ($request->products as $product) {
                if (!in_array($product['produk_id'], $existingRentals)) {
                    $changes[] = [
                        'transaction_id' => $transaction->id,
                        'user_id' => Auth::id(),
                        'field' => 'produk_id_added',
                        'old_value' => '',
                        'new_value' => $product['produk_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($changes)) {
                TransactionChanges::insert($changes);
            }

            // Perbarui status transaksi menjadi 'menunggu'
            $transaction->update(['status' => 'menunggu']);

            // Kirim notifikasi ke admin
            $admin = User::where('is_role', 'admin')->get();
            foreach ($admin as $a) {
                $a->notify(new UpdateTransactionRequestNotification($transaction));
            }

            return redirect()->route('customer.transactions.index')->with('success', 'Perubahan berhasil diajukan. Menunggu konfirmasi dari admin.');
        } catch (Exception $e) {
            Log::error("Terjadi kesalahan saat memperbarui transaksi: " . $e->getMessage());
            return back()->withInput()->withErrors(['msg' => 'Terjadi kesalahan saat memperbarui transaksi. Silakan coba lagi.']);
        }
    }

    public function approveAll($id)
    {

        try {
            $transaction = Transactions::findOrFail($id);
            $changes = TransactionChanges::where('transaction_id', $id)->get();

            foreach ($changes as $change) {

                if (in_array($change->field, ['rental_date', 'rental_days'])) {

                    $rental = Rentals::where('transactions_id', $transaction->id)->first();
                    $rental->update([$change->field => $change->new_value]);

                    $rental_date = $rental->rental_date;
                    $rental_days = $rental->rental_days;
                    $return_date = Carbon::parse($rental_date)->addDays($rental_days - 1);

                    // Perbarui return_date pada rental
                    $rental->update(['return_date' => $return_date]);
                } elseif ($change->field === 'produk_id_added') {

                    $product = Produk::find($change->new_value);
                    Rentals::create([
                        'transactions_id' => $transaction->id,
                        'produk_id' => $change->new_value,
                        'rental_days' => $transaction->rentals->first()->rental_days,
                        'rental_date' => $transaction->rentals->first()->rental_date,
                        'return_date' => Carbon::parse($transaction->rentals->first()->rental_date)->addDays($transaction->rentals->first()->rental_days - 1),
                        'location' => $transaction->installation_address,
                        'delivery_fee' => $transaction->district ? $transaction->district->delivery_fee : 0,
                    ]);
                } elseif ($change->field === 'produk_id_removed') {

                    Rentals::where('transactions_id', $transaction->id)
                        ->where('produk_id', $change->old_value)
                        ->delete();
                } else {
                    $transaction->update([$change->field => $change->new_value]);
                }
            }

            // Hitung ulang total amount
            $totalAmount = 0;
            $rentals = Rentals::where('transactions_id', $transaction->id)->get();
            foreach ($rentals as $rental) {
                $product = Produk::find($rental->produk_id);
                if ($product) {
                    $totalAmount += ($product->price * $rental->rental_days);
                }
            }

            // Tambahkan ongkir ke total amount
            $delivery_fee = $transaction->district ? $transaction->district->delivery_fee : 0;
            $totalAmount += $delivery_fee;

            // Perbarui total_amount pada transaksi
            $transaction->update(['total_amount' => $totalAmount, 'status' => 'disetujui']);

            return redirect()->back()->with('success', 'Semua perubahan disetujui dan diimplementasikan.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Terjadi kesalahan saat menyetujui semua perubahan. Silakan coba lagi.']);
        }
    }

    public function rejectAll($id)
    {

        try {
            $transaction = Transactions::findOrFail($id);

            $transaction->update(['status' => 'ditolak']);

            return redirect()->back()->with('success', 'Semua perubahan tidak disetujui.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Terjadi kesalahan saat menolak semua perubahan. Silakan coba lagi.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function requestDelete($id)
    {
        $transaction = Transactions::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $transaction->status = 'menunggu';
        $transaction->save();

        // Kirim notifikasi ke admin
        $admin = User::where('is_role', 'admin')->get();
        foreach ($admin as $a) {
            $a->notify(new DeleteTransactionRequestNotification($transaction));
        }
        return redirect()->route('customer.transactions.index')->with('success', 'Permintaan penghapusan transaksi berhasil diajukan. Menunggu konfirmasi admin.');

    }
}
