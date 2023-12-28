<?php


include "../classes/db.php";
include "../classes/user.php";

$myGuestsFetcher = new MyGuestsFetcher($con);
$Data = $myGuestsFetcher->fetchMyGuestsData();
