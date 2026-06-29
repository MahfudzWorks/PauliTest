<?php
require '../config/database.php';

// approve manual (fallback)
if (isset($_GET['approve'])) {
  $id = (int) $_GET['approve'];

  mysqli_query($conn, "
    UPDATE test_results 
    SET is_paid = 1 
    WHERE id = $id
  ");

  header("Location: payments.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Admin Payments</title>
  <link rel="stylesheet" href="../tailwind/output.css">
</head>

<body class="bg-slate-100">

  <!-- HEADER -->
  <div class="bg-white border-b shadow-sm">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

      <div>
        <h1 class="text-2xl font-bold text-slate-800">Konfirmasi Pembayaran</h1>
        <p class="text-sm text-slate-500">Dashboard admin realtime</p>
      </div>

      <div class="text-sm text-slate-500">
        🔄 Auto Refresh
      </div>

    </div>
  </div>

  <!-- CONTAINER -->
  <div class="max-w-6xl mx-auto p-6">

    <!-- GRID -->
    <div id="cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <!-- data realtime -->
    </div>

  </div>

  <script>
    async function loadData() {
      const res = await fetch("payments_data.php");
      const data = await res.json();

      const container = document.getElementById("cards");
      container.innerHTML = "";

      data.forEach(row => {

        const status = row.is_paid == 1 ?
          `<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">PAID</span>` :
          `<span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">UNPAID</span>`;

        const action = row.is_paid == 0 ?
          `<button onclick="approve(${row.id})"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
          Approve
        </button>` :
          `<div class="text-gray-400 text-sm">✔ Done</div>`;

        container.innerHTML += `
      <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">

        <div class="flex justify-between items-start mb-3">
          <h2 class="font-bold text-slate-800">${row.fullname}</h2>
          ${status}
        </div>

        <p class="text-sm text-slate-500 mb-4">
          ${row.created_at}
        </p>

        <div class="flex justify-between items-center">
          <div class="text-xs text-slate-400">
            ID: #${row.id}
          </div>

          ${action}
        </div>

      </div>
    `;
      });
    }

    async function approve(id) {
      await fetch("approve.php?id=" + id);
      loadData();
    }

    // realtime
    loadData();
    setInterval(loadData, 3000);
  </script>

</body>

</html>