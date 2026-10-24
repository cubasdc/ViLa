<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */

$_POST['orden']=$_POST['ordenweb'];
include 'vista.php';
$vista = new Vista();
$vista->getImprimible($logo = 'V');

?>

