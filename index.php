<?DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $name = 'Jim';
        $what = 'geek';
        $level = 10;
        echo 'Hi, my name is '.$name.', and I am a level '.$level.' '.$what;
        echo '<br/>';
        $hoursworked = $_GET['hours'];
        $rate = 12;
        if ($hoursworked > 40) {
            $total = $hoursworked * $rate * 1.5;
        } else {
            $total = $hoursworked * $rate;
        }
        echo ($total > 0) ? 'You owe me '.$total : "You're welcome";
        ?>
    </body>
</html>