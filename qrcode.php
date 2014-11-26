<?php

/**
 * QR code generation script.
 */

include "phpqrcode.php";
$short = $_GET['short'];
QRcode::png($short);
?>