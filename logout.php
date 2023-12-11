<?php
session_start();

setcookie('remember_user', '', time() - 3600, '/');
setcookie('visit_count', '', time() - 3600, '/');

session_destroy();

header("Location: index.php");
exit();
