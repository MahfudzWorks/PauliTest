const paper = document.getElementById("paper");

const ROWS = numbers[0].length;
const COLS = numbers.length;

const cells = [];

let currentRow = 1;
let currentCol = 0;

paper.innerHTML = "";

// GRID WRAPPER (TAILWIND VERSION)
const grid = document.createElement("div");
grid.className = "flex gap-4 w-max";

for (let c = 0; c < COLS; c++) {

    cells[c] = [];

    const column = document.createElement("div");
    column.className = "flex flex-col px-2 py-2 rounded-lg transition";

    for (let r = 0; r < ROWS; r++) {

        const row = document.createElement("div");
        row.className = "flex items-center gap-2 py-[2px]";

        const number = document.createElement("span");
        number.className = "w-6 text-right text-sm text-slate-700";
        number.textContent = numbers[c][r];

        row.appendChild(number);

        if (r > 0) {

            const answer = document.createElement("span");
            answer.className = "w-6 h-5 border-b border-slate-400 text-center text-sm font-semibold";

            answer.dataset.col = c;
            answer.dataset.row = r;

            row.appendChild(answer);

            cells[c][r] = answer;
        }

        column.appendChild(row);
    }

    grid.appendChild(column);
}

paper.appendChild(grid);

console.log("Soal berhasil dibuat");

function setActiveColumn(col) {

    document.querySelectorAll("#paper > div > div").forEach((el, i) => {
        if (i === col) {
            el.classList.add("bg-blue-50", "ring-2", "ring-blue-500", "rounded-lg");
        } else {
            el.classList.remove("bg-blue-50", "ring-2", "ring-blue-500");
        }
    });

}