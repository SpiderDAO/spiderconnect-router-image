<?php
require_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    file_put_contents(ROUTER_PASSWORD_PATH, $password);
    redirect('/api/logout.php');
}
redirect('/');
