<?php

require_once 'lib/UserAccount.php';

session_start();
if (!isset($_SESSION['account'])) {
    header("Location: /login");
    exit;
}

$userAccount = $_SESSION['account'];

require_once "templates/header.php";
?>

<h2>Welcome <?= htmlentities($userAccount->firstName)?></h2>

<p><a href="/chat/">Start Chatting.</a></p>


<?php
require_once "templates/footer.php";

 