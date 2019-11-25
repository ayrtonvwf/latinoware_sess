<?php
    var_dump([
        'save_path' => ini_get('session.save_path'),
        'id' => $_COOKIE['PHPSESSID']
    ]);