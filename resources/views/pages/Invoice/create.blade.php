@extends('layouts.master');
@section('pages')
    ;

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .invoice-box {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .invoice-header {
            background-color: #0d6efd;
            color: white;
            padding: 25px 30px;
        }

        .invoice-body {
            background-color: #d1e7dd;
            padding: 30px;
        }

        .invoice-footer {
            background-color: #87ceeb;
            padding: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: #333;
        }

        .logo {
            height: 60px;
        }

        .table thead th {
            background-color: #0d6efd;
            color: white;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 0.875rem;
        }
    </style>


    <div class="invoice-box">

        <!-- Header -->
        <div class="invoice-header d-flex justify-content-between align-items-center">
            <div>
                <img src="https://via.placeholder.com/150x60?text=LOGO" alt="Logo" class="logo">
            </div>
            <div class="text-end">
                <h2>💱 Money Exchange Sales Invoice</h2>
                <p class="mb-0">Invoice #: INV-2025-001</p>
                <small>Date: 05 July 2025</small>
            </div>
        </div>

        <!-- Body -->
        <div class="invoice-body">

            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Customer Information</h6>
                    <select name="" id="customer">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select><br>
                    <p class="mb-0">Phone: +880 123-456-789</p>
                    <p>Address: Gulshan, Dhaka</p>
                </div>
                <div class="col-md-6 text-end">
                    <h6>Exchange Summary</h6>
                    <p class="mb-0">Currency: USD to BDT</p>
                    <p class="mb-0">Rate: 1 USD = ৳110</p>
                    <p>Total: $1000 → ৳110,000</p>
                </div>
            </div>

            <!-- Dynamic Line Items Table -->
            <table class="table table-bordered" id="invoiceTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Currency</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>Total (BDT)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="invoiceBody">
                    <tr>
                        <td>1</td>
                        <td>
                            <select name="" id="item">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input id="currency" type="text" class="form-control" value="USD"></td>
                        <td><input id="rate" type="number" class="form-control" value="110"></td>
                        <td><input id="amount" type="number" class="form-control" value="1000"></td>
                        <td><input id="total" type="text" class="form-control" value="110000" readonly></td>
                        <td><button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary btn-sm" onclick="addRow()">+ Add Item</button>
        </div>
        <!-- Footer -->
        <div class="invoice-footer">
            <p>Thank you for using Global Money Exchange.</p>
            <p><small>This invoice confirms your transaction. Please retain for your records.</small></p>
            <div>
               <input class="btn btn-primary" type="button" value="Save" id="save" />
           </div>
        </div>

    </div>

    <!-- JavaScript for Dynamic Row Add/Delete -->
    <script>
        let rowCount = 1;

        function addRow() {
            rowCount++;
            const tbody = document.getElementById("invoiceBody");
            const row = document.createElement("tr");

            row.innerHTML = `
      <td>${rowCount}</td>
      <td><input type="text" class="form-control" placeholder="Description"></td>
      <td><input type="text" class="form-control" placeholder="Currency"></td>
      <td><input type="number" class="form-control" value="0"></td>
      <td><input type="number" class="form-control" value="0"></td>
      <td><input type="text" class="form-control" value="0" readonly></td>
      <td><button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
    `;

            tbody.appendChild(row);
        }

        function deleteRow(button) {
            const row = button.closest("tr");
            row.remove();
        }
    </script>
@endsection
