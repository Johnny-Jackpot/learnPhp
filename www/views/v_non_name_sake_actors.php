<div class="row">
    <div class="col-md-4 col-md-offset-4">

<?php
    $nonNameSakeActors = $this->getVar('nonNameSakeActors');
    if(isset($nonNameSakeActors)
        && !empty($nonNameSakeActors)
        && count($nonNameSakeActors)):
?>
    <table class="table table-bordered table-hover">
        <caption>Actors who hasn't namesakes</caption>
        <tr>
            <th>#</th>
            <th>Full name</th>
        </tr>
        <?php for ($i = 0; $i < count($nonNameSakeActors); $i++): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $nonNameSakeActors[$i]['actor_full_name']; ?></td>
            </tr>
        <?php endfor; ?>
    </table>
<?php else: ?>
    <p>There is no any actor who fit the requirements.</p>
<?php endif; ?>

    </div>
</div>
