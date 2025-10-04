<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Cemantix — Accueil</title>
  <link rel="stylesheet" href="cemantix.css">
</head>
<body>
  <h1>🧠 Cemantix</h1>
  <p>Bienvenue dans le jeu de déduction sémantique !</p>

  <div class="rules">
    <h2>📜 Règles du jeu</h2>
    <p>Un mot mystère est caché. À chaque mot proposé, tu obtiens un score de proximité :</p>
    <ul>
      <li>🔵 Score faible → mot éloigné</li>
      <li>🟡 Score moyen → mot partiellement lié</li>
      <li>🔴 Score élevé → mot très proche</li>
    </ul>
    <p>Devine le mot en un minimum d’essais !</p>
  </div>

  <div class="difficulty">
    <button onclick="startGame()">Commencer</button>
    <br><br>
    <button onclick="goBack()">Retour à l’accueil des jeux</button>
  </div>

  <script>
    function startGame() {
      window.location.href = "cemantixgame.php";
    }
    function goBack() {
      window.location.href = "../index.php"; // ou ta page centrale de jeux
    }
  </script>
</body>
</html>
