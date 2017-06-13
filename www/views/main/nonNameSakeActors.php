<?php if(count($nonNameSakeActors)): ?>
    <table>
        <caption>Actors who hasn't namesakes</caption>
        <tr>
            <th>#</th>
            <th>full name</th>
        </tr>
        <?php for($i = 0; $i < count($nonNameSakeActors); $i++): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $nonNameSakeActors[$i]['actor_full_name']; ?></td>
            </tr>
        <?php endfor; ?>
    </table>
<?php else: ?>
    <p>There is no any actor who fit the requirements.</p>
<?php endif; ?>