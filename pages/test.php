<?php
require '../includes/session.php';

if (!isset($_SESSION['participant_id'])) {
  header("Location: home.php");
  exit;
}

if (!isset($_SESSION['numbers'])) {
  header("Location: start_test.php");
  exit;
}

$numbers = $_SESSION['numbers'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Tes Pauli</title>

  <link rel="stylesheet" href="../tailwind/output.css">
  <!-- <link rel="stylesheet" href="../assets/css/test.css"> -->

</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-slate-200 min-h-screen">

  <!-- Overlay -->
  <div id="overlay"
    class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-10 text-center">

      <div
        class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-6">

        <span class="text-4xl">📝</span>

      </div>

      <h1 class="text-3xl font-bold text-slate-800 mb-3">

        Tes Pauli

      </h1>

      <p class="text-slate-500 mb-8">

        Pastikan Anda siap sebelum memulai tes.

      </p>

      <div class="bg-slate-50 rounded-2xl p-5 text-left">

        <ul class="space-y-3 text-slate-600">

          <li>✅ Kerjakan dari atas ke bawah</li>

          <li>✅ Isi digit terakhir hasil penjumlahan</li>

          <li>✅ Jangan refresh halaman</li>

          <li>✅ Waktu akan langsung berjalan</li>

        </ul>

      </div>

      <button id="startBtn"
        class="mt-8 w-full py-4 rounded-xl bg-blue-600 hover:bg-blue-700 transition text-white font-semibold text-lg shadow-lg">

        Mulai Tes

      </button>

    </div>

  </div>

  <!-- Header -->

  <header
    class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-slate-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">

      <div>

        <h2 class="text-2xl font-bold text-slate-800">

          Tes Pauli

        </h2>

        <p class="text-slate-500">

          Peserta :
          <span class="font-semibold">

            <?= $_SESSION['participant_code']; ?>

          </span>

        </p>

      </div>

      <div
        class="bg-red-600 text-white rounded-2xl px-8 py-4 shadow-xl">

        <div class="text-xs uppercase opacity-80">

          Sisa Waktu

        </div>

        <div
          id="timer"
          class="text-3xl font-bold tracking-widest">

          60:00

        </div>

      </div>

    </div>

  </header>

  <main class="max-w-7xl mx-auto px-8 py-8">

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

      <div
        class="px-8 py-5 border-b bg-gradient-to-r from-blue-600 to-indigo-600 text-white">

        <h3 class="text-xl font-semibold">

          Lembar Tes

        </h3>

        <p class="opacity-90 text-sm">

          Kerjakan secepat dan seteliti mungkin.

        </p>

      </div>

      <div class="p-8">

        <div id="paper" class="bg-white rounded-2xl shadow-xl p-6 overflow-auto">

          <!-- generator.js -->

        </div>

      </div>

    </div>

    <div class="text-center mt-10 mb-10">

      <button
        id="finishButton"
        class="bg-red-600 hover:bg-red-700 transition-all duration-300 hover:scale-105 text-white px-10 py-4 rounded-2xl font-semibold shadow-xl">

        🏁 Selesai Tes

      </button>

    </div>

  </main>

  <script>
    const numbers = <?= json_encode($numbers); ?>;
  </script>

  <script src="../assets/js/generator.js"></script>
  <script src="../assets/js/input.js"></script>
  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/timer.js"></script>

</body>

</html>