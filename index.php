<?DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (!isset($_GET['board'])) {
            $board = '---------';
        } else {
            $board = $_GET['board'];
        }
        
        $squares = str_split($board);
        $game = new Game($squares);
            
        if ($game->winner('o')) {
            $game->display();
            echo 'You win. Lucky guesses!';                   
        } else {
            $game->pick_move();
            if ($game->winner('x')) {
                $game->display();
                echo 'I win. Muahahahaha';
            } else {
                $game->display();
                echo 'No winners yet!';
            }
        }
        
        class Game {
            var $position;
            
            function __construct($squares) {
                $this->position = $squares;
            }
            
            function winner($token) {
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
            
            function display($game) {
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
            
            function show_cell($which) {
                $token = $this->position[$which];
                if ($token <> '-') {
                    return '<td>'.$token.'</td>';
                }
                $this->newposition = $this->position;
                $this->newposition[$which] = 'o';
                $move = implode($this->newposition);
                $link = '/?board='.$move;
                return '<td><a href="http://localhost:4711/COMP4711Lab1'.$link.'">-</a></td>';
            }
            
            function pick_move() {
                
                //try to find 2 in a row
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
                
                //no 2 in a row
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