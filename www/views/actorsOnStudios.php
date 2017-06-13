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

<?php if (count($studiosList)): ?>
    <p>Please, select studio you need.</p>
    <form action="/actorsOnStudios" method="post">
        <select name="studioName">
            <?php foreach($studiosList as $studio):?>
                <option
                        value="<?php echo $studio['name']; ?>"
                    <?php if ($activeStudio && $activeStudio == $studio['name']): ?>
                        selected
                    <?php endif; ?>
                >
                    <?php echo $studio['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Submit">
    </form>
<?php else: ?>
    <p>Sorry, there is no any studio yet.</p>
<?php endif; ?>

<br>

<?php if (count($actorsOnStudiosInfo)): ?>
    <table>
        <caption>Actors who worked for particular studio</caption>
        <tr>
            <th>Studio</th>
            <th>Full name</th>
            <th>Number of films</th>
        </tr>
        <?php foreach ($actorsOnStudiosInfo as $record): ?>
            <tr>
                <td><?php echo $record['studio']; ?></td>
                <td><?php echo $record['actor_full_name']; ?></td>
                <td><?php echo $record['number_of_films']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif (count($studiosList)): ?>
    <p>There is no any actor who worked for this studio.</p>
<?php endif; ?>

</body>
</html>

