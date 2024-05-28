@extends('layouts.app')

@section('title', 'Transaksi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        <div class="card-body">
                            @csrf
                            <input type="hidden" name="kasir_id" value="{{ Auth::user()->id }}">

                            <div class="form-group">
                                <label for="transaction_date">Transaction Date:</label>
                                <input type="date" class="form-control" id="transaction_date" name="transaction_date"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="total_price">Total Harga:</label>
                                <input type="number" class="form-control" id="total_price" name="total_price" readonly>
                            </div>

                            <table class="table" id="productTable">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Quantity</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" onclick="addItem()">Add Product</button>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pre-initialize any existing rows (if any)
            document.querySelectorAll('.product_id').forEach(select => {
                updateUnitPriceAndTotal(select.closest('tr'));
            });
        });

        let itemIndex = 1;

        function addItem() {
            const tableBody = document.getElementById("productTable").querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.id = 'item_' + itemIndex; // Setting the ID for new rows
            newRow.innerHTML = `
        <td>
            <select name="items[${itemIndex}][product_id]" class="form-control product_id"
                onchange="updateUnitPriceAndTotal(this.parentNode.parentNode)" required>
                <option value="">Select a product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" value="0" oninput="updateUnitPriceAndTotal(this.parentNode.parentNode)" min="0" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][unit_price]" class="form-control unit_price" readonly>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][total_price]" class="form-control total_price" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger remove" onclick="removeRow(this.parentNode.parentNode)">Remove</button>
        </td>
    `;
            tableBody.appendChild(newRow);
            itemIndex++;
            updateGrandTotal(); // Update grand total on addition of a new row
        }

        function updateUnitPriceAndTotal(row) {
            const productSelect = row.querySelector('.product_id');
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const unitPrice = selectedOption.getAttribute('data-price');
            const quantity = row.querySelector('.quantity').value || 0;

            row.querySelector('.unit_price').value = parseFloat(unitPrice).toFixed(0); // Set unit price
            const total = quantity * parseFloat(unitPrice);
            row.querySelector('.total_price').value = total.toFixed(0); // Calculate and set total price

            updateGrandTotal(); // Recalculate grand total after every update
        }

        function calculateTotal(row) {
            const quantity = row.querySelector('.quantity').value || 0;
            const unitPrice = row.querySelector('.unit_price').value || 0;
            const total = quantity * unitPrice;
            row.querySelector('.total_price').value = parseFloat(total).toFixed(0);

            updateGrandTotal(); // Update grand total after quantity or unit price changes
        }

        function removeRow(row) {
            row.parentNode.removeChild(row);
            updateGrandTotal();
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.total_price').forEach(function(element) {
                grandTotal += parseFloat(element.value) || 0;
            });
            document.getElementById('total_price').value = grandTotal.toFixed(0);
        }
    </script>
@endpush
