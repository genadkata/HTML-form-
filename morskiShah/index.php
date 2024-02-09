<?php

session_start(); // Започваме сесията

// Проверяваме дали има постнато име

$_SESSION['player-x'] = isset($_POST['player-x']) ? $_POST['player-x']:null;
$_SESSION['player-o'] = isset($_POST['player-o']) ? $_POST['player-o']:null;

// Изпращаме данните към файла за мултиплеър игра
if (isset($_POST['multygame'])){
    session_commit();
    header('Location: multiplayer.php');
    exit;

}
// Изпращаме данните към файла за сингъл игра
if (isset($_POST['singlegame'])){
    session_commit();
    header('Location: singleplayerindex.php');
    exit;
}
?>
<head>
    <meta charset="UTF-8">
    <title>Морски шах</title>
    <link rel="stylesheet"  type="text/css" href="assets/style.css"/>
</head>

<body>

<form method="post" action="">
    <div class="welcome">
        <h1>Start playing Tic Tac Toe!</h1>
        <h2>Please fill in your names</h2>

        <div class="player-name">
            <label for="player-x">First player (X)</label>
            <input type="text" id="player-x" name="player-x"/>
        </div>

        <div class="player-name">
            <label for="player-o">Second player (O)</label>
            <input type="text" id="player-o" name="player-o"/>
        </div>
        <button class="startbuttons" type="submit" name="singlegame">Single player</button>
        <button class="startbuttons" type="submit" name="multygame">Multy player</button>
    </div>
</form>
</body>




