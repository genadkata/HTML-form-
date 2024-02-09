<?php
session_start(); // Start the session
require_once 'classes/gameLogicSingle.php'; // Свързваме с логиката за файла
$game = new \classes\gameLogic(); //

//  Правим си дъската която е с 9 полета
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, null);
}

// Сетваме си хода
if (isset($_POST['move'])) {
    $move = $_POST['move']; //
    // Правим си проветка и сетваме хода
    if ($_SESSION['board'][$move] === null) {
        $_SESSION['board'][$move] = 'X'; // Нашия ход

        $game->checkWinner(); // функция за победител
        $game->makeBotMove(); // функция за хода на бота
        $game->checkWinner();
    }
}

// Ресетваме играта
if (isset($_POST['action']) && $_POST['action'] === 'reset') {
    unset($_SESSION['board']);
    //unset($_SESSION['isGameStarted']);
    unset($_SESSION['winner']); // приключваме всичко заредено
    header('Location: ' . $_SERVER['PHP_SELF']); // зареждаме горния адрес
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Морски шах</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css"/>
</head>
<body>
<center/>
<!-- Проверяваме за победител -->
<?php if (isset($_SESSION['winner'])) { ?>
    <!-- Сетваме 1 от побеетидели -->
    <p class="pobeda" > <?= $_SESSION['winner'] ?> победи!</p>
    <!-- Проверка за равенство -->
<?php } else if (!in_array(null, $_SESSION['board'], true)) { ?>
    <!-- Равенство -->
    <p style="width: 600px; padding: 30px; background: orange; color: white; font-size: 20px; border: 1px solid lightgray;">Няма победител :( !</p>
<?php } ?>

<table class="table">
    <form method="post">

        <?php for ($i = 0; $i < 3; $i++) { ?>

            <tr>

                <?php
                for ($j = 0; $j < 3; $j++) {
                    $index = 3 * $i + $j; // вземаме си индекса
                    // Използваме двата цикъла за да обходим всяка една клетка от борда ни на принципа (0.0 , 0.1 , 0.2 ; 1.0 , 1.1 и т.н.)

                    $value = $_SESSION['board'][$index];
                    // Ако е празен индекс
                    if ($value === null) {
                        ?>
                        <!-- бутонче със име move за следващ ход  със сетнат индекс -->
                        <td><button type="submit" name="move" value="<?= $index ?>" style="width: 50px; height: 50px;"></button></td>

                    <?php } else { ?>
                        <!-- След натискане на бутона да се показва нашия или символа на робота  -->
                        <td ><?= $value && $value == 'X' ? "❌" : "⭕" ?></td>

                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>

        <!-- Рестартираме играта -->
        <button class="newgame" type="submit" name="action" value="reset">Нова игра</button>
    </form>
</table>
<div class ="playersimbols">
    <!-- Викаме си името на играча-->
    <p><h3><?php echo $_SESSION['player-x'];?> символ ❌</h3></p>
    <p><h3>Бот символ ⭕</h3></p>
</div>

</body>
</html>
