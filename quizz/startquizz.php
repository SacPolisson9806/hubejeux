<?php
session_start();

// Fonction pour normaliser les réponses
function normalize($text){
    $text = trim($text); // supprimer espaces avant/après
    $text = strtolower($text); // minuscules
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text); // enlever accents
    $text = preg_replace('/[[:punct:]]/', '', $text); // enlever ponctuation
    $text = preg_replace('/\s+/', ' ', $text); // espaces multiples
    return $text;
}

// Premier envoi depuis quiz.php
if(isset($_POST['theme'], $_POST['points_to_win'], $_POST['timer'])){
    $_SESSION['selectedThemes'] = $_POST['theme'];
    $_SESSION['pointsToWin'] = (int)$_POST['points_to_win'];
    $_SESSION['timePerQuestion'] = (int)$_POST['timer'];

    $questions = [];
    if(in_array("Minecraft", $_SESSION['selectedThemes'])){
        include 'Minecraft.php';
        $questions = array_merge($questions, $questionsMinecraft);
    }
    // Ajouter d'autres thèmes si nécessaire

    $questions = array_values($questions);
    shuffle($questions);

    $_SESSION['questions'] = $questions;
    $_SESSION['score'] = 0;
    $_SESSION['questionIndex'] = 0;
    $_SESSION['showAnswer'] = false;
}

// Vérifier que la session contient des questions
if(!isset($_SESSION['questions'])){
    header('Location: quizz.php');
    exit;
}

$questions = $_SESSION['questions'];
$pointsToWin = $_SESSION['pointsToWin'];
$timePerQuestion = $_SESSION['timePerQuestion'];
$currentIndex = $_SESSION['questionIndex'];

// Vérifier victoire ou fin
if($_SESSION['score'] >= $pointsToWin){
    $message = "Félicitations ! Vous avez gagné avec " . $_SESSION['score'] . " points !";
    session_destroy();
    echo "<h1>$message</h1><a href='quizz.php'>Rejouer</a>";
    exit;
}
if($currentIndex >= count($questions)){
    $message = "Fin du quiz ! Vous avez " . $_SESSION['score'] . " points.";
    session_destroy();
    echo "<h1>$message</h1><a href='quizz.php'>Rejouer</a>";
    exit;
}

// Gestion des réponses
if(isset($_POST['answer']) || isset($_POST['timeout'])){
    $_SESSION['lastAnswer'] = $_POST['answer'] ?? null;
    $_SESSION['showAnswer'] = true;

    $playerAnswer = normalize($_SESSION['lastAnswer'] ?? '');
    $correctAnswers = (array)$questions[$currentIndex]['answer'];
    $isCorrect = false;

    foreach($correctAnswers as $ans){
        if($playerAnswer === normalize($ans)){
            $isCorrect = true;
            break;
        }
    }

    if($isCorrect){
        $timeLeft = isset($_POST['timeLeft']) ? (int)$_POST['timeLeft'] : $timePerQuestion;
        $pointsGained = max(1, round(10 * ($timeLeft / $timePerQuestion)));
        $_SESSION['score'] += $pointsGained;
    }
}

// Passer à la question suivante
if(isset($_POST['next'])){
    $_SESSION['questionIndex']++;
    $_SESSION['showAnswer'] = false;
    $_SESSION['lastAnswer'] = null;
    $currentIndex = $_SESSION['questionIndex'];
}

// Question actuelle
$currentQuestion = $questions[$currentIndex];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz en cours</title>
    <link rel="stylesheet" href="startquizz.css">
</head>
<body>
<div class="container">
    <h1>Quiz en cours</h1>
    <p>Score : <?= $_SESSION['score'] ?> / <?= $pointsToWin ?></p>

<?php if($_SESSION['showAnswer']): ?>
    <h2>Réponse :</h2>
    <p>La bonne réponse était : 
        <strong>
            <?= is_array($currentQuestion['answer']) ? implode(" / ", $currentQuestion['answer']) : $currentQuestion['answer']; ?>
        </strong>
    </p>

    <script>
    // Affiche la réponse 5s puis passe à la suivante
    setTimeout(() => {
        const form = document.createElement('form');
        form.method = 'post';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'next';
        input.value = '1';
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }, 5000);
    </script>

<?php else: ?>
    <p>Temps restant : <span id="timer"><?= $timePerQuestion ?></span> secondes</p>

    <form method="post" id="quizForm">
        <p><strong><?= $currentQuestion['question'] ?></strong></p>

        <?php if(!empty($currentQuestion['image'])): ?>
            <img src="<?= $currentQuestion['image'] ?>" alt="Question Image" style="max-width:200px;margin-bottom:10px;">
        <?php endif; ?>

        <?php if(!empty($currentQuestion['options'])): ?>
            <?php foreach($currentQuestion['options'] as $option): ?>
                <div>
                    <input type="radio" name="answer" value="<?= $option ?>" required> <?= $option ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <input type="text" name="answer" placeholder="Votre réponse..." required>
        <?php endif; ?>

        <br>
        <button type="submit">Valider</button>
    </form>

    <script>
    let timeLeft = <?= $timePerQuestion ?>;
    const timerDisplay = document.getElementById('timer');
    const form = document.getElementById('quizForm');

    const countdown = setInterval(() => {
        if(timeLeft <= 0){
            clearInterval(countdown);

            const inputTimeout = document.createElement('input');
            inputTimeout.type = 'hidden';
            inputTimeout.name = 'timeout';
            inputTimeout.value = 1;
            form.appendChild(inputTimeout);

            const inputTimeLeft = document.createElement('input');
            inputTimeLeft.type = 'hidden';
            inputTimeLeft.name = 'timeLeft';
            inputTimeLeft.value = 0;
            form.appendChild(inputTimeLeft);

            form.submit();
        } else {
            timerDisplay.textContent = timeLeft;
        }
        timeLeft--;
    }, 1000);

    form.addEventListener('submit', () => {
        const inputTimeLeft = document.createElement('input');
        inputTimeLeft.type = 'hidden';
        inputTimeLeft.name = 'timeLeft';
        inputTimeLeft.value = timeLeft;
        form.appendChild(inputTimeLeft);
    });
    </script>
<?php endif; ?>
</div>
</body>
</html>
