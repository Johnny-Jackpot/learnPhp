<?php if(count($actorsFees)): ?>
    <table>
        <caption>Actors fees who are from <?php echo $actorsYearsFrom; ?> to
            <?php echo $actorsYearsTo; ?> years old</caption>
        <tr>
            <th>Full name</th>
            <th>Sum of fees</th>
        </tr>
        <?php foreach($actorsFees as $record): ?>
            <tr>
                <td><?php echo $record['actor_full_name']; ?></td>
                <td><?php echo $record['total_fees']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There is no any actor who fit the requirements.</p>
<?php endif; ?>
