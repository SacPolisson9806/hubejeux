<?php
session_start();

// Liste des thèmes disponibles
$themes = ["Minecraft"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Configurer votre Quiz</title>
    <link rel="stylesheet" href="quizz.css">
</head>
<body>
<div class="container">
    <h1>Configurer votre Quiz</h1>
    <form action="startquizz.php" method="post" id="quizForm">
        <!-- Choix des thèmes -->
        <label>Choisir le(s) thème(s) :</label>
        <div class="theme-container">
            <?php foreach($themes as $theme): ?>
                <button type="button" class="theme-btn" data-value="<?= $theme ?>"><?= $theme ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Affichage des thèmes sélectionnés -->
        <p id="selectedDisplay">Thèmes choisis : aucun</p>

        <!-- Inputs cachés pour envoyer les thèmes au formulaire -->
        <div id="hiddenThemesContainer"></div>

        <!-- Choix du nombre de points à atteindre -->
        <label for="points_to_win">Nombre de points à atteindre :</label>
        <select name="points_to_win" id="points_to_win" required>
            <?php
            for ($points = 100; $points <= 1000; $points += 50) {
                echo "<option value=\"$points\">$points</option>";
            }
            ?>
        </select>

        <!-- Choix du timer par question -->
        <label for="timer">Temps par question (secondes) :</label>
        <select name="timer" id="timer" required>
            <?php
            for ($t = 5; $t <= 60; $t += 5) {
                echo "<option value=\"$t\">$t secondes</option>";
            }
            ?>
        </select>

        <!-- Boutons Retour et Lancer -->
        <div class="button-row">
            <a href="../index.php" class="action-btn">← Retour</a>
            <button type="submit" class="action-btn">Lancer le Quiz</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.theme-btn');
    const display = document.getElementById('selectedDisplay');
    const hiddenContainer = document.getElementById('hiddenThemesContainer');

    function updateHiddenInputs(selected) {
        hiddenContainer.innerHTML = '';
        selected.forEach(theme => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'theme[]';
            input.value = theme;
            hiddenContainer.appendChild(input);
        });
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('selected');

            const selectedThemes = [];
            document.querySelectorAll('.theme-btn.selected').forEach(b => {
                selectedThemes.push(b.dataset.value);
            });

            display.textContent = selectedThemes.length > 0
                ? "Thèmes choisis : " + selectedThemes.join(', ')
                : "Thèmes choisis : aucun";

            updateHiddenInputs(selectedThemes);
        });
    });
});
</script>
</body>
</html>
