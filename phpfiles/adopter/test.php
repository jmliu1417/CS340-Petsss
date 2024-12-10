<?php
require_once "../config.php";

if (isset($link)) {
    echo "Database connection is initialized.";
} else {
    echo "Database connection is not initialized.";
}
?>