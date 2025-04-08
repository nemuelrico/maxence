<?php
session_start();
session_destroy();
header("Location: ../../bootstrap_homepage/index.php");
exit();
?>
