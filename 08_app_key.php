<?php
    include 'vendor/autoload.php';

    $appKey = 'root123';

    $handler = new Handlers\Sess6AppKey($appKey);
    session_set_save_handler($handler);
    session_start();

    echo '<p>Sessão anterior:</p>';
    var_dump($_SESSION);

    $_SESSION = $_GET;

    echo '<p>Sessão atual:</p>';
    var_dump($_SESSION);