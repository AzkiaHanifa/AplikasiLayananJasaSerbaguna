@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>

<div class="container py-5">
    <h4 class="mb-4">Buat Invoice</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/user/list-order/invoice/'.$transaksi->id) }}" method="POST">
        @csrf

        {{-- Tipe Invoice --}}
        {{-- <div class="mb-3">
            <label class="form-label">Tipe Invoice</label>
            <select name="tipe_invoice" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="estimasi">Estimasi</option>
                <option value="awal">Invoice Awal</option>
                <option value="tambahan">Invoice Tambahan</option>
                <option value="final">Invoice Final</option>
            </select>
        </div> --}}

        {{-- Keterangan --}}
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <hr>

        {{-- Invoice Items --}}
        <h5>Item Pekerjaan</h5>

        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th width="120">Qty</th>
                    <th width="180">Harga</th>
                    <th width="180">Total</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" name="items[0][deskripsi]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1" required>
                    </td>
                    <td>
                        <input type="number" name="items[0][harga]" class="form-control harga" value="0" min="0" required>
                    </td>
                    <td>
                        <input type="text" class="form-control total" readonly value="0">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary mb-3" id="add-row">
            + Tambah Item
        </button>

        <hr>

        {{-- Subtotal --}}
        <div class="text-end mb-4">
            <h5>Subtotal: Rp <span id="subtotal">0</span></h5>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Invoice
        </button>
    </form>
</div>

{{-- SCRIPT --}}
<script>
    let index = 1;

    function hitungTotal() {
        let subtotal = 0;

        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            const qty = row.querySelector('.qty').value || 0;
            const harga = row.querySelector('.harga').value || 0;
            const total = qty * harga;

            row.querySelector('.total').value = total;
            subtotal += total;
        });

        document.getElementById('subtotal').innerText =
            subtotal.toLocaleString('id-ID');
    }

    document.getElementById('add-row').addEventListener('click', function () {
        const tbody = document.querySelector('#items-table tbody');

        const row = `
            <tr>
                <td>
                    <input type="text" name="items[${index}][deskripsi]" class="form-control" required>
                </td>
                <td>
                    <input type="number" name="items[${index}][qty]" class="form-control qty" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" name="items[${index}][harga]" class="form-control harga" value="0" min="0" required>
                </td>
                <td>
                    <input type="text" class="form-control total" readonly value="0">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                </td>
            </tr>
        `;

        tbody.insertAdjacentHTML('beforeend', row);
        index++;
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
            hitungTotal();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            hitungTotal();
        }
    });
</script>
@endsection
