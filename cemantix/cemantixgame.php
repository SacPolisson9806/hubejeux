<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Cemantix — Jeu</title>
  <link rel="stylesheet" href="cemantix.css">
</head>
<body>
  <h1>🎮 Cemantix</h1>
  <p>Devine le mot mystère !</p>

  <input type="text" id="wordInput" placeholder="Propose un mot">
  <button onclick="checkWord()">Essayer</button>
  <br><br>
  <button onclick="goBack()">Retour à l’accueil</button>

  <div id="history"></div>

  <script>
    let motMystere = "";

    // Charger la bibliothèque et choisir un mot mystère aléatoire
    fetch("bibliotheque.json")
      .then(res => res.json())
      .then(data => {
        const mots = Object.keys(data);
        motMystere = mots[Math.floor(Math.random() * mots.length)];
        console.log("Mot mystère :", motMystere);
      });

    function checkWord() {
      const motPropose = document.getElementById("wordInput").value.toLowerCase();
      if (!motPropose || !motMystere) return;

      fetch("https://hubejeux.onrender.com/similarity", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ word1: motPropose, word2: motMystere })
      })
      .then(res => res.json())
      .then(data => afficherScore(motPropose, data.score))
      .catch(err => {
        console.error("Erreur backend :", err);
        afficherScore(motPropose, 0);
      });
    }

    function afficherScore(mot, score) {
      const history = document.getElementById("history");
      const entry = document.createElement("div");

      let couleur = "🔵";
      if (score >= 0.8) couleur = "🔴";
      else if (score >= 0.5) couleur = "🟡";

      entry.textContent = `👉 ${mot} → Score : ${score.toFixed(3)} ${couleur}`;
      history.appendChild(entry);

      if (mot === motMystere) {
        const win = document.createElement("h2");
        win.textContent = "🎉 Bravo ! Mot trouvé !";
        history.appendChild(win);
      }

      document.getElementById("wordInput").value = '';
    }

    function goBack() {
      window.location.href = "cemantix.php";
    }
  </script>
</body>
</html>
