let timerInterval = null;

function startTimer() {

    const timerElement = document.getElementById("timer");

    if (!timerElement) return;

    // reset waktu setiap mulai
    window.duration = 10 * 60;

    // cegah double interval
    if (timerInterval) clearInterval(timerInterval);

    timerInterval = setInterval(() => {

        window.duration--;

        const m = Math.floor(window.duration / 60);
        const s = window.duration % 60;

        timerElement.innerHTML =
            String(m).padStart(2, '0') + ":" +
            String(s).padStart(2, '0');

        if (window.duration <= 0) {

            clearInterval(timerInterval); // 🔥 PENTING

            timerElement.innerHTML = "00:00";

            finishTest();
        }

    }, 1000);
}