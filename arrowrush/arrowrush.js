const difficulty = new URLSearchParams(window.location.search).get('difficulty');
const gameArea = document.getElementById('game-area');
const scoreDisplay = document.getElementById('score');
let score = 0;

const settings = {
  simple:    { speed: 2, interval: 1500 },
  difficile: { speed: 4, interval: 1000 },
  hardcore:  { speed: 6, interval: 600 }
};

const { speed, interval } = settings[difficulty] || settings.simple;

function spawnArrow() {
  const directions = ['left', 'down', 'up', 'right'];
  const dir = directions[Math.floor(Math.random() * directions.length)];
  const column = document.querySelector(`.column[data-direction="${dir}"]`);
  const arrow = document.createElement('div');
  arrow.classList.add('arrow', dir);
  arrow.style.top = '0px';
  arrow.dataset.direction = dir;

  // Centrer la flèche dans sa colonne
  arrow.style.left = `${(column.offsetWidth - 60) / 2}px`;

  column.appendChild(arrow);
}


function moveArrows() {
  document.querySelectorAll('.arrow').forEach(arrow => {
    let top = parseInt(arrow.style.top);
    top += speed;
    arrow.style.top = `${top}px`;

    if (top > 500 && !arrow.dataset.hit) {
      arrow.dataset.hit = true;
      score -= 5;
      scoreDisplay.textContent = `Score : ${score}`;
      arrow.remove();
    }
  });
}

function checkHit(key) {
  document.querySelectorAll('.arrow').forEach(arrow => {
    const top = parseInt(arrow.style.top);
    const lineY = gameArea.offsetHeight - 100; // position de la ligne rouge
    const tolerance = 40; // marge de détection

    if (
      Math.abs(top - lineY) < tolerance &&
      arrow.dataset.direction === key &&
      !arrow.dataset.hit
    ) {
      arrow.dataset.hit = true;
      score += 10;
      scoreDisplay.textContent = `Score : ${score}`;
      arrow.remove();
    }
  });
}


setInterval(spawnArrow, interval);
setInterval(moveArrows, 30);

document.addEventListener('keydown', e => {
  const map = { ArrowUp: 'up', ArrowDown: 'down', ArrowLeft: 'left', ArrowRight: 'right' };
  if (map[e.key]) checkHit(map[e.key]);
});
