<?php
$size = isset($_GET['gridSize']) ? intval($_GET['gridSize']) : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>2048 Iceberg Edition — Jeu</title>
  <link rel="stylesheet" href="2048.css">
</head>
<body>
  <header>
    <h1>🧊 2048 Iceberg Edition</h1>
    <p>Grille <?= $size ?>×<?= $size ?> générée</p>
    <button onclick="window.location.href='2048.php'" class="retour">🏠 Retour à l’accueil</button>
  </header>

  <main>
    <div id="gameContainer"></div>
    <div id="environment">
      <div class="penguin"></div>
      <div class="bear"></div>
      <div class="snow"></div>
    </div>
  </main>

  <!-- Popup de fin de partie -->
  <div id="gameOverPopup" class="popup hidden">
    <div class="popup-content">
      <h2>💥 Partie terminée !</h2>
      <p>Tu as perdu, la banquise est figée...</p>
      <button onclick="restartGame()">🔁 Recommencer</button>
      <button onclick="window.location.href='2048.php'">🚪 Quitter</button>
    </div>
  </div>

  <script>
let grid = [];
let size = <?= $size ?>;
let hasMovedOnce = false;

function generateGrid() {
  grid = Array(size).fill().map(() => Array(size).fill(0));
  addRandomTile();
  addRandomTile();
  renderGrid();
}

function addRandomTile() {
  const empty = [];
  for (let r = 0; r < size; r++) {
    for (let c = 0; c < size; c++) {
      if (grid[r][c] === 0) empty.push([r, c]);
    }
  }
  if (empty.length === 0) return;
  const [r, c] = empty[Math.floor(Math.random() * empty.length)];
  grid[r][c] = 2;
}

function renderGrid() {
  const container = document.getElementById("gameContainer");
  container.innerHTML = "";
  const gridDiv = document.createElement("div");
  gridDiv.className = "grid";
  gridDiv.style.setProperty('--size', size);

  // Largeur calculée pour éviter les bugs sur InfinityFree
  const totalWidth = size * 80 + (size - 1) * 14 + 28;
  gridDiv.style.width = totalWidth + "px";

  for (let r = 0; r < size; r++) {
    for (let c = 0; c < size; c++) {
      const cell = document.createElement("div");
      cell.className = grid[r][c] ? "cell-glacon" : "cell";
      cell.textContent = grid[r][c] || "";
      gridDiv.appendChild(cell);
    }
  }

  container.appendChild(gridDiv);
}

function slideRowLeft(row) {
  const newRow = row.filter(val => val !== 0);
  for (let i = 0; i < newRow.length - 1; i++) {
    if (newRow[i] === newRow[i + 1]) {
      newRow[i] *= 2;
      newRow[i + 1] = 0;
    }
  }
  return [...newRow.filter(val => val !== 0), ...Array(size - newRow.filter(val => val !== 0).length).fill(0)];
}

function slideRowRight(row) {
  const reversed = [...row].reverse();
  const slid = slideRowLeft(reversed);
  return slid.reverse();
}

function transpose(matrix) {
  return matrix[0].map((_, i) => matrix.map(row => row[i]));
}

function moveLeft() {
  let moved = false;
  for (let r = 0; r < size; r++) {
    const newRow = slideRowLeft(grid[r]);
    if (JSON.stringify(newRow) !== JSON.stringify(grid[r])) {
      grid[r] = newRow;
      moved = true;
    }
  }
  if (moved) {
    hasMovedOnce = true;
    addRandomTile();
    renderGrid();
    if (hasMovedOnce && isGameOver()) showGameOver();
  }
}

function moveRight() {
  let moved = false;
  for (let r = 0; r < size; r++) {
    const newRow = slideRowRight(grid[r]);
    if (JSON.stringify(newRow) !== JSON.stringify(grid[r])) {
      grid[r] = newRow;
      moved = true;
    }
  }
  if (moved) {
    hasMovedOnce = true;
    addRandomTile();
    renderGrid();
    if (hasMovedOnce && isGameOver()) showGameOver();
  }
}

function moveUp() {
  grid = transpose(grid);
  let moved = false;
  for (let r = 0; r < size; r++) {
    const newRow = slideRowLeft(grid[r]);
    if (JSON.stringify(newRow) !== JSON.stringify(grid[r])) {
      grid[r] = newRow;
      moved = true;
    }
  }
  grid = transpose(grid);
  if (moved) {
    hasMovedOnce = true;
    addRandomTile();
    renderGrid();
    if (hasMovedOnce && isGameOver()) showGameOver();
  }
}

function moveDown() {
  grid = transpose(grid);
  let moved = false;
  for (let r = 0; r < size; r++) {
    const newRow = slideRowRight(grid[r]);
    if (JSON.stringify(newRow) !== JSON.stringify(grid[r])) {
      grid[r] = newRow;
      moved = true;
    }
  }
  grid = transpose(grid);
  if (moved) {
    hasMovedOnce = true;
    addRandomTile();
    renderGrid();
    if (hasMovedOnce && isGameOver()) showGameOver();
  }
}

function isGameOver() {
  for (let r = 0; r < size; r++) {
    for (let c = 0; c < size; c++) {
      const val = grid[r][c];
      if (val === 0) return false;

      // Vérifie les cases adjacentes
      if (c < size - 1 && grid[r][c] === grid[r][c + 1]) return false;
      if (r < size - 1 && grid[r][c] === grid[r + 1][c]) return false;
    }
  }
  return true;
}


function showGameOver() {
  document.getElementById("gameOverPopup").classList.remove("hidden");
}

function restartGame() {
  grid = Array(size).fill().map(() => Array(size).fill(0));
  addRandomTile();
  addRandomTile();
  renderGrid();
  hasMovedOnce = false;
  document.getElementById("gameOverPopup").classList.add("hidden");
}

document.addEventListener("keydown", (e) => {
  const keys = ["ArrowLeft", "ArrowRight", "ArrowUp", "ArrowDown"];
  if (keys.includes(e.key)) {
    e.preventDefault();
    if (e.key === "ArrowLeft") moveLeft();
    if (e.key === "ArrowRight") moveRight();
    if (e.key === "ArrowUp") moveUp();
    if (e.key === "ArrowDown") moveDown();
  }
});

window.onload = generateGrid;
</script>
</body>
</html>
