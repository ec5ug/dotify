<?php
require("import.php");
?>
<?php
session_destroy();
header("Location: index.php");
exit();