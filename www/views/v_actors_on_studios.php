<?php /** @var \Components\View $this */ ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">

<?php
    $studiosList = $this->getVar('studiosList', []);
    if (count($studiosList)):
?>

    <form id="actors-on-studios" class="form-inline" action="/actors_on_studios" method="get">
        <div class="form-group">
            <label for="actors-on-studios-select">Please, select studio you need</label>
            <select id="actors-on-studios-select" class="form-control" name="studio_name">
                <?php foreach($studiosList as $studio):?>
                    <option value="<?php echo $studio['name']; ?>">
                        <?php echo $studio['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input id="get-statistics" class="btn btn-primary" type="submit" value="Submit">
        </div>
    </form>
<?php else: ?>
    <p>Sorry, there is no any studio yet.</p>
<?php endif; ?>
        <br>
        <div id="statistics-container">
            <table id="statistics" class="table table-bordered table-hover"></table>
        </div>
    </div>
</div>





