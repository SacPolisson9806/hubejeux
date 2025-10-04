<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Course d'Évitement</title>
  <link rel="stylesheet" href="accueil.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
  <div class="screen">
    <h1>🚗 Course d'Évitement</h1>
    <p class="subtitle">Évite les voitures rouges et reste en vie !</p>

    <div class="button-group">
      <button id="rulesBtn">📜 Règles</button>
      <button id="playBtn" class="btn">🎮 Jouer</button>
      <a href="../index.php" class="btn">↩ Retour</a>
      <p id="carError" class="hidden" style="color: red; text-align: center; font-family: 'Press Start 2P';">🚫 Choisis une voiture avant de jouer !</p>
    </div>

    <div id="carToggle" class="btn">🚗 Choisir ta voiture</div>

    <div id="carGallery" class="hidden">
      <div class="car-options">
        <img src="voitureimage/voiturerouge.png" alt="Rouge" data-car="voitureimage/voiturerouge.png" class="car-pick" style="width:60px; height:120px; image-rendering:pixelated;">
        <img src="voitureimage/voiturerose.png" alt="Rose" data-car="voitureimage/voiturerose.png" class="car-pick" style="width:60px; height:120px; image-rendering:pixelated;">
        <img src="voitureimage/voiturebleu.png" alt="Bleu" data-car="voitureimage/voiturebleu.png" class="car-pick" style="width:60px; height:120px; image-rendering:pixelated;">
      </div>
    </div>


    <div id="rulesBox" class="hidden">
      <h2>Règles du jeu</h2>
      <ul>
        <li>Utilise les flèches gauche/droite pour déplacer ta voiture.</li>
        <li>Évite les voitures rouges qui arrivent en face.</li>
        <li>Si tu touches une voiture ennemie, c’est perdu !</li>
      </ul>
    </div>
  </div>

  <script>
    // Affichage des règles
    document.getElementById("rulesBtn").addEventListener("click", () => {
      document.getElementById("rulesBox").classList.toggle("hidden");
    });

    // Affichage du sélecteur de voiture
    document.getElementById("carToggle").addEventListener("click", () => {
      document.getElementById("carGallery").classList.toggle("hidden");
    });

    let selectedCar = null;

    // Sélection de voiture par image
    document.querySelectorAll(".car-pick").forEach(img => {
      img.addEventListener("click", () => {
        document.querySelectorAll(".car-pick").forEach(i => i.classList.remove("selected"));
        img.classList.add("selected");
        selectedCar = img.dataset.car;
        document.getElementById("carError")?.classList.add("hidden");
      });
    });

    // Lancer le jeu uniquement si une voiture est choisie
    document.getElementById("playBtn").addEventListener("click", () => {
      if (!selectedCar) {
        document.getElementById("carError").classList.remove("hidden");
        return;
      }
      window.location.href = `Voiture.php?car=${encodeURIComponent(selectedCar)}`;
    });
  </script>
</body>
</html>
