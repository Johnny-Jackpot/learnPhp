<?php /** @var \Components\View $this */ ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="/assets/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" >
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/">Main</a></li>
                <li><a href="/actors_fees">Actors fees</a></li>
                <li><a href="/non_namesakes_actors">Non namesake actors</a></li>
                <li><a href="/studios_statistics">Studios statistics</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">
    <?php $this->renderView(); ?>
</div><!-- /.container-fluid -->

<footer class="footer">
    <div class="container-fluid">
        <p class="footer-info">
            This is web interface for MySQL queries from learning program.
            &copy Oleksandr Nazarenko 2017</p>
    </div>
</footer>

<script src="/assets/js/jquery-3.2.1.js"></script>
<script src="/assets/js/actors-on-studios.js"></script>
</body>
</html>