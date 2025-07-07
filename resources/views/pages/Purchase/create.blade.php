@extends('layouts.master');
@section('pages')

 <style>
    /* Root Colors */
    :root {
      --primary-color: #2c3e50;  /* Dark Blue */
      --secondary-color: #3498db; /* Blue Accent */
      --main-bg-color: #ecf0f1;   /* Light Gray */
      --footer-color: #34495e;    /* Darker Blue */
      --button-color: #2980b9;    /* Button Blue */
      --table-head-color: #2980b9;/* Table Head Blue */
      --text-light: #fff;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--main-bg-color);
    }

    /* Header */
    header {
      background-color: var(--primary-color);
      color: var(--text-light);
      padding: 20px;
      display: flex;
      align-items: center;
    }

    header img {
      height: 40px;
      margin-right: 20px;
    }

    header h1 {
      margin: 0;
    }

    /* Main Content */
    main {
      background-color: var(--main-bg-color);
      padding: 30px;
      min-height: 70vh;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th {
      background-color: var(--table-head-color);
      color: var(--text-light);
      padding: 12px;
    }

    td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }

    tfoot td {
      font-weight: bold;
      background: #f8f8f8;
    }

    input[type="text"], input[type="number"] {
      width: 100%;
      box-sizing: border-box;
      padding: 5px;
    }

    button {
      background-color: var(--button-color);
      color: var(--text-light);
      border: none;
      padding: 8px 12px;
      cursor: pointer;
      border-radius: 4px;
    }

    button:hover {
      background-color: #1c6690;
    }

    /* Footer */
    footer {
      background-color: var(--footer-color);
      color: var(--text-light);
      text-align: center;
      padding: 15px;
    }
  </style>
</head>
<body>
  <!-- Header with Logo -->
  <header>
    <img src="https://via.placeholder.com/40x40.png?text=Logo" alt="Logo">
    <h1>My Company Invoice</h1>
  </header>

  <!-- Main Content -->
  <main>
    <table id="cartTable">
      <thead>
        <tr>
          <th>Currency</th>
          <th>Name</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>VAT (%)</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
        <tr>
          <td><input type="text" id="currency" name="currency" value="USD" /></td>
          <td><input type="text" id="name" name="name" /></td>
          <td><input type="number" id="qty" name="qty" value="1" /></td>
          <td><input type="number" id="rate" name="rate" value="0" /></td>
          <td><input type="number" id="vat" name="vat" value="5" /></td>
          <td>—</td>
          <td><button onclick="addProduct()">Add</button></td>
        </tr>
      </thead>
      <tbody id="cartBody"></tbody>
      <tfoot>
        <tr>
          <td colspan="5">Subtotal</td>
          <td colspan="2" id="subtotal">0</td>
        </tr>
        <tr>
          <td colspan="5">Total VAT</td>
          <td colspan="2" id="totalVat">0</td>
        </tr>
        <tr>
          <td colspan="5">Grand Total</td>
          <td colspan="2" id="grandTotal">0</td>
        </tr>
      </tfoot>
    </table>

    <button onclick="saveCart()">Save Invoice</button>
    <button onclick="printInvoice()">Print</button>
  </main>

  <!-- Footer -->
  <footer>
    &copy; 2025 My Company. All rights reserved.
  </footer>

  <!-- JS -->
  <script>
    let cart = [];

    function addProduct() {
      const currency = document.getElementById('currency').value.trim();
      const name = document.getElementById('name').value.trim();
      const qty = parseFloat(document.getElementById('qty').value);
      const rate = parseFloat(document.getElementById('rate').value);
      const vat = parseFloat(document.getElementById('vat').value);

      if (!name || qty <= 0 || rate <= 0) {
        alert('Please enter valid product details.');
        return;
      }

      const totalWithoutVat = qty * rate;
      const totalVat = totalWithoutVat * (vat / 100);
      const total = totalWithoutVat + totalVat;

      const product = { currency, name, qty, rate, vat, total };
      cart.push(product);

      updateCartTable();
      updateTotals();
      saveToLocalStorage();
    }

    function updateCartTable() {
      const tbody = document.getElementById('cartBody');
      tbody.innerHTML = '';

      cart.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${item.currency}</td>
          <td>${item.name}</td>
          <td>${item.qty}</td>
          <td>${item.rate.toFixed(2)}</td>
          <td>${item.vat}%</td>
          <td>${item.total.toFixed(2)}</td>
          <td><button onclick="removeProduct(${index})">Remove</button></td>
        `;
        tbody.appendChild(row);
      });
    }

    function removeProduct(index) {
      cart.splice(index, 1);
      updateCartTable();
      updateTotals();
      saveToLocalStorage();
    }

    function updateTotals() {
      let subtotal = 0;
      let totalVat = 0;

      cart.forEach(item => {
        const totalWithoutVat = item.qty * item.rate;
        subtotal += totalWithoutVat;
        totalVat += totalWithoutVat * (item.vat / 100);
      });

      const grandTotal = subtotal + totalVat;

      document.getElementById('subtotal').innerText = subtotal.toFixed(2);
      document.getElementById('totalVat').innerText = totalVat.toFixed(2);
      document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);
    }

    function saveToLocalStorage() {
      localStorage.setItem('cart', JSON.stringify(cart));
    }

    function loadCart() {
      const savedCart = localStorage.getItem('cart');
      if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartTable();
        updateTotals();
      }
    }

    function saveCart() {
      alert('Cart saved to database! (Simulated)');
      console.log('Sending to API:', cart);
    }

    function printInvoice() {
      window.print();
    }

    window.onload = loadCart;
  </script>


  <h2>💱 Money Exchange Invoice</h2>








@endsection
