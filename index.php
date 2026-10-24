<?php  header('Cache-Control: public, max-age=31536000, immutable'); 
   // $start = microtime(true);
if (!isset($_POST['accion'])) $_POST['accion'] = '';
if (
    $_POST['accion'] != 'Barcode' && 
    $_POST['accion'] != 'Barcode2' && 
    $_POST['accion'] != 'Guardar e imprimir' && 
    $_POST['accion'] != 'Imprimir' && 
    $_POST['accion'] != 'pdfBM' && 
    $_POST['accion'] != 'pdfNazareno' && 
    $_POST['accion'] != 'pdfMediplus' && 
    $_POST['accion'] != 'pdfSantaRosa' &&
    $_POST['accion'] != 'pdfInka' &&
    $_POST['accion'] != 'pdfCubaMedic' && 
    $_POST['accion'] != 'pdfUronor' && 
    $_POST['accion'] != 'pdfGastroSalud' && 
    $_POST['accion'] != 'pdfBeneficencia' && 
    $_POST['accion'] != 'pdfCerinor' && 
    $_POST['accion'] != 'pdfDk' && 
    $_POST['accion'] != 'Imprimir2' && 
    $_POST['accion'] != 'pdfTF3' && 
    $_POST['accion'] != 'pdfTF2' && 
    $_POST['accion'] != 'pdfTF' && 
    $_POST['accion'] != 'pdfweb' && 
    $_POST['accion'] != 'pdfv' && 
    $_POST['accion'] != 'pdfu' &&
    $_POST['accion'] != 'pdfJR' && 
    $_POST['accion'] != 'pdfs') 
    get_header();

if (is_user_logged_in())
{

    // if ($_POST['control'] == 'Resultado' && isset($_POST['orden']))
    // {
    //     if (comprobar_si_orden_existe($_POST['orden']) == 0)
    //     {get_header();
    //         $_POST['control'] = '';
    //         // $_POST['accion'] = '';
    //     } // include 'controlador.php';
    //     // Display "Log Out" link.      // Contenido visible únicamente para usuarios conectados
        
    // }
    include 'controlador.php';
}
else
{

    if (isset($_POST['ordenweb']))
    {
        if (comprobar_si_orden_y_dni_existen($_POST['ordenweb'], $_POST['dniweb']) != 0)
        {
           // $info_resultados='Gracias, ha descargado sus resultados en formato PDF';
            include 'resultadoweb.php';
        }
        else
        {

            get_header();
            // $info_resultados='Error. Verifique su número de orden.';
            include 'formularioweb.php';
        }
    }
    else
    {
        // $info_resultados='Consulte el resultado de su análisis';
        include 'formularioweb.php';
    }

?>


<?php
}
if ($_POST['accion'] != 'Guardar e imprimir' && $_POST['accion'] != 'Imprimir' && $_POST['accion'] != 'PDF') get_footer();
// $end = microtime(true);
//     $time = round($end-$start, 4);
//      // $time = $end-$start;
//     echo "execute time {$time}";
// echo header();
