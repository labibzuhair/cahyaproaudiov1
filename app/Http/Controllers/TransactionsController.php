<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\produk;
use App\Models\Rentals;
use App\Models\District;
use App\Models\Transactions;
use App\Models\TransactionChanges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class TransactionsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['getRecord'] = User::find($user->id);
        $query = Transactions::with(['user', 'rentals.produk', 'district']);
        $data['transactions'] = $query->get();
        $query = Rentals::with(['transaction.user', 'produk']);
        $data['rentals'] = $query->get();
        return view('layouts.admin.transaksi.index', $data);
    }

    public function showByStatus($status)
    {
        // Ambil semua transaksi dengan status yang diberikan
        $transactions = Transactions::where('status', $status)->with('user', 'district', 'rentals.produk')->get();
        $user = Auth::user();

        // Siapkan data untuk dikirim ke view
        $data = [
            'getRecord' => $user,
            'transactions' => $transactions,
            'status' => $status
        ];

        return view('layouts.admin.transaksi.byStatus', $data);
    }



    public function create()
    {
        $user = Auth::user();
        $data['getRecord'] = User::find($user->id);
        $data['produks'] = Produk::all();
        $data['districts'] = District::all();
        return view('layouts.admin.transaksi.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'order_name' => 'required|string|max:255',
            'order_whatsapp' => 'required|string|max:15',
            'district_id' => 'required|exists:districts,id',
            'installation_address' => 'required|string',
            'rental_date' => 'required|date',
            'rental_days' => 'required|integer|min:1',
            'products' => 'required|array',
            'products.*.produk_id' => 'required|exists:produks,id',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        // Buat transaksi baru
        $transaction = Transactions::create([
            'user_id' => auth()->id(),
            'order_name' => $request->order_name,
            'order_whatsapp' => $request->order_whatsapp,
            'installation_address' => $request->installation_address,
            'district_id' => $request->district_id,
            'total_amount' => 0, // Placeholder, akan diperbarui di bawah
            'status' => $request->status,
        ]);

        // Ambil ongkir berdasarkan kecamatan
        $district = District::find($request->district_id);
        $delivery_fee = $district ? $district->delivery_fee : 0;
        // Tambahkan rental items ke transaksi
        $totalAmount = 0;
        $rental_date = Carbon::parse($request->rental_date);
        $rental_days = (int) $request->rental_days; // Konversi ke integer
        $return_date = $rental_date->copy()->addDays($rental_days - 1);
        foreach ($request->products as $product) {
            $produk = Produk::find($product['produk_id']);
            if ($produk) {
                $rental = Rentals::create([
                    'transactions_id' => $transaction->id,
                    'produk_id' => $product['produk_id'],
                    'rental_date' => $rental_date,
                    'return_date' => $return_date,
                    'rental_days' => $rental_days,
                    'location' => $request->installation_address,
                    'delivery_fee' => $delivery_fee,
                ]);
                $totalAmount += ($produk->price * $rental_days);
            }
        }
        // Tambahkan ongkir ke total amount
        $totalAmount += $delivery_fee;
        // Perbarui total_amount pada transaksi
        $transaction->total_amount = $totalAmount;
        $transaction->save();

        return redirect()->route('admin.transactions.index');
    }

    public function show($id)
    {
        $transaction = Transactions::with(['user', 'rentals.produk', 'district'])->findOrFail($id);
        $user = Auth::user();

        // $changes = TransactionChanges::where('transaction_id', $id)->get();
        // foreach ($changes as $change) {
        //     if ($change->field === 'produk_id') {
        //         $change->new_value = Produk::find($change->new_value)->name;
        //         $change->old_value = $change->old_value ? Produk::find($change->old_value)->name : 'Tidak Ada';
        //     }
        // }

        $data = [
            'getRecord' => $user,
            'transaction' => $transaction,

        ];
        return view('layouts.admin.transaksi.show', $data);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $transaction = Transactions::with('rentals')->findOrFail($id);
        $produks = Produk::all();
        $districts = District::all();
        $data = [
            'getRecord' => $user,
            'transaction' => $transaction,
            'produks' => $produks,
            'districts' => $districts
        ];
        return view('layouts.admin.transaksi.edit', $data);
    }




    public function update(Request $request, $id)
    {
        Log::info('Memulai proses update transaksi', ['id' => $id, 'input' => $request->all()]);


        try {
            $request->validate([
                'order_name' => 'required|string|max:255',
                'order_whatsapp' => 'required|string|max:15',
                'district_id' => 'required|exists:districts,id',
                'installation_address' => 'required|string',
                'rental_date' => 'required|date',
                'rental_days' => 'required|integer|min:1',
                'products' => 'required|array',
                'products.*.produk_id' => 'required|exists:produks,id',
                'status' => 'required|in:menunggu,disetujui,ditolak,diproses,selesai,dibatalkan',
            ]);

            // Update transaksi
            $transaction = Transactions::findOrFail($id);
            Log::info('Transaksi ditemukan:', ['transaction' => $transaction]);
            $transaction->update([
                'order_name' => $request->order_name,
                'order_whatsapp' => $request->order_whatsapp,
                'installation_address' => $request->installation_address,
                'district_id' => $request->district_id,
                'status' => $request->status,
            ]);

            Log::info('Transaksi berhasil diperbarui:', ['transaction' => $transaction]);

            // Hapus rentals lama
            Rentals::where('transactions_id', $transaction->id)->delete();
            Log::info('Rentals lama berhasil dihapus', ['transaction_id' => $transaction->id]);

            // Ambil ongkir berdasarkan kecamatan
            $district = District::find($request->district_id);
            $delivery_fee = $district ? $district->delivery_fee : 0;
            Log::info('Ongkir berhasil diambil', ['district' => $district, 'delivery_fee' => $delivery_fee]);

            // Tambahkan rental items ke transaksi
            $totalAmount = 0;
            $rental_date = Carbon::parse($request->rental_date);
            $rental_days = (int) $request->rental_days;
            $return_date = $rental_date->copy()->addDays($rental_days - 1);
            foreach ($request->products as $product) {
                $produk = Produk::find($product['produk_id']);
                if ($produk) {
                    $rental = Rentals::create([
                        'transactions_id' => $transaction->id,
                        'produk_id' => $product['produk_id'],
                        'rental_date' => $rental_date,
                        'return_date' => $return_date,
                        'rental_days' => $rental_days,
                        'location' => $request->installation_address,
                        'delivery_fee' => $delivery_fee,
                    ]);
                    $totalAmount += ($produk->price * $rental_days);
                    Log::info('Rental berhasil ditambahkan', ['rental' => $rental]);
                } else {
                    Log::error('Produk tidak ditemukan', ['produk_id' => $product['produk_id']]);
                }
            }

            // Tambahkan ongkir ke total amount
            $totalAmount += $delivery_fee;
            // Perbarui total_amount pada transaksi
            $transaction->total_amount = $totalAmount;
            $transaction->save();
            Log::info('Total amount berhasil diperbarui', ['transaction' => $transaction]);

            return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Update transaksi gagal: ', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Update transaksi gagal! Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $transaction = Transactions::findOrFail($id);
        // Hapus rentals yang terkait dengan transaksi
        Rentals::where('transactions_id', $transaction->id)->delete();
        // Hapus transaksi
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
