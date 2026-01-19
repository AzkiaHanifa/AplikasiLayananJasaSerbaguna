<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\TransaksiJasa;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create($transaksi_id)
    {
        $transaksi = TransaksiJasa::findOrFail($transaksi_id);
        return view('user.jobs.tambah-invoice', compact('transaksi'));
    }

    /**
     * Simpan invoice (awal / tambahan / final)
     */
    public function store(Request $request, $transaksiId)
    {
        $request->validate([
            // 'tipe_invoice' => 'required|in:estimasi,awal,tambahan,final',
            'items' => 'required|array',
            'items.*.deskripsi' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi = TransaksiJasa::findOrFail($transaksiId);

        $subtotal = collect($request->items)->sum(function ($item) {
            return $item['qty'] * $item['harga'];
        });

        $invoice = Invoice::create([
            'transaksi_jasa_id' => $transaksi->id,
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'tipe_invoice' => 'final',
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'status' => 'menunggu_pembayaran',
            'keterangan' => $request->keterangan,
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create([
                'deskripsi' => $item['deskripsi'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'total' => $item['qty'] * $item['harga'],
            ]);
        }

        // Update status transaksi
        $transaksi->update([
            'status' => 'menunggu_pembayaran'
        ]);

        return redirect('/user/list-order/invoice/' . $transaksi->id)
            ->with('success', 'Invoice berhasil dibuat');
    }

    /**
     * Detail invoice (VIEW)
     */
    public function show($id)
    {
        $transaksi = TransaksiJasa::findOrFail($id);
        $invoice = Invoice::where('transaksi_jasa_id', $id)->orderBy('created_at', 'desc')->get();
        return view('user.jobs.show', compact('invoice', 'transaksi'));
    }
    public function detailInvoice($transaksi_id, $invoice_id)
    {
        $transaksi = TransaksiJasa::findOrFail($transaksi_id);
        $invoice = Invoice::findOrFail($invoice_id);
        return view('user.jobs.detail-invoice', compact('invoice', 'transaksi'));
    }
    public function showCustomer($id)
    {
        $transaksi = TransaksiJasa::findOrFail($id);
        $invoice = Invoice::where('transaksi_jasa_id', $id)->orderBy('created_at', 'desc')->get();
        return view('user.transaksi.show', compact('invoice', 'transaksi'));
    }
    public function detailInvoiceCustomer($transaksi_id, $invoice_id)
    {
        $transaksi = TransaksiJasa::findOrFail($transaksi_id);
        $invoice = Invoice::findOrFail($invoice_id);
        return view('user.transaksi.detail-invoice', compact('invoice', 'transaksi'));
    }
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoice,id',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        $path = $request->file('bukti_pembayaran')
            ->store('bukti_pembayaran', 'public');

        $invoice->update([
            'bukti_pembayaran' => $path,
            'status' => 'dibayar',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }


    /**
     * Konfirmasi pembayaran
     */
    public function konfirmasiPembayaran(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($request->id_invoice);

        $invoice->update([
            'status' => 'lunas',
            'dibayar_pada' => now(),
        ]);

        return redirect('/user/list-order/invoice/' . $id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi');
    }

    public function prosesPesanan(Request $request, $id)
    {
        $transaksi = TransaksiJasa::findOrFail($id);

        $transaksi->update([
            'status' => 'dalam_proses',
        ]);

        return redirect('/user/list-order/invoice/' . $id)
            ->with('success', 'Pesanan diproses');
    }

    public function tandaiSelesai(Request $request, $id)
    {
        $transaksi = TransaksiJasa::findOrFail($id);

        $transaksi->update([
            'status' => 'selesai',
        ]);

        return redirect('/user/list-order/invoice/' . $id)
            ->with('success', 'Pesanan berhasil diselesaikan');
    }
}
