<?php
session_start();

setcookie('visit_count', '', time() - 3600, '/');
session_destroy();

header("Location: index.php");
exit();
