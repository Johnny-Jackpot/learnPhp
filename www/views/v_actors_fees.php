<?php /** @var \Components\View $this */ ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">

<?php
    $actorsFees = $this->getVar('actorsFees');
    if(count($actorsFees)):
?>
    <table class="table table-bordered table-hover">
        <caption>Actors fees who are from <?php echo $this->getVar('actorsYearsFrom'); ?> to
            <?php echo $this->getVar('actorsYearsTo'); ?> years old</caption>
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

    </div>
</div>
