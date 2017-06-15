<?php /** @var \Components\View $this */ ?>

<?php

    $studios = $this->getVar('studios', []);
    $links = $this->getVar('links_to_studios', []);

?>

<?php if (count($studios)): ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <table class="table table-bordered table-hover">
                <caption>Actors on studios statistics: </caption>
                <?php for($i = 0, $n = count($studios); $i < $n; $i++): ?>
                    <tr>
                        <td>
                            <a href="<?php echo $links[$i]['name'] ?>">
                                <?php echo $studios[$i]['name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
<?php endif; ?>

