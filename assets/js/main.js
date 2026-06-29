
// ===============================
// START TES
// ===============================
const overlay = document.getElementById("overlay");
const startBtn = document.getElementById("startBtn");

startBtn.onclick = () => {

    overlay.style.display = "none";

    startTimer();
    highlight();

    if (cells && cells[0] && cells[0][1]) {
        cells[0][1].scrollIntoView({
            behavior: "smooth",
            block: "center"
        });
    }
};

// ===============================
// FINISH TES (FINAL CLEAN)
// ===============================
function finishTest() {

    fetch("../api/finish_test.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            answers: answers
        })
    })

    .then(res => res.text()) // pakai text dulu biar aman debug
    .then(text => {

        console.log("RAW RESPONSE:", text);

        let result;

        try {
            result = JSON.parse(text);
        } catch (e) {
            alert("Server error (bukan JSON):\n\n" + text);
            return;
        }

        if (!result.success) {
            alert(result.message || "Gagal menyimpan hasil");
            return;
        }

        // ❌ TIDAK ADA SCORE DI SINI
        // ✔ langsung ke halaman hasil

        window.location.href = "finish.php";

    })
    .catch(error => {
        console.error(error);
        alert("Gagal menghubungi server.");
    });
}

// ===============================
// BUTTON FINISH
// ===============================
document
.getElementById("finishButton")
.addEventListener("click", function () {

    if (confirm("Apakah Anda yakin ingin mengakhiri tes?")) {
        finishTest();
    }

});