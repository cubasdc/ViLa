<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */
include 'modelo.php';
include 'vista.php';
$vista = new Vista();
$modelo = new Modelo();
if (!isset($_POST["control"])) $_POST["control"]="";

// if (isset($_POST['orden'])) comprobar_si_orden_existe($_POST['ordenweb']);

switch ($_POST["control"]) {

case 'VerOrdenesEditadasPorUsuario':
    VerOrdenesEditadasPorUsuario($idU=$_POST['id_usuario']);
            break;

case 'Estadisticas':
    $vista->estadisticas();
            break;

case 'Catalogo':
        switch ($_POST["accion"]) {

           default:
            info($i = "Editar lista de análisis y pruebas:");
            $vista->getAnalisisList();
            break 2;

            case 'Editar':
            info($i = "Editar análisis seleccionado:");
            $vista->getEditAnalisis();
            break 2;

            case 'Guardar':
            info($i = "Datos actualizados");
            $modelo->setCatalogo();
            $vista->getEditAnalisis();
            break 2;

            case 'AgregarAnalisis':
            info($i = "Analisis agregado.");
            $modelo->agregaranalisis();
            $vista->getEditAnalisis();
            break 2;

            case 'Eliminar':
            //info($i = "Dato eliminado");
            $modelo->setEliminarPrueba();
            $vista->getEditAnalisis();
            break 2;

            case 'EliminarAnalisis':
            //info($i = "Dato eliminado");
            $modelo->EliminarAnalisis();
            $vista->getAnalisisList();
            break 2;

            }
        break;


    case 'Usuario':
        switch ($_POST["accion"]) {

           case 'Usuarios':
            info($i = "Usuarios del sistema:");
            $vista->getUsuarios();
            // $vista->estadisticas();
            break 2;

            case 'Usuario':
            info($i = "Cambiar contraseña:");
            $vista->getUsuario();
            break 2;

            case 'Cambiar contraseña':
            info($i = "Contraseña actualizada:");
            $modelo->setUsuario();
            $vista->getUsuario();
            break 2;

            case 'Guardar':
            info($i = "Datos de usuarios actualizados.");
            $modelo->setUsuarios();
            //$vista->getUsuarios();
            break 2;

            case 'Eliminar':
            //info($i = "Usuarios del sistema.");
            $modelo->EliminarUsuario();
            $vista->getUsuarios();
            break 2;

        }
        break;

    case 'Resultado':
        switch ($_POST["accion"]) {

            default:
                info($i = "Buscar orden y actualizar resultados.");
                $vista->getResultado();
                break 2;

            case 'editar':
                $modelo->setResultado();
                info($i = "Actualizar datos de la orden N° " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
                $vista->setOrden();
                break 2;

            case 'Buscar':
                $vista->setResultado();
                break 2;

            case 'Guardar':
                $modelo->setResultado();
                info($i = "Resultados de la orden <b>".str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT)."</b> registrados correctamente.");
                break 2;

            case 'Sobre':
                //$modelo->setResultado();
//                info($i = "Resultados de los análisis de la orden Nº: " . str_pad($_POST[orden], 8, "0", STR_PAD_LEFT));
                info($i = "Imprimir sobre de la orden N° " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
                $vista->getSobres();
                break 2;


            case 'Guardar e imprimir':
                $modelo->setResultado();
//                info($i = "Resultados de los análisis de la orden Nº: " . str_pad($_POST[orden], 8, "0", STR_PAD_LEFT));
                $vista->getImprimible($logo = 'N');
                break 2;

            case 'Reportes':
                info($i = "Reportes, buscar orden.");
                $vista->getReporte();
                break 2;

            case 'Imprimir':
                //info($i = "Reporte de resultados de la orden: ". str_pad($_POST[orden], 8, "0", STR_PAD_LEFT));
                //$modelo->setResultado();
                $vista->getImprimible($logo = 'N');
                break 2;

            case 'Barcode':
                // info($i = "Imprimir código de barras de orden N° " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
                $vista->BarcodePrint();
                break 2;

            case 'Barcode2':
                // info($i = "Imprimir código de barras de orden N° " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
                $vista->BarcodePrint2();
                break 2;

            case 'pdfv':
                // if (comprobar_si_orden_existe($_POST['orden']) != 0) $vista->getImprimible($logo = 'V');
                // else {
                
                // $_POST['accion']='Reportes';
                // get_header();
                // info($i = "Reportes, buscar orden.");
                // $vista->getReporte();}
                $vista->getImprimible($logo = 'V');
                break 2;

            case 'pdfu':
                $vista->getImprimible($logo = 'U');
                break 2;

            case 'pdfs':
                $vista->getImprimible($logo = 'U');
                break 2;

            case 'pdfDk':
                $vista->getImprimible($logo = 'U');
                break 2; 
            case 'Imprimir2':
                $vista->getImprimible($logo = 'U');
                break 2; 
            case 'pdfTF':
                $vista->getImprimible($logo = 'U');
                break 2;
            case 'pdfTF2':
                $vista->getImprimible($logo = 'U');
                break 2; 
            case 'pdfTF3':
                $vista->getImprimible($logo = 'U');
                break 2;                    
            case 'pdfCerinor':
                $vista->getImprimible($logo = 'U');
                break 2;       
            case 'pdfGastroSalud':
                $vista->getImprimible($logo = 'U');
                break 2;    
            case 'pdfBM':
                $vista->getImprimible($logo = 'U');
                break 2;
            case 'pdfNazareno':
                $vista->getImprimible($logo = 'U');
                break 2;

            case 'pdfMediplus':
                $vista->getImprimible($logo = 'U');
                break 2;
                     
            case 'pdfSantaRosa':
                $vista->getImprimible($logo = 'U');
                break 2;
            case 'pdfUronor':
                $vista->getImprimible($logo = 'U');
                break 2;
            case 'pdfJR':
                $vista->getImprimible($logo = 'U');
                break 2;   
            case 'pdfInka':
                $vista->getImprimible($logo = 'U');
                break 2;
            case 'pdfCubaMedic':
                $vista->getImprimible($logo = 'U');
                break 2;
            case 'pdfBeneficencia':
                $vista->getImprimible($logo = 'U');
                break 2;      

        }
        break;


    case 'Orden':
        switch ($_POST["accion"]) {

            default:
                info($i = "Ingresar los datos solicitados para generar una nueva orden.");
                $vista->setOrden();
                break 2;

            case 'x':
                $modelo->delServicio($_POST['id']);
                $vista->setServicio();
                $vista->getServicio();
                break 2;

            case 'Confirmar':
                $modelo->setOrden();
                info($i = "Orden registrada correctamente.");
                $vista->getOrden();
                break 2;

            case 'Actualizar':
                $modelo->setOrden();
                info($i = "Orden: " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) . " actualizada.");
                $vista->getOrden();
                //$vista->getOrden();
                break 2;

            case 'Siguiente':
                if ($_POST['orden']) info($i = "Actualizar datos de la orden Nº: " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
                else  info($i = "Ingresar los datos solicitados para generar una nueva orden.");
                $vista->setOrden2();
                break 2;
        }
        break;

    default:
        info($i = "Ingresar los datos solicitados para generar una nueva orden.");
        $vista->setOrden(); //este
        //$vista->getServicio();
//include 'importar.php'; $importar = new Importar();
        //$importar->ImportarPruebas();
        //$importar->ImportarAnalisis();
        //$importar->aux1(); //agrega id a analisis a pruebas
        // $importar->llenar_item_analisis();
        //$importar->importarPacientes();
//        $importar->importarDatosPacientes();
        //$importar->importarItemAnalisis();
        //$importar->importarDoctores();
        //$importar->importarOrdenes();
        //$importar->auxDNIOrdenes();
        //$importar->auxCMPOrdenes();
        //$importar->importarItem();





        break;
/*
    case    'Eliminar':
        $modelo->eliminar($_POST[orden]);
        $vista->buscarO($_POST[log]);
        $vista->listaOrdenes($_POST[cod]);
        break;

    case    'Buscar':
        $vista->buscarO($usuario);
        $vista->listaOrdenes($_POST[cod]);
        break;

    case    'ver':
        $vista->verOrden();
        break;

    case    'Importar':
        $modelo->Importar();
        break;

    case 'Imprimir':
        info($i = "Reportes, buscar orden.");
        $vista->getReporte();
        break;
*/
}

/*
$perfil = new WP_User(2);//get_role('editor');
$perfil->add_cap('list_users');
//$perfil->add_cap('remove_users');
$perfil->add_cap('add_users');
//$perfil->add_cap('edit_users');
$perfil->add_cap('create_users');
//$perfil->add_cap('delete_users');
$perfil->remove_cap('delete_users');
$perfil->remove_cap('edit_users');
$perfil->remove_cap('remove_users');
*/

//echo __METHOD__ . '<br>';
//$wpdb->show_errors();$wpdb->print_error();

//echo site_url();


/*
if ( current_user_can( 'administrator' ) ) {
    global $wpdb;
    echo "<pre>";
    print_r( $wpdb->queries );
    echo "</pre>";
}
*/
