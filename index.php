<?DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //include 'Game.php';
        
        if (!isset($_GET['board'])) {
            echo 'Please pass in board parameter!';
        } else {
            $board = $_GET['board'];
            $squares = str_split($board);
        
            $game = new Game($squares);
            if ($game->winner('x')) {
                echo 'You win. Lucky guesses!';
            } else if($game->winner('o')) {
                echo 'I win. Muahahahaha';
            } else {
                echo 'No winner yet, but you are losing.';
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
        }
        ?>
    </body>
</html>