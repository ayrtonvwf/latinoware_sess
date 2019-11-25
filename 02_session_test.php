<?php
    session_start();

    echo '<p>Sessão anterior:</p>';
    var_dump($_SESSION);

    $_SESSION = $_GET;

    echo '<p>Sessão atual:</p>';
    var_dump($_SESSION);