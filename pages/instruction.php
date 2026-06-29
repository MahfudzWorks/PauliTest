<?php

require '../includes/session.php';

if (!isset($_SESSION['participant_id'])) {

  header("Location: home.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <title>Petunjuk Tes | PauliTest</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../tailwind/output.css">

</head>

<body class="bg-slate-100">

  <div class="min-h-screen flex items-center justify-center px-5 py-10">

    <div class="bg-white rounded-3xl shadow-xl w-full max-w-3xl p-10">

      <div class="text-center">

        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto text-white text-3xl">

          📋

        </div>

        <h1 class="text-3xl font-bold mt-6">

          Petunjuk Tes

        </h1>

        <p class="text-gray-500 mt-3">

          Bacalah petunjuk berikut dengan saksama sebelum memulai tes.

        </p>

      </div>

      <div class="mt-10 space-y-5">

        <div class="flex gap-4">

          <div class="text-2xl">⏱️</div>

          <div>

            <h3 class="font-semibold">Waktu Tes</h3>

            <p class="text-gray-600">
              Kerjakan tes sesuai waktu yang telah ditentukan.
            </p>

          </div>

        </div>

        <div class="flex gap-4">

          <div class="text-2xl">🌐</div>

          <div>

            <h3 class="font-semibold">
              Koneksi Internet
            </h3>

            <p class="text-gray-600">
              Pastikan koneksi internet Anda stabil selama tes berlangsung.
            </p>

          </div>

        </div>

        <div class="flex gap-4">

          <div class="text-2xl">🚫</div>

          <div>

            <h3 class="font-semibold">
              Jangan Refresh Halaman
            </h3>

            <p class="text-gray-600">
              Jangan menutup atau me-refresh browser ketika tes berlangsung.
            </p>

          </div>

        </div>

        <div class="flex gap-4">

          <div class="text-2xl">✅</div>

          <div>

            <h3 class="font-semibold">
              Satu Kali Kesempatan
            </h3>

            <p class="text-gray-600">
              Tes hanya dapat dikerjakan satu kali.
            </p>

          </div>

        </div>

      </div>

      <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-5 mt-10">

        <h3 class="font-semibold text-yellow-700">

          Perhatian

        </h3>

        <p class="text-gray-700 mt-2">

          Setelah tombol <b>"Mulai Tes"</b> ditekan, waktu akan langsung berjalan dan tidak dapat dihentikan.

        </p>

      </div>

      <div class="mt-8">

        <a href="start_test.php"
          class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold">

          Saya Mengerti, Mulai Tes

        </a>

      </div>

    </div>

  </div>

</body>

</html>