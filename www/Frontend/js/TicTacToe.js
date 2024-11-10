const cellContainer = document.querySelector("#cellContainer");
const statusText = document.querySelector("#statusText");
const restartBtn = document.querySelector("#restartBtn");
let cells = [];
const gridSize = 15;
let options = Array(gridSize * gridSize).fill("");
let currentPlayer = Math.random() < 0.5 ? "X" : "O";
let running = true;

function createCells() {
    cellContainer.innerHTML = "";
    for (let i = 0; i < gridSize * gridSize; i++) {
        const cell = document.createElement("div");
        cell.classList.add("cell");
        cell.setAttribute("cellIndex", i);
        cell.addEventListener("click", cellClicked);
        cellContainer.appendChild(cell);
        cells.push(cell);
    }
}

initializeGame();

function initializeGame(){
    createCells();
    restartBtn.addEventListener("click", restartGame);
    statusText.textContent = `${currentPlayer}'s turn`;
}

function cellClicked() {
    const cellIndex = this.getAttribute("cellIndex");

    if (options[cellIndex] !== "" || !running) {
        return;
    }
    updateCell(this, cellIndex);
    checkWinner(parseInt(cellIndex));
}

function updateCell(cell, index) {
    options[index] = currentPlayer;
    cell.textContent = currentPlayer;
}

function changePlayer() {
    currentPlayer = (currentPlayer === "X") ? "O" : "X";
    statusText.textContent = `${currentPlayer}'s turn`;
}

function checkWinner(index) {
    const row = Math.floor(index / gridSize);
    const col = index % gridSize;
    
    if (checkDirection(row, col, 1, 0) || 
        checkDirection(row, col, 0, 1) || 
        checkDirection(row, col, 1, 1) || 
        checkDirection(row, col, 1, -1)) {
        statusText.textContent = `${currentPlayer} wins!`;
        running = false;
    } else if (!options.includes("")) {
        statusText.textContent = `Draw!`;
        running = false;
    } else {
        changePlayer();
    }
}

function checkDirection(row, col, rowDir, colDir) {
    let count = 0;

    for (let i = -4; i <= 4; i++) {
        const r = row + i * rowDir;
        const c = col + i * colDir;

        if (r >= 0 && r < gridSize && c >= 0 && c < gridSize &&
            options[r * gridSize + c] === currentPlayer) {
            count++;
            if (count === 5) {
                return true;
            }
        } else {
            count = 0;
        }
    }
    return false;
}

function restartGame() {
    currentPlayer = Math.random() < 0.5 ? "X" : "O";
    options.fill("");
    cells.forEach(cell => cell.textContent = "");
    statusText.textContent = `${currentPlayer}'s turn`;
    running = true;
}

