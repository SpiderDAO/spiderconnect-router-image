<?php
require_once('../init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = file_get_contents(ROUTER_PASSWORD_PATH);
    if ($current_password === $_POST['password']) {
        $_SESSION['router_logged_in'] = 1;
        redirect('/index.php');
    } else {
        unset($_SESSION['router_logged_in']);
        redirect('/login.php');
    }
}
redirect('/login.php');