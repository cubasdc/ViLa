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

// include ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
// include_once ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

// $_GET['term']='cubas';

// $db = new mysqli('localhost', 'root', $dbPassword, $dbName);
$term='';
//$ary = explode(' ', utf8_encode(trim($_GET['term']))); //local
$_GET['term']= mb_convert_case(preg_replace('/\s+/', ' ', trim($_GET['term'])), MB_CASE_TITLE, "UTF-8");

$ary = explode(' ', preg_replace('/\s+/', ' ', trim($_GET['term'])));
if(is_array($ary) ) {
    foreach($ary as $key) {
        $term = $term.  ' and paciente.nombre like "%'.trim($key).'%" ';
    }
}else $term=' and paciente.nombre like "%'.trim($_GET['term']).'%" ';
//$query = $db->query('SELECT `nombre` FROM `doctor`  WHERE `nombre` LIKE "%'.trim($_GET['term']).'%" order by `nombre` limit 10');
//$query = $db->query('SELECT `nombre` FROM `paciente`  WHERE 1 '.$term.' order by `nombre` limit 7');

// $strings = $wpdb->get_results("SELECT DISTINCT paciente.nombre FROM `paciente`
// INNER JOIN `orden` ON paciente.dni=orden.paciente_dni 
// WHERE 1 
// ".$term." 
// and EXISTS(SELECT orden.paciente_dni FROM orden WHERE orden.paciente_dni=paciente.dni  LIMIT 1) 
// order by paciente.dni DESC LIMIT 20");

// DISTINCT
$strings = $wpdb->get_results('SELECT SQL_CACHE paciente.nombre FROM `paciente` 
WHERE 1 
'.$term.'
and EXISTS(SELECT orden.paciente_dni FROM orden WHERE orden.paciente_dni=paciente.dni LIMIT 1) 
order by paciente.dni DESC LIMIT 1');


// sort($strings);
foreach ( $strings as $string ) 
{
    // $data[]= utf8_encode(ucwords(strtolower(utf8_decode($string->nombre))));
    $data[]= mb_convert_case(preg_replace('/\s+/', ' ', trim($string->nombre)), MB_CASE_TITLE, "UTF-8");
}


// while ($row = $query->fetch_assoc()) {
//     $data[] = utf8_encode(utf8_decode($row['nombre'])); //online
//     //$data[] = utf8_encode($row['nombre']); //local
// }

// natcasesort($data);
echo json_encode($data);
}