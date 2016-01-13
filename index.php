<?DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (!isset($_GET['board'])) {
            echo 'Please pass in board parameter!';
        } else {
            $position = $_GET['board'];
            $squares = str_split($position);
        
            if (winner('x',$squares)) {
                echo 'You win.';
            } else if(winner('o',$squares)) {
                echo 'I win.';
            } else {
                echo 'No winner yet';
            }
        }
        
        function winner($token,$position) {
            for($row=0; $row<3; $row++) {
                $result = true;
                for ($col=0; $col<3; $col++) {
                    if($position[3*$row+$col] != token) {
                        $result = false;
                    }
                }
            }
            return $result;
        }
        ?>
    </body>
</html>