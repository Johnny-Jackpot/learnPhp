<div class="row">
    <div class="col-md-4 col-md-offset-4">

<?php
    $studiosList = $this->getVar('studiosList');
    if (isset($studiosList) && !empty($studiosList) && count($studiosList)):
?>

    <p>Please, select studio you need.</p>
    <form id="actorsOnStudios" class="form-inline" action="/actors_on_studios" method="get">
        <div class="form-group">
            <select id="actorsOnStudiosSelect" class="form-control" name="studio_name">
                <?php foreach($studiosList as $studio):?>
                    <option value="<?php echo $studio['name']; ?>">
                        <?php echo $studio['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input id="getStatistics" class="btn btn-primary" type="submit" value="Submit">
        </div>
    </form>
<?php else: ?>
    <p>Sorry, there is no any studio yet.</p>
<?php endif; ?>
        <br>
        <div id="statisticsContainer">
            <table id="statistics" class="table table-bordered table-hover"></table>
        </div>
    </div>
</div>





