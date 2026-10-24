<?php
function comprobar_si_orden_existe($id){

    global $wpdb;
    $row = $wpdb->get_var('
        SELECT SQL_CACHE COUNT(id) as num_rows FROM orden WHERE id='.$id
); 

    return $row;

}

function comprobar_si_orden_y_dni_existen($id,$dni_dni){

    global $wpdb;
    $row = $wpdb->get_var('
        SELECT  SQL_CACHE  COUNT(id) as num_rows FROM orden inner join paciente on orden.paciente_dni=paciente.dni WHERE orden.id='.$id.' AND paciente.dni_dni LIKE "'.$dni_dni.'"'

); 

    return $row;

}

function set_height($str,$ancho) { //número de filas en un texto
  $row = 0;
  $ary = explode("\n", utf8_decode($str));

    if(is_array($ary) ) {
        //$height = 18 * count($ary);
        //$style=' style="height:'.$height.'px; width:100%;" ';
        foreach($ary as $key) {

            $row = $row + ceil(strlen($key)/$ancho);

        }

       // $row = count($ary);
    }
if($str=='') $row=1;


  return $row;
}

/*
function autocompletar($term){
global $wpdb;

$strings = $wpdb->get_results( "SELECT DISTINCT doctor.nombre FROM `doctor`
INNER JOIN `orden` ON doctor.cmp=orden.doctor_cmp 
WHERE 1 and doctor.nombre like ".$term." 
and EXISTS(SELECT orden.doctor_cmp FROM orden WHERE orden.doctor_cmp=doctor.cmp LIMIT 1) 
order by doctor.nombre LIMIT 7");

foreach ( $strings as $string ) 
{
    $data[]= $string->nombre;
}

$someArray = json_encode($data);

return     $someArray; 

}
*/

function getBuscarOrden()
{
    //echo __METHOD__ . '<br>';
    $_POST['orden']=trim($_POST['orden']);
    global $orden;
    global $wpdb;
    $c=0;
    $temp="";
    $blank="";
//    if($_POST['orden']>20109999 && $_POST['orden']<20121950) $blank=''; else $blank="prueba.prueba<>'' and";
    if($_POST['orden']>10000000 && $_POST['orden']<20160000) $blank=''; else $blank="prueba.prueba<>'' and";



    $ocado = $wpdb->get_results("
            SELECT  SQL_CACHE  area,numerodeorden, analisis.id as analid, nombre, prueba, unidades,  vn, vm, vh, metodo, prueba.id, prueba.vmax, prueba.vmin
            FROM item_analisis
            inner join prueba on item_analisis.analisis_id=prueba.analisis_id
            inner join analisis on analisis.id=prueba.analisis_id
               where ".$blank." item_analisis.orden_id=" . $_POST['orden'] . " order by area, analisis.nombre, prueba.numerodeorden asc");
    //(prueba.id<1532 or prueba.id>1919) and

   /* $ocado = $wpdb->get_results("
            SELECT area,numerodeorden, analisis.id as analid, prueba.id, nombre, prueba, resultado, unidades, item.valores as valores, vn, vm, vh, metodo
            FROM item
            inner join prueba on item.prueba_id = prueba.id
            inner join analisis on analisis.id = prueba.analisis_id
            where item.orden_id=" . $_POST['orden'] . " order by area, analisis.nombre, prueba.numerodeorden asc");*/
    //$wpdb->show_errors();//$wpdb->print_error();
    if (!$ocado) {
//        echo 'No existe la orden Nº: ' . str_pad($_POST[orden], 8, "0", STR_PAD_LEFT);
        info($i = "No existe la orden Nº " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
    } else {
        info($i = "Ingresar resultados de los análisis solicitados en la orden Nº " . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT));
        getDatosOrden();
        css_tabla_resultados();
        ?>


        <form method="post" id="content">
            <input type="hidden" name="sexo" value="<?= $orden['sexo'] ?>"/>

            <!--<table id="example" class="display">-->
            <table >

                <thead>

                <tr>
                    <th style="width:10%">Análisis</th>
                    <th style="width:10%">Prueba</th>
                    <th style="width:5%" >VRmin</th>
                    <th style="width:24%">Resultado</th>
                    <th style="width:5%" >VRmax</th>
                    <th style="width:10%">Unidades</th>
                    <th style="width:24%">Valores Referenciales <?php // if ($orden['sexo'] == 'h') echo 'HOMBRE'; else if ($orden['sexo'] == 'm') echo 'MUJER'; else echo 'INFANTE'; ?> </th>
                    <th style="width:12%">Método</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ocado as $rowP) {

                    $rowPR = $wpdb->get_row( "SELECT  SQL_CACHE  resultado, valores,vmin,vmax FROM item WHERE orden_id =".$_POST['orden']." and prueba_id=".$rowP->id );


                    if (($c++) % 2 != 0) $clase = 'odd'; else $clase = "";

                    if ($temp != $rowP->analid) {
                        $analisis = '<b>'.ucfirst(strtolower($rowP->nombre)).'</b>';
                        // $clase=$clase." thick-row";
                    } else {
                        $analisis = '<span style="color: #A9A9A9">'.ucfirst(strtolower($rowP->nombre)).'</span>';
                    }
                    $temp = $rowP->analid;


                    if (isset($rowPR->valores))
                        $val = $rowPR->valores;
                    else {
                        if ($orden['sexo'] == 'i') {
                            $val = $rowP->vn; /*echo "-> i ".$orden[sexo]." <-";*/
                        } else {
                            if ($orden['sexo'] == 'm') {
                                $val = $rowP->vm; /*echo "-> m ".$orden[sexo]." <-";*/
                            } else {
                                $val = $rowP->vh; /*echo "-> h ".$orden[sexo]." <-";*/
                            }
                        }
                        //echo $rowP->valoresP;
                    }


                    ?>
                    <input type="hidden" name="items[]" value="<?= $rowP->analid; ?>"/>


                    <tr class="<?= $clase; ?>">

                        <td class="td5"><?=$analisis?></td>
                        <td class="td5"><?= $rowP->prueba; ?></td>


                        <td>
                        <textarea  style="width: 90%"
                            onkeyup="auto_grow(this)"
                            rows="<?php if(isset($rowPR->vmin)) echo set_height($rowPR->vmin,4); else echo '1';?>"
                             placeholderX="vmin"
                            name="vmin<?= $rowP->id; ?>"
                            ><?php if(isset($rowPR->vmin)) echo $rowPR->vmin; else echo $rowP->vmin ?></textarea>
                        </td>


                        <td>
                            <textarea <?php if ($c == 1) echo "autofocus"; ?>
                                onkeyup ="auto_grow(this)"
                            rows="<?php if(isset($rowPR->resultado)) echo set_height($rowPR->resultado,36); else echo '1';?>"
                            tabindex="<?=$c?>"
                           placeholderX="<?= $rowP->prueba; ?>"
                            name="<?= $rowP->id; ?>"
                            ><?php if(isset($rowPR->resultado)) echo str_replace("<br>", "\n", $rowPR->resultado); ?></textarea>

                            <input type="hidden" name="prueba_id[]" value="<?= $rowP->id; ?>"/>
                        </td>
                        

                        <td>
                            <textarea  style="width: 90%"
                            onkeyup="auto_grow(this)"
                            rows="<?php if(isset($rowPR->vmax)) echo set_height($rowPR->vmax,4); else echo '1';?>"
                             placeholderX="vmax"
                            name="vmax<?= $rowP->id; ?>"
                            ><?php if(isset($rowPR->vmax)) echo $rowPR->vmax;  else echo $rowP->vmax?></textarea>
                        </td>








                        <td>
                            <textarea  style="width: 90%"
                            onkeyup="auto_grow(this)"
                            rows="<?php if(isset($rowP->unidades)) echo set_height($rowP->unidades,9); else echo '1';?>"
                             placeholderX="unidades"
                            name="unidades<?= $rowP->id; ?>"
                            ><?= $rowP->unidades; ?></textarea>
                        </td>

                        <td>

                            <textarea
                            onkeyup="auto_grow(this)"
                            rows="<?php if(isset($val)) echo set_height($val,36); else echo '1';?>"
                            placeholderX="<?= $rowP->prueba; ?>"
                            name="valores<?= $rowP->id; ?>"
                            ><?= str_replace("<br>", "\n", $val); ?></textarea>


                        </td>

                        <td>
<textarea style="width: 90%"
                            onkeyup="auto_grow(this)"
                            rows="<?php if(isset($rowP->metodo)) echo set_height($rowP->metodo,14); else echo '1';?>"
                            placeholderX="método"
                            name="metodo<?= $rowP->id; ?>"
                            ><?= $rowP->metodo; ?></textarea>



                        </td>
                    </tr>

                <?php }
                ?>



                </tbody>
                <tfoot >
                <tr>


                    <td colspan="8" align="right" height="35" valign="bottom"><button tabindex="<?=++$c?>" title="Guardar Resultados (Alt+G)" type="submit" name="accion" value="Guardar"
                                              accesskey="g" class="pure-button  pure-button-primary">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar Resultados
                        </button>





                        <input type="hidden" name="control" value="Resultado"/>
                        <input type="hidden" name="orden" value="<?= $_POST['orden'] ?>"/>

                        <button tabindex="<?=++$c?>" type="submit" title="Guardar e Imprimir (Ctrl + clic)" name="accion" value="Guardar e imprimir"
                                class="pure-button  pure-button-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir*
                        </button>

                        <input type="hidden" name="dni" value="<?= $orden['paciente_dni']; ?>">
                        <input type="hidden" name="dni_dni" value="<?= $orden['paciente_dni_dni']; ?>">
                        <input type="hidden" name="cmp" value="<?= $orden['doctor_cmp']; ?>">
                        <input type="hidden" name="nota" value="<?= $orden['nota']; ?>">
                        <input type="hidden" name="forden" value="<?= $orden['fecha']; ?>">
                                                <input type="hidden" name="tarifa" value="<?= $orden['tarifa']; ?>">

                        <input type="hidden" name="paciente" value="<?= $orden['paciente']; ?>">
                        <input type="hidden" name="doctor" value="<?= $orden['doctor']; ?>">


                        <button tabindex="<?=++$c?>" title="Cambiar datos de la orden" type="submit" name="accion" value="editar" class="pure-button  pure-button-primary">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Orden</button>
                    </td>

                </tr>

                </tfoot>
            </table>
        </form><br>
        <span style=" color: #A9A9A9;">
        *Para una impresión en ventana aparte se debe mantener presionada la tecla "Ctrl" mientras se hace clic en el botón "Imprimir"
</span>
<br><br>

    <script type="text/javascript">
   function auto_grow(element) {
       if(element.value.length>0){
    element.style.height = "0px";
    element.style.height = (element.scrollHeight)-10+"px";}
}
    </script>
    <?php }

echo selectHistorial();



}



function VerOrdenesEditadasPorUsuario($idU)
{
    global $wpdb;
    if($idU=='otros')
        $ocado = $wpdb->get_results('
        SELECT SQL_CACHE orden.id, orden.fecha, sexo, nombre, dni, natalicio, dni_dni FROM paciente inner join orden on paciente.dni=orden.paciente_dni where 1 '.$_POST['IDsActivos'].' order by orden.fecha desc limit 100');
else
    $ocado = $wpdb->get_results('
        SELECT SQL_CACHE orden.id, orden.fecha, sexo, nombre, dni, natalicio, dni_dni FROM paciente inner join orden on paciente.dni=orden.paciente_dni where orden.user_id = ' . $idU . ' order by orden.fecha desc limit 100');


    info($i = "Últimas 100 ordenes creadas o editadas por el usuario: <b>" . ucfirst(strtolower($_POST['Nombre_Usuario'.$idU])).'</b>');
    ?>

    <?=css_tabla_busqueda_pacientes()?>
    <table class="pure-table pure-table-horizontal">
        <thead>
            <tr>
                <th><i class="fa fa-calendar" aria-hidden="true"></i> Fecha de orden</th>
                <th><i class="fa fa-user" aria-hidden="true"></i> Paciente</th>
                <th>DNI</th>
                <th><i class="fa fa-bars" aria-hidden="true"></i> Análisis</th>
                <th><i class="fa fa-table" aria-hidden="true"></i> Orden</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $odd="x";
            $e=0;
            $u="";
            foreach ($ocado as $row) {

                $row->nombre= mb_convert_case(preg_replace('/\s+/', ' ', trim($row->nombre)), MB_CASE_TITLE, "UTF-8");

                // $nombre_resaltado= highlightWords($row->nombre, $_POST['orden']);

                $e=$e+1;
                $nombre = strtoupper(trim(preg_replace('/\s+/', ' ', $row->nombre)));
                $nombref=date_format(date_create($row->fecha), 'd/M/Y');
                ?>
                <style>ul{line-height: 95%}</style>
                <form method="post">
                    <tr <?php if ($e>=2 && $u != $nombref) { if($odd!="odd")$odd="odd"; else $odd="x";}
                    if($u != $nombref) echo "style='border-top: 1px solid !important; '"; 
                    ?> 

<?php  
if($row->dni_dni==0)$dni_dni=''; else $dni_dni=str_pad($row->dni_dni, 8, '0', STR_PAD_LEFT); 
?> 
class="<?=$odd?>" >
<td class="fecha_en_busqueda">&nbsp;<?=
date_i18n( __( 'd/m/Y' ), strtotime($row->fecha) );

?></td>
<td>&nbsp;<?php $u=$nombref;?><?=$row->nombre?></td>
<td><?=$dni_dni?></td>
<td><ul><?php

$oAnal = $wpdb->get_results("select SQL_CACHE analisis.nombre FROM analisis inner join prueba on prueba.analisis_id=analisis.id inner join item on item.prueba_id=prueba.id WHERE item.orden_id=" . $row->id . " GROUP by analisis.nombre");

foreach ($oAnal as $anal) {
    echo '<li>' . ucfirst(strtolower($anal->nombre)).'</li>';
}

?>
</ul>
</td>

<td> <!--ORDEN-->
    <button class="pure-button" type="submit" value="Ver">
        <?= str_pad($row->id, 8, "0", STR_PAD_LEFT); ?>
    </button>

    <input type="hidden" name="accion" value="Buscar">
    <input type="hidden" name="control" value="Resultado">
    <input type="hidden" name="buscarpor" value="orden">
    <input type="hidden" name="orden" value="<?= $row->id; ?>">
</td>


</tr>
</form>

<?php } ?>

</tbody>
</table>


<?php

}






function getBuscarOrdenes($buscarpor)
{
    //echo __METHOD__ . '<br>';
    global $wpdb;
    $_POST['orden']=trim($_POST['orden']);
    if ($buscarpor == 'nombre')
        // $ocado = $wpdb->get_results("
        //    SELECT orden.id, orden.fecha, sexo, nombre, dni, natalicio, dni_dni FROM paciente inner join orden on paciente.dni=orden.paciente_dni where nombre like '%" . trim($_POST['orden']) . "%' order by nombre, fecha desc");

{


$term='';
$ary = explode(' ', trim($_POST['orden']));
if(is_array($ary) ) {
    foreach($ary as $key) {
        $term = $term.  ' and paciente.nombre like "%'.trim($key).'%" ';
    }
}else {$term=' and paciente.nombre like "%'.trim($_POST['orden']).'%" ';}






    $ocado = $wpdb->get_results("
           SELECT SQL_CACHE orden.id, orden.fecha, sexo, nombre, dni, natalicio, dni_dni FROM paciente inner join orden on paciente.dni=orden.paciente_dni where 1 " . $term . " order by orden.fecha desc limit 100");

}
    else $ocado = $wpdb->get_results("
           SELECT  SQL_CACHE  orden.id, orden.fecha, sexo, nombre, dni, natalicio, dni_dni FROM paciente inner join orden on paciente.dni=orden.paciente_dni where dni = " . trim($_POST['orden']) . " order by fecha desc");
    //$wpdb->show_errors();
    //$wpdb->print_error();
    if (!$ocado) {
//        echo 'No hay resultados para la busqueda: ' . $_POST['orden'];
		        info($i = "No hay resultados para la busqueda: " . ucfirst(strtolower($_POST['orden'])));
    } else {

        info($i = "Ordenes encontradas para el " . $buscarpor . ": " . ucfirst(strtolower($_POST['orden'])));
        ?>



<!-- <style type="text/css">
// aquí estaba el estilo de la tabla de resultados de la busqueda por pacientes     
</style> -->


        <?=css_tabla_busqueda_pacientes()?>
        <table class="pure-table pure-table-horizontal">
            <thead>
            <tr>
                <th><i class="fa fa-calendar" aria-hidden="true"></i> Fecha de orden</th>
                <th><i class="fa fa-user" aria-hidden="true"></i> Paciente</th>
                <th>DNI</th>
                <th><i class="fa fa-bars" aria-hidden="true"></i> Análisis</th>
                <th><i class="fa fa-table" aria-hidden="true"></i> Orden</th>

<!--                <th><i class="fa fa-transgender" aria-hidden="true"></i> Sexo</th>
                <th>Edad el día de la orden</th>
                <th>DNI</th> -->
                <!--                <th>editar</th>-->
            </tr>
            </thead>
            <tbody>
            <?php
$odd="x";
$e=0;
$u="";
            foreach ($ocado as $row) {

    $row->nombre= mb_convert_case(preg_replace('/\s+/', ' ', trim($row->nombre)), MB_CASE_TITLE, "UTF-8");


$nombre_resaltado= highlightWords($row->nombre, $_POST['orden']);



$e=$e+1;
$nombre = strtoupper(trim(preg_replace('/\s+/', ' ', $row->nombre)));
$nombref=date_format(date_create($row->fecha), 'd/M/Y');
                ?>
                <style>ul{line-height: 95%}</style>
                <form method="post">
                    <tr <?php if ($e>=2 && $u != $nombref) { if($odd!="odd")$odd="odd"; else $odd="x";}
                    if($u != $nombref) echo "style='border-top: 1px solid !important; '"; 
                    ?> 

                    <?php //if (($i++) % 2 != 0) echo 'class="odd"' 
                        if($row->dni_dni==0)$dni_dni=''; else $dni_dni=str_pad($row->dni_dni, 8, '0', STR_PAD_LEFT); 
                    ?> 
                        class="<?=$odd?>" >
                        <td class="fecha_en_busqueda">&nbsp;<?=
                        date_i18n( __( 'd/m/Y' ), strtotime($row->fecha) );
                        // date_i18n( __( 'l, j \d\e F \d\e Y' ), strtotime($row->fecha) );
                        //date_format(date_create($row->fecha), 'd/M/Y h:i A');/*date_i18n('l d/m/Y h:i A', strtotime($row->fecha));*/ 
                        ?></td>
                        <td>&nbsp;<?php $u=$nombref;?><?=$nombre_resaltado?></td>
                        <td><?=$dni_dni?></td>
                        <td><ul><?php

                            $oAnal = $wpdb->get_results("select SQL_CACHE analisis.nombre FROM analisis inner join prueba on prueba.analisis_id=analisis.id inner join item on item.prueba_id=prueba.id WHERE item.orden_id=" . $row->id . " GROUP by analisis.nombre");
                            //foreach ($oAnal as $anal) { echo $anal->nombre.", "; }

                            //$wpdb->show_errors();
                            //$wpdb->print_error();
                            //$items = array();
                            foreach ($oAnal as $anal) {
                                //$anals[] = '<li>' . ucfirst(strtolower($anal->nombre)).'</li>';
                                echo '<li>' . ucfirst(strtolower($anal->nombre)).'</li>';
                            }

                            //echo implode('<br> ', $anals);
                            //unset($anals);

                            ?>
</ul>
                        </td>

                        <td> <!--ORDEN-->
                            <button class="pure-button" type="submit" value="Ver">
                                <!--                                <i class="fa fa-bars" aria-hidden="true"></i>-->
                                <?= str_pad($row->id, 8, "0", STR_PAD_LEFT); ?>
                            </button>

                            <input type="hidden" name="accion" value="Buscar">
                            <input type="hidden" name="control" value="Resultado">
                            <input type="hidden" name="buscarpor" value="orden">
                            <input type="hidden" name="orden" value="<?= $row->id; ?>">
                        </td>
                        <!--<td><?php //echo str_pad($row->id, 8, "0", STR_PAD_LEFT) ?></td>-->


<!--

                        <td><?php //if ($row->sexo == 'm') echo 'Masculino'; else echo 'Femenino'; ?></td>
                        <td><?php /*
                            $datetime1 = date_create($row->fecha);
                            $datetime2 = date_create($row->natalicio);
                            $interval = date_diff($datetime1, $datetime2);
                            echo $interval->format('%y años, %m meses, %d días'); */ ?></td>
                        <td><?php // if ($row->dni >= 10000000) echo $row->dni; ?></td>
-->
                        <!--                        <td>

                                                    <button type="submit" value="editar">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </button>

                                                </td> -->
                    </tr>
                </form>

            <?php } ?>

            </tbody>
        </table>


    <?php
    }
}
/*
function getRealUserIp()
{
    //echo __METHOD__ . '<br>';
    switch (true) {
        case (!empty($_SERVER['HTTP_X_REAL_IP'])) :
            return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])) :
            return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) :
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        default :
            return $_SERVER['REMOTE_ADDR'];
    }

// echo getRealUserIp()

}*/


function info($i)
{ ?>
    <div id="info"><h2><i class="fa fa-info-circle" aria-hidden="true"></i>
            <?= $i; ?></h2></div>
<?php }


function getDatosOrden()
{
    //echo __METHOD__ . '<br>';
    global $wpdb;
    global $orden;
//$orden = $wpdb->get_row("SELECT nota, fecha, user_id, paciente.nombre as paciente, natalicio, sexo, doctor.nombre as doctor FROM orden inner join paciente on orden.paciente_dni=paciente.dni inner join doctor on orden.doctor_cmp=doctor.cmp WHERE id=" . $_POST['orden'], ARRAY_A);

  $orden = $wpdb->get_row("SELECT  SQL_CACHE paciente.dni_dni as dni_dni, tarifa, nota, doctor_cmp, paciente_dni, fecha, user_id, paciente.nombre as paciente, natalicio, sexo, doctor.nombre as doctor FROM orden inner join paciente on orden.paciente_dni=paciente.dni inner join doctor on orden.doctor_cmp=doctor.cmp WHERE id=" . $_POST['orden'], ARRAY_A);
    //$date = new DateTime($orden[fecha]);
    //$wpdb->show_errors();//$wpdb->print_error();
    ?>
<p>
<style>
.ordendatos td {border: none;line-height: 1.2; padding-left: 5px}
</style>

<table class="ordendatos" >
    <tr>
<td>

Paciente
<!--    <br>Valores referenciales -->
<?php if ($orden['dni_dni']) echo '<br>DNI'; ?>
<br>Edad
<br>Médico
<br><!--CMP -->

</td>

<td>

:<b> <?=normalizar_nombre($orden['paciente']); ?> </b>
<!-- <br>:    <b><?php // if (utf8_decode(utf8_encode($orden['sexo'])) == 'h') echo 'hombre'; else if (utf8_decode(utf8_encode($orden['sexo'])) == 'm') echo 'mujer'; else echo 'infante'; ?></b> -->
<?php if ($orden['dni_dni']) echo '<br>: <b>' . str_pad($orden['dni_dni'], 8, '0', STR_PAD_LEFT) . '</b>'; ?>
<br>: <b><?php
    $date = new DateTime(utf8_decode(utf8_encode($orden['natalicio'])));
    if (utf8_decode(utf8_encode($orden['natalicio'])) != '0000-00-00') {
        $datetime1 = date_create($date->format('Y-m-d'));
        $datetime2 = date_create(date_i18n('Y-m-d'));
        $interval = date_diff($datetime1, $datetime2);
        echo $interval->format('%y años %m meses');
        // echo $interval->format('%y años, %m meses, %d días');
    }?> </b>
<br>: <b><?=normalizar_nombre($orden['doctor'])?></b>
<br><!--: <b><?= utf8_decode(utf8_encode($orden['doctor_cmp'])); ?></b>-->

</td>
<td width="5%"></td>
<td>

Orden Nº
<br>Toma de muestra
<br>Analista
<br><?php if ($orden['nota']) echo 'Observaciones'; ?>

</td>
<td>
    :<b> <?= str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT); ?></b>
    <br>: <b><?= date_format(date_create(utf8_decode(utf8_encode($orden['fecha']))), 'd/m/Y h:i A'); ?></b>
    <br>: <b><?php $user_info = get_userdata($orden['user_id']); echo utf8_decode(utf8_encode($user_info->display_name)); //echo $user_info->user_login; ?></b>
    <br><?php if ($orden['nota']) echo ': <b>' . utf8_decode(utf8_encode($orden['nota'])) . '</b>'; ?>

</td>
    </tr>

</table>

</p>
<?php
// echo selectHistorial();

}

 function selectHistorial(){
// $user = wp_get_current_user();
    // return ( isset( $user->ID )
if(get_current_user_id()==2 || get_current_user_id()==1){
    global $wpdb;
    $strings = $wpdb->get_results('SELECT SQL_CACHE DATE_SUB(fecha, INTERVAL "05:00:00" HOUR_SECOND) as fecha,evento,usuario FROM `orden_historial` 
        WHERE orden='.$_POST['orden'].' order by fecha ASC');


$i=1;
    echo 'Historial de cambios de esta orden '.$_POST['orden'].' <br>';
    foreach ( $strings as $string ) 
    { 

        $memberInfo = get_userdata($string->usuario);
        echo str_pad($i++, 2, "0", STR_PAD_LEFT).'.- '.date_format(date_create($string->fecha), 'd/m/Y h:i a').' - '.$memberInfo->user_login.' - '.eventoDescripcion($string->evento).'<br>';
    }
echo '<br>';

}}

function eventoDescripcion($e){
switch ($e) {
    case 'E':
        $e='Edición de orden.'; //updateOrden() cambio de pruebas, paciente, fecha, dni, etc
        break;
    case 'G':
        $e='Guardado de resultados'; //modificaciónde resultados
        break;
    case 'I':
        $e='Impresión de resultados';
        break;
    case 'C':
        $e='Creación de orden';
        break;    
    case 'B':
        $e='Impresión de código de barras';
        break;
    case 'S':
        $e='Impresión de sobre';
        break;    
    case 'U':
        $e='PDF USAT';
        break;
    case 'V':
        $e='PDF ViviLab';
        break;
    case 'Z':
        $e='PDF Gastro Salud';
        break;
    case 'T':
        $e='PDF T&F';
        break;
    case '2':
        $e='PDF T&F2 (PR)';
        break;
    case '3':
        $e='PDF T&F3 (AC)';
        break;                        
    case '9':
        $e='Edicición de paciente o doctor';
        break;                        
    case '8':
        $e='setActualizarDatosorden()';
        break;                        
    case '7':
        $e='Creación de orden.'; //NuevaOrden()
        break;
    case '6':
        $e='setInsertarDatosNuevaDatosorden()';
        break;
    // case '5':
    //     $e='setOrden()';
    //     break;
    case '4':
        $e='Resultados actualizados.'; //setResultado()
        break;                        
    default:
        $e='evento no definido';
        break;
}
return $e;

}



remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

/*
function actualizacion($nombre){
$archivo = $_SERVER['DOCUMENT_ROOT'].$nombre;
$actual =  date_i18n("d/m/Y h:i A",filemtime($archivo));
return 'Actualizado: '.$actual;
}
$nombre ='tucarpeta/archivo.html';
echo actualizacion('/vivilab/wp-content/themes/vivilab/vista.php'); */

add_action('init', 'blockusers_init');
function blockusers_init() //Impide el acceso a wp-admin
{
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url());
        exit;
    }
}

function my_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
/*            background-image: url(http://vivilab.tk/wp-content/themes/vivilab/img/logopapel.png);*/
            background-image: url(https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhDVyBGd4-R5Mtg5AT3w-GbjcEEpkPzJQNTPHmFY1xbcsMREk64mC15IOt0DsnBOieR6hAaKKjM4jLi44zga9bv_VYXDojI0afMw-gcJkN-umcRi5ryTOcvCY--rfSmkbi5mVmGwJVYaRloLuAnZ_wyPzlZUQAHSqxnwFhT_CnwLlXGkpzNc2UPytPr/s16000/logo_vivilab1.webp);
            /*background-image: url(https://1.bp.blogspot.com/-RP0PDmD1ttw/Xjbwsv7mLLI/AAAAAAABOpQ/J9hZT5znywE6Qh6TBxnupqDxrff5CBkswCK4BGAYYCw/login.jpg);*/
			padding-bottom: 0px;
            background-size: 320px 119px;
            width: 320px;
            height: 119px;
        }

        #nav {
            display: none
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'my_login_logo');

function my_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'my_login_logo_url');

function my_login_logo_url_title()
{
    return 'Vivilab';
}
//add_filter('login_headertitle', 'my_login_logo_url_title');

function login_errors_message()
{
    return 'Para recuperar la contraseña comunicarse con su administrador';
}
add_filter('login_errors', 'login_errors_message');

/*
function ImprovedTable($header, $data)
{
    // Anchuras de las columnas
    $w = array(60, 25, 15, 80);
    // Cabeceras
    for ($i = 0; $i < count($header); $i++)
        $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C');
    $this->Ln();
    // Datos
    foreach ($data as $row) {
        $this->Cell($w[0], 6, $row[0], 'LR');
        $this->Cell($w[1], 6, $row[1], 'LR');
        $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
        $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
        $this->Ln();
    }
    // Línea de cierre
    $this->Cell(array_sum($w), 0, '', 'T');
}*/

function select2files(){
    ?>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script> -->

<script type="text/javascript">
(function(){if(jQuery&&jQuery.fn&&jQuery.fn.select2&&jQuery.fn.select2.amd)var e=jQuery.fn.select2.amd;return e.define("select2/i18n/es",[],function(){return{errorLoading:function(){return"La carga falló"},inputTooLong:function(e){var t=e.input.length-e.maximum,n="Por favor, elimine "+t+" car";return t==1?n+="ácter":n+="acteres",n},inputTooShort:function(e){var t=e.minimum-e.input.length,n="Por favor, introduzca "+t+" car";return t==1?n+="ácter":n+="acteres",n},loadingMore:function(){return"Cargando más resultados…"},maximumSelected:function(e){var t="Sólo puede seleccionar "+e.maximum+" elemento";return e.maximum!=1&&(t+="s"),t},noResults:function(){return"No se encontraron resultados"},searching:function(){return"Buscando…"}}}),{define:e.define,require:e.require}})();
</script>
    <?php
}
function select2script(){
?>
<script type="text/javascript">

        $(document).ready(function() {$(".select2").select2({language: "es", placeholder: "seleccionar análisis", width: "370px"});
 // Una vez inicializado, muestra el elemento
    $(".select2").css('visibility', 'visible');
    });

    </script>
<?php
}



// Deshabilitar Dashicons en el front-end dashicons.min.css 
add_action( 'wp_print_styles', 'my_deregister_styles' );
function my_deregister_styles()    { 
   wp_deregister_style( 'dashicons' ); 
}

add_action( 'wp_footer', 'register_wp_footer' );
function register_wp_footer() { 
    wp_enqueue_style( 'dashicons', '/wp-includes/css/dashicons.min.css');
}

add_action( 'init', 'remove_dns_prefetch' ); 
function  remove_dns_prefetch () {      
   remove_action( 'wp_head', 'wp_resource_hints', 2, 99 ); 
} 





//desabilitar embebidos emoticones de wordpress
function disable_embeds_code_init() {

 // Remove the REST API endpoint.
 remove_action( 'rest_api_init', 'wp_oembed_register_route' );

 // Turn off oEmbed auto discovery.
 add_filter( 'embed_oembed_discover', '__return_false' );

 // Don't filter oEmbed results.
 remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

 // Remove oEmbed discovery links.
 remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

 // Remove oEmbed-specific JavaScript from the front-end and back-end.
 remove_action( 'wp_head', 'wp_oembed_add_host_js' );
 add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

 // Remove all embeds rewrite rules.
 add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

 // Remove filter of the oEmbed result before any HTTP requests are made.
 remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}

add_action( 'init', 'disable_embeds_code_init', 9999 );

function disable_embeds_tiny_mce_plugin($plugins) {
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}

//desactivar rss
function itsme_disable_feed() {
 wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);




// Desactivar el API Heartbeat ajax

// Desactivar el API Heartbeat ajax
// add_action( 'init', 'stop_heartbeat', 1 );
// function stop_heartbeat() {
//  wp_deregister_script('heartbeat');
// }



// // //funcion para eliminar comentarios del codigo final html
// function callback($buffer) {
//      $buffer = preg_replace('/<!--(.|\s)*?-->/', '', $buffer);
//      $buffer = preg_replace('/\/\*(.|\s)*?\*\//', '', $buffer);

//     return $buffer;
// }
// function buffer_start() {
//     ob_start("callback");
// }
// function buffer_end() {
//     ob_end_flush();
// }
// add_action('get_header', 'buffer_start');
// add_action('wp_footer', 'buffer_end');


// minify html rompe el ajax de buscar ordenes y pacientes
// minify html rompe el javascrip si hay comentarios
 
// add_action('get_header', 'pt_html_minify_start');
// function pt_html_minify_start()  {
//     ob_start( 'pt_html_minyfy_finish' );
// }
// function pt_html_minyfy_finish( $html )  {
//   $html = preg_replace('/<!--(?!s*(?:[if [^]]+]|!|>))(?:(?!-->).)*-->/s', '', $html);
//   $html = preg_replace('/\/\*(.|\s)*?\*\//', '', $html);
//   //$html = str_replace(array("\r\n", "\r", "\n", "\t"), '', $html);
//   //$html = str_replace(array("\r", "\r", "\n\n", "\t"), '', $html);
//   while ( stristr($html, '  '))
//      $html = str_replace('  ', ' ', $html);
//  return $html;
// }









//resalta el texto en los fresultados de busqueda por pacientes
function highlightWords($text, $word){
    $word= mb_convert_case(preg_replace('/\s+/', ' ', trim($word)), MB_CASE_TITLE, "UTF-8");
    $word = explode(' ', preg_replace('/\s+/', ' ', trim($word)));
    $word = implode('|',$word);
    $text = preg_replace('#'. $word .'#i', '<b>\0</b>', $text);
    return $text;
}


//Normalice los caracteres EOL y elimine los espacios en blanco duplicados.
function normalizar_nombre($txt){
    return mb_convert_case(normalize_whitespace( $txt ), MB_CASE_TITLE, "UTF-8");
}

function ultima_orden(){
    global $wpdb;
    $row = $wpdb->get_var("
        SELECT SQL_CACHE LAST_INSERT_ID(id) FROM orden ORDER BY id DESC LIMIT 1"); 

    return $row;
}

// https://wordpress.org/plugins/wp-favicon-remover/
add_action( 'do_faviconico', 'wp_favicon_remover');
function wp_favicon_remover() {
 wp_redirect( get_site_icon_url( 16,  'https://favicon-generator.org/favicon-generator/htdocs/favicons/2016-10-20/dd88b45aa6e66f4ade5461d80eac8f89.ico'  ) );
     exit;
}
/*add_action( 'do_faviconico', 'magic_favicon_remover');
function magic_favicon_remover() {
 wp_redirect( get_site_icon_url( 16,  'https://favicon-generator.org/favicon-generator/htdocs/favicons/2016-10-20/dd88b45aa6e66f4ade5461d80eac8f89.ico'  ) );
     exit;
}*/

// function do_favicon() {
//     /**
//      * Fires when serving the favicon.ico file.
//      *
//      * @since 5.4.0
//      */
//     do_action( 'do_faviconico' );
 
//     wp_redirect( get_site_icon_url( 32, includes_url( 'https://favicon-generator.org/favicon-generator/htdocs/favicons/2016-10-20/dd88b45aa6e66f4ade5461d80eac8f89.ico' ) ) );
//     exit;
// }

function script_buscar_ordenes(){
          //  $("#ordenes").val("<?=ultima_orden()");
?>
<script type="text/javascript">
    $(function() {
            $( "#ordenes" ).autocomplete({
                  source: '<?=get_template_directory_uri()?>/searcho.php', 
                  minLength: 4
            }).data("ui-autocomplete")._renderItem = function( ul, item ) {
                  let txt = String(item.value).replace(new RegExp(this.term.trim(), "gi"),"<span class='resaltar_orden_ajax'>$&</span>");
                  return $("<li></li>")
                  .data("ui-autocomplete-item", item)
                  .append("<div>" + txt + "</div>")
                  .appendTo(ul);
            };}) 
      
</script>
<?php

}


function script_buscar_pacientes(){
?>
<script type="text/javascript">
    

$(function() {           
            $("#pacientes").autocomplete({
                  source: '<?=get_template_directory_uri()?>/searchp.php',
                   delay: 0,
                  minLength: 6
            }).data("ui-autocomplete")._renderItem = function( ul, item ) {    
                  var tt=this.term.trim().split(/\ +/);
                  var t3=tt.join('|');
                  let txt = String(item.value).replace(new RegExp(t3, "gi"),"<b>$&</b>");
                  return $("<li></li>")
                  .data("ui-autocomplete-item", item)
                  .append("<div>" + txt.toLowerCase() + "</div>")
                  .appendTo(ul);
            };

      })
           
</script>

<?php
}

function script_buscar_doctores(){
?>
<script type="text/javascript">
$(function() {
     $("#doctores").autocomplete({
                  source: '<?=get_template_directory_uri()?>/searchd.php',
                  minLength: 6
            }).data("ui-autocomplete")._renderItem = function( ul, item ) {
                  var tt=this.term.trim().split(/\ +/);
                  var t3=tt.join('|');
                  let txt = String(item.value).replace(new RegExp(t3, "gi"),"<b>$&</b>");
                  return $("<li></li>")
                  .data("ui-autocomplete-item", item)
                  .append("<div>" + txt.toLowerCase() + "</div>")
                  .appendTo(ul);
            };

})
    
    
</script>

<?php
}


function css_tabla_resultados(){
?>

<style type="text/css">
/* PARA LA TABLA DE RESULTADOS */
    textarea {
       /* margin-top: 2px;*/
        resize: none;
        overflow: hidden;
        vertical-align: center;
        width: 97%;
        height: 100%;
        min-height: 100%;
        border: none;
        /*padding-left: 5px;
        padding-top: 5px;*/
        padding: 5px;
        background: transparent;
    }

    textarea::-webkit-input-placeholder {
        font-size: 11.5px;
        line-height: 1;
    }

    textarea:focus {
         outline: none !important;
         
      }

    table {
        line-height: 1;
        border-collapse: collapse;
            }

    table tr:hover {
        background-color: #fff9df;
    }
    table tbody td {
        border: 1px solid;
        border-color: #CBCBCB;
        padding: 0px;
        border-top: none;
    }
    .td5{padding: 5px;}

    table tr {
        border: none;
        vertical-align: top;

    }
    table th {
        background-color: #E0E0E0;
        height: 25px;
        border: 1px solid;
        border-color: #CBCBCB;
        text-shadow: 1px 1px 1px #ccc;
        vertical-align: middle;
    }
    .odd {
        background-color: #F2F2F2;
    }

   /* thead, tfoot {
        display: table-header-group;
    }*/
    th {
  position: sticky;
  top: 46px;
}
</style>




<?php
}
?>



<?php function css_tabla_busqueda_pacientes(){
?>
<style type="text/css">
/* tabla de resultado de busqueda por pasientes */

table {
        line-height: 1;
        border-collapse: collapse;
        width: 100%;
            }

    table tr:hover {
        background-color: #fff9df;
    }
    table tbody td {
        border: 0px solid;
         border-color: #CBCBCB;
        padding: 0px;
    }
    .td5{padding: 5px;}

    table tr {
        border: none;
        vertical-align: center;

    }
    table th {
        background-color: #E0E0E0;
        height: 25px;
        border: 1px solid;
        border-color: #CBCBCB;
        text-shadow: 1px 1px 1px #ccc;
        vertical-align: middle;
    }
    .odd {
        background-color: #F2F2F2;
         }
    .x {
        background-color: #fff;
    }
.fecha_en_busqueda{text-align: left;}
/*.pure-table-horizontal td span {   float: right;}*/
</style>
<?php
}

// function contarOrdenesHoy($id){
//     global $wpdb;
//   $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id.' and fecha like "'.date_i18n('Y-m-d').'%"'); 

//     return $row;  

// }

// function contarOrdenesSemana($id){
//     global $wpdb;
//   $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id.' and fecha >= DATE(NOW()) - INTERVAL 7 DAY'); 

//     return $row;  

// }

// function contarOrdenesMes($id){
//     global $wpdb;
//   $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id.' and fecha >= DATE(NOW()) - INTERVAL 30 DAY'); 

//     return $row;  

// }

function contarOrdenes($id,$dias){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id.' and fecha > ("'.date_i18n('Y-m-d 00:00:00').'" - INTERVAL '.$dias.' DAY)'); 
    return number_format_i18n($row);  
}
function contarOrdenesAño($id,$año){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id.' and YEAR(fecha) ='.$año); 
    return number_format_i18n($row);  
}
function contarOrdenesOtrosAños($id){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id.' and YEAR(fecha) <= 2016'); 
    return number_format_i18n($row);  
}
function contarOrdenesTotalId($id){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE user_id='.$id); 
    return number_format_i18n($row);  
}



function contarOrdenesOtrosIds($dias,$ids){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE (1 '.$ids.') AND fecha > ("'.date_i18n('Y-m-d 00:00:00').'" - INTERVAL '.$dias.' DAY)'); 
    return number_format_i18n($row);  
}
function contarOrdenesOtrosIdsAño($año,$ids){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE (1 '.$ids.') AND YEAR(fecha) =  '.$año); 
    return number_format_i18n($row);  
}
function contarOrdenesOtrosIdsOtrosAños($ids){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE (1 '.$ids.') AND YEAR(fecha) <= 2016'); 
    return number_format_i18n($row);  
}
function contarOrdenesOtrosIdsTotal($ids){
    global $wpdb;
    $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE (1 '.$ids.')'); 
    return number_format_i18n($row);  
}


function contarOrdenesT($dias){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE fecha > ("'.date_i18n('Y-m-d 00:00:00').'" - INTERVAL '.$dias.' DAY)');
    return $row;  
}
function contarOrdenesTAño($año){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE YEAR(fecha) ='.$año); 
    return $row;  
}

function contarOrdenesTOtrosAños(){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden WHERE YEAR(fecha) <= 2016'); 
    return number_format_i18n($row);  
}
function contarOrdenesTotales(){
    global $wpdb;
  $row = $wpdb->get_var('SELECT SQL_CACHE COUNT(id) FROM orden'); 
    return number_format_i18n($row);  
}








function limpiarNumero($dato) {
    // Eliminamos puntos y comas para que sea un número puro (ej: 1500)
    return str_replace(['.', ','], '', $dato);
}








/**
 * Elimina todos los comentarios HTML del código fuente de la página.
 */
function eliminar_comentarios_html_del_buffer($buffer) {
    // Esta expresión regular busca y elimina cualquier cosa entre <!-- y -->
    $buffer = preg_replace('/<!--(.*)-->/Uis', '', $buffer);
    return $buffer;
}

function iniciar_buffer() {
    ob_start("eliminar_comentarios_html_del_buffer");
}

function finalizar_buffer() {
    ob_end_flush();
}

// Los hooks 'get_header' y 'wp_footer' se ejecutan al principio y al final de la carga de la página.
add_action('get_header', 'iniciar_buffer');
add_action('wp_footer', 'finalizar_buffer');