<?php
session_start();

// Charger la liste de mots depuis le fichier
$words = file('liste_francais.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


// Choisir un mot aléatoire au début
if (!isset($_SESSION['word'])) {
    $_SESSION['word'] = $words[array_rand($words)];
    $_SESSION['guessed'] = [];
    $_SESSION['tries'] = 0;
}

// Récupérer la lettre devinée
if (isset($_POST['letter'])) {
    $letter = strtolower($_POST['letter']);
    if (!in_array($letter, $_SESSION['guessed'])) {
        $_SESSION['guessed'][] = $letter;
        if (strpos($_SESSION['word'], $letter) === false) {
            $_SESSION['tries']++;
        }
    }
}

// Vérifier la victoire ou la défaite
$word_complete = str_split($_SESSION['word']);
$display_word = "";
$won = true;

foreach ($word_complete as $char) {
    if (in_array($char, $_SESSION['guessed'])) {
        $display_word .= $char . " ";
    } else {
        $display_word .= "_ ";
        $won = false;
    }
}

$lost = $_SESSION['tries'] >= 6;

// Réinitialiser le jeu si gagné ou perdu
if ($won || $lost) {
    $message = $won ? "Félicitations ! Vous avez gagné !" : "Vous avez perdu ! Le mot était : " . $_SESSION['word'];
    unset($_SESSION['word']);
    unset($_SESSION['guessed']);
    unset($_SESSION['tries']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu du Pendu</title>
    <link rel="stylesheet" href="jeuxpendu.css">
</head>
<body>
    <div class="container">
        <h1>Jeu du Pendu</h1>
        <?php if(isset($message)) : ?>
            <p class="message"><?= $message ?></p>
            <a href="jeuxpendu.php" class="button">Rejouer</a>
        <?php else : ?>
            <p class="word"><?= $display_word ?></p>
            <p>Essais restants : <?= 6 - $_SESSION['tries'] ?></p>
            <form method="post">
                <?php
                foreach (range('a', 'z') as $letter) {
                    $disabled = in_array($letter, $_SESSION['guessed']) ? "disabled" : "";
                    echo "<button type='submit' name='letter' value='$letter' $disabled>$letter</button>";
                }
                ?>
            </form>
            <div class="hangman">
                <img src="images/pendu<?= $_SESSION['tries'] ?>.png" alt="Pendu">
            </div>
        <?php endif; ?>
    </div>
    <!-- Lien de retour en bas de page -->
<div class="footer">
    <a href="../index.php" class="button">Retour à l'accueil</a>
</div>

</body>
</html>
