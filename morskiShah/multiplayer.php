<?php
session_start();
include 'classes/gameLogicMulti.php';
$gameLogic = new \classes\gameLogicMulti();

//if(isset($_POST['start'])){
  //  $gameLogic->board = $gameLogic->defaultboard;
 //}

if(isset($_POST['play'])) {
    $gameLogic->board = isset($_POST['board']) ? json_decode($_POST['board']) : []; // изполваме json_decode за да върнем стойностите като асоциативен масив
    $gameLogic->lastRound = $_POST['last'] ?? null;
    $gameLogic->play();
}

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Мултиплеър</title>
    <link rel="stylesheet"  type="text/css" href="assets/style.css"/>
</head>

<body class="multiplayer">
<div class="tct-container">
    <form method="post" class="tct-form">
        <?php if($gameLogic->message):?>
            <p class="tct-message"><?php echo $gameLogic->message;?></p>
        <?php endif;?>

        <l class="firstplayer" style="text-align:left"><?php echo $_SESSION['player-x'];?></l>
        <l class="secondplayer" style="text-align:right"><?php echo $_SESSION['player-o'];?></l>

        <table class="tct-table" border = "1px">
            <?php $count=1; foreach($gameLogic->board as $row): ?>

                <tr>
                    <?php foreach($row as $tile):?>
                        <td>
                            <?php echo $gameLogic->boardSquare($tile, $count);?>
                        </td>
                        <?php $count++; endforeach;?>
                </tr>

            <?php endforeach;?>
        </table>
        <br>
        <button type="submit" name="start">Започни нова игра</button>
        <input name="board" type="hidden" value="<?php echo json_encode($gameLogic->board);?>"/>
        <input name="last" type="hidden" value="<?php echo $gameLogic->lastRound;?>"/>
        <button name="play">Край на хода</button>
    </form>
</div>

</body>
