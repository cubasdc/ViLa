<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */
if (is_numeric($_GET['term']) && $_GET['term']<=9999999) {
    include ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
    if (is_user_logged_in())
    {

        global $wpdb;

        $strings = $wpdb->get_results('SELECT SQL_CACHE `id` FROM `orden`  WHERE `id` LIKE "'.trim($_GET['term']).'%" order by `id` desc limit 1');


        foreach ( $strings as $string ) 
        {

           $data[]= $string->id;
       }


       echo json_encode($data);
   }
}

