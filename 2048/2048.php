<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>2048 Iceberg Edition — Accueil</title>
  <link rel="stylesheet" href="2048.css">
</head>
<body>
  <header>
    <h1>🧊 2048 Iceberg Edition</h1>
    <p>Bienvenue sur la banquise !</p>
  </header>

  <main>
    <form action="jeux2048.php" method="get">
      <label for="gridSize">Choisis la taille de la grille :</label>
      <select name="gridSize" id="gridSize" required>
        <option value="" disabled selected>-- Choisir --</option>
        <?php for ($i = 3; $i <= 6; $i++) {
          echo "<option value='$i'>{$i}×{$i}</option>";
        } ?>
      </select>
      <br><br>
      <button type="submit">❄️ Lancer la partie</button>
    </form>

    <section id="rules">
      <h2>📜 Règles du jeu</h2>
      <ul>
        <li>Utilise les flèches du clavier pour déplacer les blocs.</li>
        <li>Fusionne les blocs de même valeur pour atteindre 2048.</li>
        <li>Chaque mouvement ajoute un nouveau glaçon sur la banquise.</li>
        <li>Le jeu se termine quand il n’y a plus de mouvements possibles.</li>
      </ul>
    </section>
  </main>
  <button onclick="window.location.href='../index.php'" class="retour">🏠 Retour à l’accueil</button>
</body>
</html>
