<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Hello
    <?php
    $name = 'Ivan';
    $arr = ['apple', 'banana'];
    echo $name;
    echo date("H")."\n";
    print_r($arr);

    if(date("H")>= 12 && date("H") < 18) echo 'Добрый день';
    elseif(date("H")>= 18 && date("H") <= 21) echo 'Добрый вечер';
    elseif(date("H")>= 22 && date("H") < 6) echo 'Доброй ночи';
    else{ echo 'Доброе утро';}
    ?>
</body>
</html>
