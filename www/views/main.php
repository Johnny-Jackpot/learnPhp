<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
    $this->renderBlock(str_replace('/', DIRECTORY_SEPARATOR,
        ROOT . '/views/main/actorsFees.php'));
?>

<br>

<?php
    $this->renderBlock(str_replace('/', DIRECTORY_SEPARATOR,
        ROOT . '/views/main/nonNameSakeActors.php'));
?>

<br>

<?php
    $this->renderBlock(str_replace('/', DIRECTORY_SEPARATOR,
        ROOT . '/views/main/studiosStatistics.php'));
?>

</body>
</html>