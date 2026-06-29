<?php

require '../includes/session.php';
require '../config/database.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['participant_id'])) {
  header("Location: home.php");
  exit;
}

$id = (int)$_SESSION['participant_id'];

$query = mysqli_query($conn, "
SELECT
    p.fullname,
    tr.correct,
    tr.wrong,
    tr.blank,
    tr.score,
    tr.created_at,
    tr.is_paid
FROM test_results tr
JOIN participants p ON p.id = tr.participant_id
WHERE tr.participant_id = $id
ORDER BY tr.id DESC
LIMIT 1
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
  die("Data hasil tes tidak ditemukan.");
}

$isPaid = $data['is_paid'] ?? 0;

?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Tes Berhasil Diselesaikan</title>

  <link rel="stylesheet" href="../tailwind/output.css">

</head>

<body class="bg-slate-100">

  <div class="min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-10">

      <div class="text-center">

        <div class="w-24 h-24 bg-green-100 rounded-full mx-auto flex items-center justify-center">

          <span class="text-5xl">✅</span>

        </div>

        <h1 class="text-4xl font-bold mt-6 text-slate-800">

          Tes Berhasil Diselesaikan

        </h1>

        <p class="text-slate-500 mt-3">

          Terima kasih telah mengikuti simulasi Tes Pauli.

          Jawaban Anda telah tersimpan di dalam sistem.

        </p>

      </div>

      <div id="resultBox"></div>

      <div class="mt-10 bg-slate-50 rounded-xl p-6">

        <div class="flex justify-between py-2">

          <span class="text-gray-500">

            Nama Peserta

          </span>

          <b>

            <?= htmlspecialchars($data['fullname']); ?>

          </b>

        </div>

        <div class="flex justify-between py-2">

          <span class="text-gray-500">

            Tanggal Tes

          </span>

          <b>

            <?= date('d M Y H:i', strtotime($data['created_at'])); ?>

          </b>

        </div>

        <div class="flex justify-between py-2">

          <span class="text-gray-500">

            Status

          </span>

          <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

            Selesai

          </span>

        </div>

      </div>

      <div class="mt-10">

        <a
          href="home.php"
          class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-xl font-semibold transition">

          Kembali ke Halaman Utama

        </a>

      </div>

    </div>

  </div>

  <script>
    async function loadResult() {
      const res = await fetch("../api/check_payment.php");
      const data = await res.json();

      const box = document.getElementById("resultBox");

      if (data.is_paid == 1) {
        box.innerHTML = `
          <div class="grid grid-cols-2 gap-5 mt-10">

            <div class="bg-blue-50 rounded-xl p-5 text-center">
              <p class="text-gray-500">Benar</p>
              <h2 class="text-4xl font-bold text-blue-600">${data.correct}</h2>
            </div>

            <div class="bg-red-50 rounded-xl p-5 text-center">
              <p class="text-gray-500">Salah</p>
              <h2 class="text-4xl font-bold text-red-600">${data.wrong}</h2>
            </div>

            <div class="bg-yellow-50 rounded-xl p-5 text-center">
              <p class="text-gray-500">Kosong</p>
              <h2 class="text-4xl font-bold text-yellow-500">${data.blank}</h2>
            </div>

            <div class="bg-green-50 rounded-xl p-5 text-center">
              <p class="text-gray-500">Skor</p>
              <h2 class="text-4xl font-bold text-green-600">${data.score}%</h2>
            </div>

          </div>`;
      } else {
        box.innerHTML = `
          <div class="mt-10 text-center bg-yellow-50 p-6 rounded-xl border">
            <h2 class="text-xl font-bold text-slate-700 mb-2">
              Hasil Tes Terkunci 🔒
            </h2>

            <p class="text-slate-600 mb-3">
              Silakan lakukan pembayaran untuk membuka hasil.
            </p>

            <div class="text-3xl font-bold text-blue-600 mb-6">
              Rp 5.000
            </div>

            <div class="flex justify-center mb-4">
              <img src="../assets/img/qris-dana.png" class="w-64 rounded-xl shadow">
            </div>

            <a href="https://wa.me/6282140363716"
              class="inline-block bg-green-500 text-white px-6 py-3 rounded-xl">
              Konfirmasi ke Admin
            </a>
          </div>`;
      }
    }

    loadResult();
    setInterval(loadResult, 3000);
  </script>

</body>

</html>