<?php
    include 'vendor/autoload.php';

    $handler = new Handlers\V4();
    session_set_save_handler($handler);
    session_start();

    echo '<p>Sessão anterior:</p>';
    var_dump($_SESSION);

    $_SESSION = $_GET;

    echo '<p>Sessão atual:</p>';
    var_dump($_SESSION);