<div class="row">
    <div class="col-md-4 col-md-offset-4">

<?php
    $studiosStatistics = $this->getVar('studiosStatistics');
    if(isset($studiosStatistics)
        && !empty($studiosStatistics)
        && count($studiosStatistics)):
?>
    <table class="table table-bordered table-hover">
        <caption>Studios statistics</caption>
        <tr>
            <th>Studio</th>
            <th>Number of films</th>
            <th>Number of payments</th>
            <th>Sum of fees</th>
            <th>Average fee</th>
        </tr>
        <?php foreach($studiosStatistics as $record): ?>
            <tr>
                <td><?php echo $record['studio']; ?></td>
                <td><?php echo $record['number_of_films']; ?></td>
                <td><?php echo $record['number_of_payments']; ?></td>
                <td><?php echo $record['sum_of_fees']; ?></td>
                <td><?php echo $record['average_fee']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There is no any record for studios statistics</p>
<?php endif; ?>

    </div>
</div>
