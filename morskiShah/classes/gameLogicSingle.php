<?php

namespace classes;
class gameLogic
{
    function makeBotMove() {
        $emptyCells = array_filter($_SESSION['board'], function($cell)  // Взимаме си празните клетки
        {
            return $cell === null;
        });
        if (!empty($emptyCells)) { // Проверяваме дали са празни
            $randomCell = array_rand($emptyCells); // Избира рандом клетка
            $_SESSION['board'][$randomCell] = "O"; // Сетваме хода на бота
        }
    }

    function checkWinner() {
         // Проверяваме всички възмоцни комбинаций за победа
        $winningCombinations = array(
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // По редове
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // По колони
            [0, 4, 8], [2, 4, 6] // По диагонали
        );
        foreach ($winningCombinations as $combination) {
            $cell1 = $_SESSION['board'][$combination[0]];
            $cell2 = $_SESSION['board'][$combination[1]];
            $cell3 = $_SESSION['board'][$combination[2]]; // взимаме комбинаьийте за победа
            //проверяваме ги
            if ($cell1 !== null && $cell1 === $cell2 && $cell1 === $cell3) {
                //Сетваме победител
                $_SESSION['winner'] = $cell1 == 'X' ? 'Ти' : 'Бот';
                break;
            }
        }
    }
}