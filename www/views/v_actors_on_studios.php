<?php
    $studiosList = $this->getVar('studiosList');
    if (isset($studiosList) && !empty($studiosList) && count($studiosList)):
?>

    <p>Please, select studio you need.</p>
    <form id="actorsOnStudios" action="/actors_on_studios" method="get">
        <select name="studio_name">
            <?php foreach($studiosList as $studio):?>
                <option value="<?php echo $studio['name']; ?>">
                    <?php echo $studio['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input id="getStatistics" type="submit" value="Submit">
    </form>
<?php else: ?>
    <p>Sorry, there is no any studio yet.</p>
<?php endif; ?>
<div id="statistics"></div>





