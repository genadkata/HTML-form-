<?php

namespace classes;

class gameLogicMulti
{
    public $playerX;
    public $playerO;
    public $lastRound = null; //Последен рунд
    public $message = ""; //Динамично зареждаме съобщение

                                                             //Дефолтни стойности на дъската при зареждане
                                                               //public $defaultboard = [
                                                           // [3, 3, 3],
                                                            // [3, 3, 3],
                                                            //[3, 3, 3]
                                                            //  ];

    //Иницализация на дъската
    public $board = [
        [3, 3, 3],
        [3, 3, 3],
        [3, 3, 3]
    ];
    // Взимаме всяка една възможност за победа по възможно най-мъчителния начин :Д
    public $winConditions = [

        [[0, 0], [0, 1], [0, 2]],
        [[1, 0], [1, 1], [1, 2]],
        [[2, 0], [2, 1], [2, 2]],
        [[0, 0], [1, 0], [2, 0]],
        [[0, 1], [1, 1], [2, 1]],
        [[0, 2], [1, 2], [2, 2]],
        [[0, 0], [1, 1], [2, 2]],
        [[0, 2], [1, 1], [2, 0]],
    ];
    /*public function _construct()
    {
        $this->playerX = $_SESSION['player-x'];
        $this->playerO = $_SESSION['player-o'];
    }
*/
    //Създава динамична плочка за дъската
    public function boardSquare($value, $id)
    {
        $o = ""; // Всяко едно поле
        $name = "row_" . $id;
        $realValue = null;
        if ($value == 0) {
            $realValue = "O";  // сетваме value за полетата
        } else if ($value == 1) {
            $realValue = "X"; // сетваме value за полетата
        } else {
            $realValue = "select"; //
        }
        if ($value == 0 || $value == 1) {
            $o .= "<input type='hidden' name='" . $name . "' value='" . $realValue . "'/>"; // сетваме стойноста
            $o .= "<select disabled='disabled'>"; // дисейбълваме полето
        } else {
            $o .= "<select name='" . $name . "'>";
        }
        $o .= "<option>Избор</option>"; // правим селекта
        if ($value == 0) {
            $o .= "<option selected='selected'>O</option>"; // избрано O
        } else {
            $o .= "<option>O</option>"; // самата опция за избиране
        }
        if ($value == 1) {
            $o .= "<option selected='selected'>X</option>";
        } else {
            $o .= "<option>X</option>";
        }
        $o .= "</select>";
        return $o;
    }

    //Проверява дали имаме победител
    public function checkWinner($conditions, $response)
    {
        $previousSymbol = null;
        $matches = []; // празен масив за пълнене на съвпадиенията
        for ($i = 0; $i <= count($conditions) - 1; $i++)
        { // циклим толкова пъти колкото са възможните варянти


            //при първия цикъл ще хване първия срещнат символ  примерно Х
            //$lr = X
            //При второ минаване ще следи за комбинация
            foreach ($conditions[$i] as $rows)
            {
                $x = $rows[0]; // взимаме редовете по индекс 0
                $y = $rows[1]; // взимаме колоните по индекс 1
                if ($response[$x][$y] != 3) { // проверява дали в този символ имаме x i o

                    //при първия цикъл ще хване първия срещнат символ  примерно Х
                    //$lr = X
                    if ($previousSymbol == $response[$x][$y] || $previousSymbol == null) { // //Lr държи последния симбол , за проверка дали тази позиция я има във масива със съвпадения

                        $matches[] = $response[$x][$y]; // пълним масива със съвпадения
                        $previousSymbol = $response[$x][$y];
                    } else {
                        $previousSymbol = null;
                        $matches = [];
                    }
                }
            }
            if (count($matches) == 3) { // ако има 3 съвпадения
                if ($matches[0] == $matches[1] && $matches[1] == $matches[2]) {
                    return true; // връща победа
                } else {
                    $matches = [];
                    $previousSymbol = null; // изпразваме съвпаденията  и символа
                }
            } else {
                $matches = [];
                $previousSymbol = null;
            }
        }
        return false;
    }


    public function play()
    {
        // дефоулт стойности - брояч на ходове  , промените по дъската , масив с позиций
        $responses = [];  // промените по дъската
        $rowArray = []; // масив с позиций
        $counter = 0;

        // циклим целия пост метод
        foreach ($_POST as $key => $value) {
             // правим проверка индексаа от цикленето да не отговаря на  тези от масива
            if (!in_array($key, ["board", "play", 'last'])) {
                 // проверки за стойноста на позиция за запис на " X " ," O ", и празно
                if ($value == 'O') {
                    $rowArray[] = 0;
                } else if ($value == 'X') {
                    $rowArray[] = 1;
                } else {
                    $rowArray[] = 3;
                }
                $counter++;
                if ($counter % 3 == 0) {
                    $responses[] = $rowArray;
                    $rowArray = [];
                }
            }
        }

        //Масив със промените по дъската
        $changes = [];
        for ($i = 0; $i <= count($this->board) - 1; $i++) { //циклим докато не стигнат броя на плочките (9)
            foreach ($this->board[$i] as $key => $value) {
                if ($value != $responses[$i][$key]) {
                    $changes[] = $responses[$i][$key]; // записваме
                }
            }
        }


        if (count($changes) > 1) { //ако имаме повече от 1 промяна
            $this->message .= "Двоен ход";
        } else if ($this->lastRound != null && $this->lastRound == $changes[0]) {
            $this->message .= "Не е твой ред"; // Ако се играят 2 еднакви симбола

             // Когато функцията ни върне стойност true , слизаме надолу , разбираме кой е направил последния ход и казва този е победител
        } else if ($this->checkWinner($this->winConditions, $responses))  {
            $this->lastRound = $changes[0];
            $winner = null;
            if ($this->lastRound == 1) {
                $winner = "X";
            } else if ($this->lastRound == 0) {
                $winner = "O";
            }
            $this->board = $responses;
            $this->message .= 'ПОБЕДИТЕЛ!  ';
            $this->message .= "ПОБЕДИТЕЛЯ Е :" . $winner;
        } else {
            $this->lastRound = $changes[0];
            $this->board = $responses;
        }
    }
}