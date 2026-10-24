<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */
include ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
if (is_user_logged_in())
{
//online
//$dbHost = 'localhost';
//$dbUsername = 'root';

// este antes 2021
// $dbPassword = 'NEW_PASSWORD';
// $dbName = 'bitnami_wordpress';

//local
//$dbHost = 'localhost';
//$dbUsername = 'root';

/*
$dbPassword = '';
$dbName = 'vivlab';
*/


// include_once ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

 // $_GET['term']='cubas';



// $db = new mysqli('localhost', 'root', $dbPassword, $dbName);
$_GET['term']= mb_convert_case(preg_replace('/\s+/', ' ', trim($_GET['term'])), MB_CASE_TITLE, "UTF-8");

$term='';
//$ary = explode(' ', utf8_encode(trim($_GET['term']))); //local
// $ary = explode(' ', trim($_GET['term']));
$ary = explode(' ', preg_replace('/\s+/', ' ', trim($_GET['term'])));
if(is_array($ary) ) {
    foreach($ary as $key) {
        $term = $term.  ' and doctor.nombre like "%'.trim($key).'%" ';
    }
}else $term=' and doctor.nombre like "%'.trim($_GET['term']).'%" ';
//$query = $db->query('SELECT `nombre` FROM `doctor`  WHERE `nombre` LIKE "%'.trim($_GET['term']).'%" order by `nombre` limit 10');
//$query = $db->query('SELECT `nombre` FROM `doctor`  WHERE 1 '.$term.' order by `nombre` limit 7');


// $strings = $wpdb->get_results("SELECT DISTINCT doctor.nombre FROM `doctor`
// INNER JOIN `orden` ON doctor.cmp=orden.doctor_cmp 
// WHERE 1 
// ".$term." 
// and EXISTS(SELECT orden.doctor_cmp FROM orden WHERE orden.doctor_cmp=doctor.cmp LIMIT 1) 
// order by doctor.nombre LIMIT 5");

// DISTINCT
$strings = $wpdb->get_results('SELECT SQL_CACHE  doctor.nombre FROM `doctor` 
WHERE 1 
'.$term.'
and EXISTS(SELECT orden.doctor_cmp FROM orden WHERE orden.doctor_cmp=doctor.cmp LIMIT 1) 
order by doctor.cmp DESC LIMIT 1');



// sort($strings);

foreach ( $strings as $string ) 
{
    // $data[]= utf8_encode(utf8_decode($string->nombre));
      $data[]= mb_convert_case(preg_replace('/\s+/', ' ', trim($string->nombre)), MB_CASE_TITLE, "UTF-8");
}

// while ($row = $query->fetch_assoc()) {
//     $data[] = utf8_encode(utf8_decode($row['nombre'])); //online
//     //$data[] = utf8_encode($row['nombre']); //local
// }
echo json_encode($data);
}