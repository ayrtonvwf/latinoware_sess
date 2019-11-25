<?php $files = scandir('.') ?>
<?php foreach ($files as $file) { ?>
    <a href="<?= $file ?>"><?= $file ?></a><br>
<?php } ?>