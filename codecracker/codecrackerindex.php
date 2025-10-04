<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil — Code Cracker</title>
  <link rel="stylesheet" href="codecracker.css">
</head>
<body>
  <h1>🔐 Code Cracker</h1>
  <p>Bienvenue dans le jeu de déduction ultime !</p>

  <div class="rules">
    <h2>📜 Règles du jeu</h2>
    <p>Un code secret composé de chiffres est généré aléatoirement.</p>
    <p>À chaque tentative, tu reçois des indices :</p>
    <ul>
      <li><span class="green">🟢</span> chiffre correct à la bonne position</li>
      <li><span class="yellow">🟡</span> chiffre correct à la mauvaise position</li>
      <li><span class="red">🔴</span> chiffre absent du code</li>
    </ul>
    <p>Devine le code en un minimum d’essais !</p>
  </div>

  <div class="difficulty">
    <h2>🎯 Choisis la difficulté</h2>
    <label for="digitCount">Nombre de chiffres :</label><br><br>
    <select id="digitCount">
      <option value="4">Facile — 4 chiffres</option>
      <option value="5">Moyen — 5 chiffres</option>
      <option value="6">Difficile — 6 chiffres</option>
    </select>
    <br><br>
    <button onclick="startGame()">Commencer</button>
  </div>
  <script>

    function goBack() {
    window.location.href = "../index.php";
  }
    function startGame() {
      const digits = document.getElementById("digitCount").value;
      window.location.href = `codecracker.php?digits=${digits}`;
    }
  </script>
</body>
</html>
