<?php

session_start();
$_SESSION["admin"] = null;
session_destroy();

?>