// ===============================
// MENYIMPAN JAWABAN PESERTA
// ===============================

const answers = [];

for (let c = 0; c < COLS; c++) {

    answers[c] = [];

    for (let r = 0; r < ROWS; r++) {

        answers[c][r] = "";

    }

}

// ===============================

function highlight() {

    document
        .querySelectorAll(".answer")
        .forEach(el => el.classList.remove("active"));

    cells[currentCol][currentRow].classList.add("active");

}

// ===============================

function nextCell() {

    currentRow++;

    if (currentRow >= ROWS) {

        currentRow = 1;

        currentCol++;

        if (currentCol >= COLS) {

            finishTest();

            return;

        }

    }

    highlight();

    cells[currentCol][currentRow].scrollIntoView({

        behavior: "smooth",
        block: "center"

    });

}

// ===============================

function previousCell() {

    currentRow--;

    if (currentRow < 1) {

        if (currentCol > 0) {

            currentCol--;

            currentRow = ROWS - 1;

        } else {

            currentRow = 1;

        }

    }

    highlight();

}

// ===============================

document.addEventListener("keydown", function (e) {

    if (document.getElementById("overlay").style.display !== "none")
        return;

    // Input angka
    if (e.key >= "0" && e.key <= "9") {

        cells[currentCol][currentRow].textContent = e.key;

        answers[currentCol][currentRow] = e.key;

        nextCell();

    }

    // Hapus
    if (e.key === "Backspace") {

        e.preventDefault();

        previousCell();

        cells[currentCol][currentRow].textContent = "";

        answers[currentCol][currentRow] = "";

    }

});