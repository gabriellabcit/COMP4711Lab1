<?DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (!isset($_GET['board'])) {
            //initialize empty board if it does not exist
            $board = '---------';
        } else {
            //load board
            $board = $_GET['board'];
        }
        
        $squares = str_split($board);
        $game = new Game($squares);
        
        $game->play();
        
        class Game {
            var $position;
            
            function __construct($squares) {
                $this->position = $squares;
            }
            
            function play() {
                if ($this->winner('o')) {
                    $this->display();
                    echo 'You win. Lucky guesses!';                   
                } else {
                    $this->pick_move(); //computer's turn
                    //check if computer just won
                    if ($this->winner('x')) {
                        $this->display();
                        echo 'I win. Muahahahaha';
                    } else {
                        $this->display();
                        echo 'No winners yet!';
                    }
                }
            }
            
            /*
             * checks for winner of game
             * @param $token 'x' or 'o'
             * @return true if $token has won, false otherwise
             */
            function winner($token) {
                //check if any rows are filled with token
                for($row=0; $row<3; $row++) {
                    $result = true;
                    for ($col=0; $col<3; $col++) {
                        if($this->position[3*$row+$col] != $token) {
                            $result = false;
                        }
                    }
                    if ($result == true) {
                        return $result;
                    }
                }
                //check if any columns are filled with token
                for($col=0; $col<3; $col++) {
                    $result = true;
                    for ($row=0; $row<3; $row++) {
                        if($this->position[3*$row+$col] != $token) {
                            $result = false;
                        }
                    }
                    if ($result == true) {
                        return $result;
                    }
                }
                //check for diagonals
                $result = false;
                if (($this->position[0] == $token) &&
                        ($this->position[4] == $token) &&
-                       ($this->position[8] == $token)) {
                    $result = true;
                }
                if (($this->position[2] == $token) &&
-                       ($this->position[4] == $token) &&
-                       ($this->position[6] == $token)) {
-                   $result = true;
                }
                return $result;
            }
            
            /*
             * Generates a table to represent the board
             */
            function display() {
                echo '<table cols="3" style="font-size:large; font-weight:bold">';
                echo '<tr>';
                for ($pos=0; $pos<9; $pos++) {              
                    echo $this->show_cell($pos);
                    if($pos %3 == 2) {
                        echo '</tr><tr>';
                    }
                }
                echo '</tr>';
                echo '</table>';
            }
            
            /*
             * Shows each cell of board
             * @param $which cell to show
             * @return table cell containing token,
             * or link to allow user to select that cell
             */
            function show_cell($which) {
                $token = $this->position[$which];
                if ($token <> '-') {
                    return '<td>'.$token.'</td>';
                }
                $this->newposition = $this->position;
                $this->newposition[$which] = 'o';
                $move = implode($this->newposition);
                $url = "http://$_SERVER[SERVER_NAME]".":"."$_SERVER[SERVER_PORT]";
                $link = '/COMP4711Lab1/?board='.$move;
                return '<td><a href="'.$url.$link.'">-</a></td>';
            }
            
            /*
             * Picks next spot for computer.
             * Checks if there are any 2 in a row/column/diagonal, if so then
             * pick the last one to win the game
             * Otherwise, randomly pick a spot and takes it if it is empty
             */
            function pick_move() {
                
                //try to find 2 in the same row/column/diagonal
                for($row=0; $row<3; $row++) {
                    $count = 0;
                    for ($col=0; $col<3; $col++) {
                        if($this->position[3*$row+$col] == 'x') {
                            $count++;
                        }
                    }
                    if ($count == 2) {
                        for ($col=0; $col<3; $col++) {
                            if($this->position[3*$row+$col] == '-') {
                                $this->position[3*$row+$col] = 'x';
                                return;
                            }                           
                        }
                    }
                }
                for($col=0; $col<3; $col++) {
                    $count = 0;
                    for ($row=0; $row<3; $row++) {
                        if($this->position[3*$row+$col] == 'x') {
                            $count++;
                        }
                    }
                    if ($count == 2) {
                        for ($row=0; $row<3; $row++) {
                            if($this->position[3*$row+$col] == '-') {
                                $this->position[3*$row+$col] = 'x';
                                return;
                            }                           
                        }
                    }
                }
                if ($this->position[4] == 'x') {
                    if($this->position[0] == 'x') {
                        $this->position[8] = 'x';
                        return;
                    }
                    if($this->position[8] == 'x') {
                        $this->position[0] = 'x';
                        return;
                    }
                    if($this->position[2] == 'x') {
                        $this->position[6] = 'x';
                        return;
                    }
                    if($this->position[6] == 'x') {
                        $this->position[2] = 'x';
                        return;
                    }
                }
                
                //no 2 in a row - just randomly pick an empty spot
                while (true){
                    $newpos = rand(0, 8);
                    if($this->position[$newpos] == '-') {
                        $this->position[$newpos] = 'x';
                        return;
                    }
                }
            }
        }
        ?>
    </body>
</html>