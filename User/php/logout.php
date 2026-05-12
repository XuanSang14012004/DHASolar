<?php

session_start();

session_destroy();

header("Location: ../../User/php/index.php");

exit();
?>