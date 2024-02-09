<?php

session_start();


//Изпращаме данните към файла за сингъл игра
if (isset($_POST['player-x'])) {
    session_commit();
    header('Location:singleplayer.php');
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
        <h1>Морски шах</h1>

        <div class="player-name">
            <h1 >Товето име е:</h1>
            <input  id="player-x" name="player-x" type="hidden" />
            <h2 style="text-align:center ; font-size:60px"><?php echo $_SESSION['player-x'];?></h2>
        </div>
        <button class="startbuttons" type="submit" name="play">Продължи</button>
    </div>

</form>
</body>