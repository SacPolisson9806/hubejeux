<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Course d'Évitement</title>
  <link rel="stylesheet" href="voiture.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
  <canvas id="gameCanvas" width="400" height="600"></canvas>
  <div id="scoreDisplay">⏱ Temps : 0s</div>
  <div id="gameOver" class="hidden">💥 Collision ! Game Over</div>

  <script>
    const canvas = document.getElementById("gameCanvas");
    const ctx = canvas.getContext("2d");

    // Récupération du sprite choisi via l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const selectedCar = urlParams.get("car") || "images/car-red.png";

    // Initialisation du joueur
    let player = {
      x: 180,
      y: 500,
      width: 40,
      height: 80,
      sprite: selectedCar
    };

    // Fonction pour dessiner la voiture du joueur
    function drawCar(obj) {
      const img = new Image();
      img.src = obj.sprite;
      ctx.drawImage(img, obj.x, obj.y, obj.width, obj.height);
    }

    // Fonction pour dessiner les obstacles (rectangles rouges)
    function drawRect(obj) {
      ctx.fillStyle = obj.color;
      ctx.fillRect(obj.x, obj.y, obj.width, obj.height);
    }

    let obstacles = [];
    let speed = 4;
    let survivalTime = 0;
    let isGameOver = false;

    function spawnObstacle() {
      if (!isGameOver) {
        const x = Math.random() * (canvas.width - 40);
        obstacles.push({ x, y: -80, width: 40, height: 80, color: "red" });
      }
    }

    function handleCollision() {
      isGameOver = true;
      clearInterval(gameLoop);
      clearInterval(obstacleLoop);
      clearInterval(speedLoop);
      document.getElementById("gameOver").classList.remove("hidden");

      setTimeout(() => {
        window.location.href = "accueil.php";
      }, 1500);
    }

    function update() {
      if (isGameOver) return;

      ctx.clearRect(0, 0, canvas.width, canvas.height);
      drawCar(player);

      obstacles.forEach((obs, i) => {
        obs.y += speed;
        drawRect(obs);

        if (
          obs.x < player.x + player.width &&
          obs.x + obs.width > player.x &&
          obs.y < player.y + player.height &&
          obs.y + obs.height > player.y
        ) {
          handleCollision();
        }

        if (obs.y > canvas.height) obstacles.splice(i, 1);
      });
    }

    let gameLoop = setInterval(update, 1000 / 60);
    let obstacleLoop = setInterval(spawnObstacle, 1500);
    let speedLoop = setInterval(() => {
      if (!isGameOver) {
        survivalTime += 1;
        document.getElementById("scoreDisplay").textContent = `⏱ Temps : ${survivalTime}s`;
        if (survivalTime % 5 === 0) {
          speed += 0.5;
        }
      }
    }, 1000);

    document.addEventListener("keydown", (e) => {
      if (isGameOver) return;
      if (e.key === "ArrowLeft" && player.x > 0) player.x -= 20;
      if (e.key === "ArrowRight" && player.x < canvas.width - player.width) player.x += 20;
    });
  </script>
</body>
</html>
