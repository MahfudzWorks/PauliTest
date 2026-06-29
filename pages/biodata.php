<?php
require '../includes/session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Data Peserta | PauliTest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../tailwind/output.css">
</head>

<body class="bg-slate-100">

  <div class="min-h-screen flex items-center justify-center px-5 py-10">

    <div class="bg-white rounded-3xl shadow-xl w-full max-w-3xl">

      <div class="bg-blue-600 rounded-t-3xl p-8 text-white">

        <h1 class="text-3xl font-bold">
          Data Peserta
        </h1>

        <p class="mt-2 text-blue-100">
          Silakan lengkapi data berikut sebelum memulai tes.
        </p>

      </div>

      <form action="../process/save_participant.php" method="POST" class="p-8 space-y-6">

        <div>

          <label class="font-semibold">
            Nama Lengkap
          </label>

          <input
            type="text"
            name="fullname"
            required
            class="mt-2 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

        </div>

        <div class="grid md:grid-cols-2 gap-5">

          <div>

            <label class="font-semibold">
              Usia
            </label>

            <input
              type="number"
              name="age"
              min="15"
              max="60"
              required
              class="mt-2 w-full border rounded-xl px-4 py-3">

          </div>

          <div>

            <label class="font-semibold">
              Jenis Kelamin
            </label>

            <select
              name="gender"
              required
              class="mt-2 w-full border rounded-xl px-4 py-3">

              <option value="">Pilih</option>
              <option>Laki-laki</option>
              <option>Perempuan</option>

            </select>

          </div>

        </div>

        <div>

          <label class="font-semibold">
            Pendidikan Terakhir
          </label>

          <select
            name="education"
            required
            class="mt-2 w-full border rounded-xl px-4 py-3">

            <option value="">Pilih Pendidikan</option>
            <option>SMA / SMK</option>
            <option>Diploma</option>
            <option>S1</option>
            <option>S2</option>

          </select>

        </div>

        <div>

          <label class="font-semibold">
            Email (Opsional)
          </label>

          <input
            type="email"
            name="email"
            class="mt-2 w-full border rounded-xl px-4 py-3">

        </div>

        <div class="flex items-start gap-3">

          <input
            type="checkbox"
            required
            class="mt-1">

          <p class="text-gray-600 text-sm">

            Saya menyatakan bahwa data yang saya isi adalah benar dan bersedia mengikuti Tes Pauli.

          </p>

        </div>

        <button
          class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold transition">

          Lanjutkan

        </button>

      </form>

    </div>

  </div>

</body>

</html>