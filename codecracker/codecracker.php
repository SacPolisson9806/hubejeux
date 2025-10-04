<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Code Cracker — Jeu</title>
  <link rel="stylesheet" href="codecracker.css">
</head>
<body>
  <h1>🎮 Code Cracker</h1>
  <p id="instructions">Devine le code secret</p>

  <input type="text" id="guessInput" placeholder="Ex: 1234">
  <button onclick="checkGuess()">Essayer</button>

  <div class="feedback" id="feedback"></div>
  <br><br>
<button onclick="goBack()">Retour à l’accueil</button>


  <script>
    // Récupère le nombre de chiffres depuis l'URL
    const params = new URLSearchParams(window.location.search);
    const digitCount = parseInt(params.get("digits")) || 4;

    // Met à jour l'interface
    document.getElementById("instructions").textContent = `Devine le code secret à ${digitCount} chiffres`;

    // Génère le code secret
    const secret = [];
    while (secret.length < digitCount) {
      const digit = Math.floor(Math.random() * 10);
      if (!secret.includes(digit)) secret.push(digit);
    }

    function checkGuess() {
      const input = document.getElementById("guessInput").value;
      if (input.length !== digitCount || isNaN(input)) return;

      const guess = input.split('').map(Number);
      let result = '';

      guess.forEach((digit, i) => {
        if (digit === secret[i]) {
          result += `<span class="green">🟢</span>`;
        } else if (secret.includes(digit)) {
          result += `<span class="yellow">🟡</span>`;
        } else {
          result += `<span class="red">🔴</span>`;
        }
      });

      const feedback = document.getElementById("feedback");
      const attempt = document.createElement("div");
      attempt.className = "attempt";
      attempt.innerHTML = `👉 ${input} → ${result}`;
      feedback.appendChild(attempt);

      if (guess.every((d, i) => d === secret[i])) {
        const win = document.createElement("h2");
        win.textContent = "🎉 Bravo ! Code trouvé !";
        feedback.appendChild(win);
      }

      document.getElementById("guessInput").value = '';
    }

  function goBack() {
    window.location.href = "codecrackerindex.php";
  }

  </script>
</body>
</html>
