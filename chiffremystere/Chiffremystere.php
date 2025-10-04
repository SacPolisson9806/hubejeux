<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Chiffre Mystère</title>
  <link rel="stylesheet" href="Chiffremystere.css">
</head>
<body>
  <header>
    <h1>🎲 Jeu du Chiffre Mystère</h1>
    <p>Devine le chiffre choisi par l’ordinateur !</p>
  </header>

  <div id="game">
    <input type="number" id="guess" min="1" max="100" placeholder="1-100">
    <button onclick="checkGuess()">Essayer</button>
    <p id="message"></p>
    <a href="../index.php">⬅ Retour au hub de jeux</a>
  </div>

  <script>
    let secret = Math.floor(Math.random() * 100) + 1;
    let attempts = 0;

    function checkGuess() {
      const guess = Number(document.getElementById("guess").value);
      attempts++;
      let message = "";

      if (!guess || guess < 1 || guess > 100) {
        message = "⚠️ Entre un nombre entre 1 et 100 !";
      } else if (guess === secret) {
        message = `🎉 Bravo ! Tu as trouvé le chiffre ${secret} en ${attempts} essais.`;
      } else if (guess < secret) {
        message = "🔼 Trop petit !";
      } else {
        message = "🔽 Trop grand !";
      }

      document.getElementById("message").innerText = message;
    }
  </script>
</body>
</html>
