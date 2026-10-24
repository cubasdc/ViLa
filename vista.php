<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */
class Vista
{


    public function getEditAnalisis()
    {

        ?>
<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.6.0/tables-min.css"> -->
        <form method="post" class="pure-form pure-form-aligned" id="formGuardar">
            <fieldset>

                <div class="pure-controls" style="margin-left: 0px !important">
                    <table class="pure-table pure-table-horizontal">
                        <thead>
                        <tr>
                            <th>Análisis</th>
                            <th>Área*</th>
                            <th>Tarifa</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            global $wpdb;
                            $row = $wpdb->get_row("SELECT  SQL_CACHE  nombre, area, tarifa FROM analisis where id=" . $_POST['analisis_id']);
                            ?>

                            <td> <?= esc_html($row->nombre) ?></td>
                            <td>
                            <select name="area">
                            <option value="1" <?php if($row->area==1) echo "selected" ?> >Hormonas</option>
                            <option value="2" <?php if($row->area==2) echo "selected" ?>>Inmunología</option>
                            <option value="3" <?php if($row->area==3) echo "selected" ?>>Bioquímica</option>
                            <option value="4" <?php if($row->area==4) echo "selected" ?>>Hematología</option>
                            <option value="5" <?php if($row->area==5) echo "selected" ?>>Microbiológia</option>
                            <option value="6" <?php if($row->area==6) echo "selected" ?>>Heces</option>
                            <option value="7" <?php if($row->area==7) echo "selected" ?>>Orina</option>
                            <option value="8" <?php if($row->area==8) echo "selected" ?>>Otros</option>
                            <option value="9" <?php if($row->area==9) echo "selected" ?>>Marcadores tumorales</option>
                            <option value="z" <?php if(!is_numeric($row->area)) echo "selected" ?>>Impresión aparte</option>
                            </select>
                           <!--
                            <input maxlength="1" size="3" type="text"
                                       name="area" value=>-->
                                       </td>
                                       <td>S/. <input name="tarifa" type="number" step="any" min="0" value="<?=$row->tarifa?>"></td>
                        </tr>

                        </tbody>
                    </table>
                </div>



<?php 
// css_tabla_resultados();
?>

<style type="text/css">

    textarea {
       /* margin-top: 2px;*/
        resize: none ;
        overflow: hidden ;
        vertical-align: center ;
        width: 100% ;
        height: 100% ;
        min-height: 100% ;
        border: none ;
        /*padding-left: 5px;
        padding-top: 5px;*/
        padding: 5px !important;
        background: transparent ;
    }

    textarea::-webkit-input-placeholder {
        font-size: 11.5px ;
        line-height: 1 ;
    }

    textarea:focus {
        /*outline-style: solid ;*/
        /*outline-width: 0px ;*/
        /*padding: 5px !important;*/
    }
   td{padding-right: 1px !important;
    padding-left: 1px !important}
    .no{text-align: right;
        width: 35px;}
        .vr{width: 80px;}
        .u{width: 120px;}
</style>






                <div class="pure-controls" style="margin-left: 0px !important">
<table class="pure-table pure-table-horizontal">
<thead>
<tr>
    <th style="width:1%">#**</th>
    <th style="width:10%">Prueba</th>
    <th style="width:8%">Unidad</th>
    <th style="width:5%">VRmin</th>
    <th style="width:5%">VRmax</th>
    <th style="width:39%">Valores Referenciales</th>
    <!--<th style="width:10%" width="250">V.R. Mujer</th><th style="width:10%" width="250">V.R. Hombre</th>-->
    <th style="width:39%">Método</th>
    <th style="width:1%"></th>
</tr>
</thead>

<tbody>
<?php
global $wpdb;
$pruebas = $wpdb->get_results("SELECT  SQL_CACHE id, prueba, numerodeorden,vn,vm,vh,unidades,metodo,vmax,vmin FROM prueba where analisis_id=" . $_POST['analisis_id'] . " order by numerodeorden");

$c=1;
foreach ($pruebas as $prueba) {

?>
<tr>

<td><input class="no" tabindex="<?=$c=$c+1?>"  type="text" name="no<?= esc_html($prueba->id) ?>" value="<?= $prueba->numerodeorden ?>" required>
</td>
<td> <?= esc_html($prueba->prueba) ?></td>

<td>
<input class="u" type="text" placeholder="Unidades"  name="unidades<?=$prueba->id?>" value="<?= esc_html($prueba->unidades) ?>">
</td>
<td>
<input class="vr" type="text" placeholder="VRmin"  name="vmin<?=$prueba->id?>" value="<?= esc_html($prueba->vmin) ?>">
</td>

<td>
<input class="vr" type="text" placeholder="VRmax"  name="vmax<?=$prueba->id?>" value="<?= esc_html($prueba->vmax) ?>">
</td>

<td><textarea onkeyup="auto_grow(this)" placeholderX="V.R. Infante"
rows="<?php if(isset($prueba->vn)) echo set_height($prueba->vn,30); else echo '1';?>"
name="vri<?=$prueba->id?>"><?= str_replace("<br>", "\n", $prueba->vn); ?></textarea></td>
<!--
<td><textarea onkeyup="auto_grow(this)" placeholder="V.R. Mujer"
rows="<?php if(isset($prueba->vm)) echo set_height($prueba->vm,30); else echo '1';?>"
name="vrm<?=$prueba->id?>"><?= str_replace("<br>", "\n", $prueba->vm); ?></textarea></td>
<td><textarea onkeyup="auto_grow(this)" placeholder="V.R. Hombre"
rows="<?php if(isset($prueba->vh)) echo set_height($prueba->vh,30); else echo '1';?>"
name="vrh<?=$prueba->id?>"><?= str_replace("<br>", "\n", $prueba->vh); ?></textarea></td>
-->
<td><textarea onkeyup="auto_grow(this)"
rows="<?php if(isset($prueba->metodo)) echo set_height($prueba->metodo,30); else echo '1';?>"
 type="text" placeholder="Método" size="4" name="metodo<?=$prueba->id?>"><?= esc_html($prueba->metodo) ?></textarea></td>
<!-- <td><input id="element" class="element" type="text" placeholder="Método" size="4" name="metodo<?=$prueba->id?>" value="<?= esc_html($prueba->metodo) ?>"></td> -->



<td>
<form method="post" id="formEliminar<?= esc_html($prueba->id) ?>">
<input type="hidden" name="id" value="<?= esc_html($prueba->id) ?>">
<button form="formEliminar<?= esc_html($prueba->id) ?>" type="submit" class="pure-button pure-button-primary" name="accion"
value="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i>
</button>
<input type="hidden" name="control" value="Catalogo">
<input type="hidden" name="analisis_id" value="<?=$_POST['analisis_id']?>">

</form>

</td>
</tr>
<input type="hidden" name="id[]" value="<?= esc_html($prueba->id) ?>">

<?php
}
?>

<tr>
<td> <input class="no" type="text" name="ordernew"  value="<?=$c?>"  > </td>
<td> <input type="text" name="newprueba"  placeholder="agregar nueva prueba" > </td>
<td></td><td></td><td></td> <td></td><td></td> <td></td>
</tr>

</tbody>
</table>
<script type="text/javascript">
function auto_grow(element) {
if(element.value.length>0){
element.style.height = "0px";
element.style.height = (element.scrollHeight)-5+"px";}
}
</script>
                </div>

                <div class="pure-controls" style="margin-left: 0px !important">
                    <button form="formGuardar" type="submit" name="accion" value="Guardar" class="pure-button pure-button-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                    </button>
                    <input type="hidden" name="control" value="Catalogo">
                    <input type="hidden" name="analisis_id" value="<?=$_POST['analisis_id']?>">
                </div>
            </fieldset>
        </form>
<p>
*Los análisis se imprimen agrupados por áreas.
<br>**Secuencia en el que se imprimen las pruebas.
</p>
    <?php

    }




public function getAnalisisList()
    { select2files();
?>
<script type="text/javascript">

        $(document).ready(function() {$(".select2").select2({maximumSelectionLength: 1, placeholder: "seleccionar un análisis", language: "es"});});

    </script>

<form method="post" class="pure-form pure-form-aligned">
    <fieldset>
        <div class="pure-control-group">
            <label>Seleccionar análisis:</label>
            <select style="height:0px;" name="analisis_id" class="select2" multiple="multiple" required  autofocus>
                          <?php global $wpdb;
              $ocado = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
              foreach ($ocado as $row) {?>
                <option value="<?= $row->id ?>">
                    <?= $row->nombre ?>
                </option>
                <?php } ?>
            </select>
            <button type="submit" class="pure-button pure-button-primary" name="accion" value="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
            <button type="submit" class="pure-button pure-button-primary" name="accion" value="EliminarAnalisis"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
<input type="hidden" name="control" value="Catalogo">

        </div>



    </fieldset>
</form>


        <form method="post" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-controls">
                    <table class="pure-table pure-table-horizontal">
                        <thead>
                        <tr>
                            <th colspan="2">Agregar nuevo análisis:</th>

                        </tr>
                        <tr>
                            <th>Análisis</th>
                            <th>Área</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> <input size="58" type="text" name="nanalisis"  placeholder="agregar nuevo análisis" required > </td>
                            <td> <select name="narea" style="height: auto;">
                            <option value="1">Hormonas</option>
                            <option value="2">Inmunología</option>
                            <option value="3">Bioquímica</option>
                            <option value="4">Hematología</option>
                            <option value="5">Microbiológia</option>
                            <option value="6">Heces</option>
                            <option value="7">Orina</option>
                            <option value="8">Otros</option>
                            <option value="9">Marcadores tumorales</option>
                            <option value="z">Impresión aparte</option>
                            </select>
                            <!--<input type="text" name="narea" style="text-align: right" size="3" maxlength="1" placeholder="B" required title="Usar la letra inicial de un área" >-->
                             </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                            <button type="submit" name="accion" value="AgregarAnalisis" class="pure-button pure-button-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Agregar
                    </button>
                    </td>
                        </tr>

                        </tbody>
                    </table>

                </div>

                <div class="pure-controls">

                    <input type="hidden" name="control" value="Catalogo">

                </div>
            </fieldset>
        </form>
<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.6.0/tables-min.css"> -->

<?php
}


public function getUsuario()
    {
$user = wp_get_current_user();

?>
        <form method="post" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-controls">
                <table class="pure-table pure-table-horizontal">
                    <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                    </tr>
                    </thead>

                    <tbody>


                        <tr>
                            <td> <?=esc_html( $user->user_login )?></td>
                            <!--<td> <input type=password name="pass<?=esc_html( $user->ID )?>" placeholder="cambiar contraseña" > </td>-->
                            <td> <input required type=password name="newpass" placeholder="cambiar contraseña" > </td>
                            <input type="hidden" name="userID" value="<?=esc_html( $user->ID )?>">

                        </tr>


                </tbody></table></div>

                <div class="pure-controls">
                    <button type="submit" name="control" value="Usuario" class="pure-button pure-button-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    <input type="hidden" name="accion" value="Cambiar contraseña">
                </div> </fieldset>
        </form>
<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.6.0/tables-min.css"> -->
    <?php
    }






public function estadisticas() {
    // 1. Configuración de Fechas Dinámicas
    $anio_actual = (int)date('Y');
    $anio_anterior = $anio_actual - 1;
    $anio_antepasado = $anio_actual - 2;

    // 2. Cálculo de días para promedios
    // Días transcurridos en el año actual (ej: si es 1 de febrero, son 32 días)
    $dias_transcurridos_anio = (int)date('z') + 1; 
    
    // Días totales de los años anteriores (detecta si fue bisiesto)
    $dias_anio_anterior = (date('L', mktime(0, 0, 0, 1, 1, $anio_anterior)) ? 366 : 365);
    $dias_anio_antepasado = (date('L', mktime(0, 0, 0, 1, 1, $anio_antepasado)) ? 366 : 365);

    $blogusers = get_users(array('fields' => array('user_login', 'ID', 'user_status')));
    ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/1.11.2/jquery.dataTables.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable({ 
                "pageLength": 500,
                "paging": false,         // ELIMINA la paginación (muestra todos los registros)
            "searching": false,      // ELIMINA el cuadro de búsqueda
            "info": false,           // Opcional: ELIMINA el texto "Mostrando X de Y registros"
                "order": [[ 3, "asc" ]], // <-- ESTO ORDENA POR ÚLTIMOS 30 DÍAS
                "columnDefs": [
                { "type": "num", "targets": [1, 2, 3, 4, 5, 6, 7] }
            ]
            });
        });
    </script>
    <style>
        th { cursor: pointer; }
        .col-sm-6, .col-sm-5, .col-sm-7 { display: none; }
    </style>

    <h1><i class="fa fa-flag"></i> Resumen de ordenes por usuario activo y fecha</h1>

    <form method="post">
        <table id="example" class="resumen pure-table pure-table-horizontal">
            <thead>
                <tr>
                    <th>Usuario/Ordenes</th>
                    <th>Hoy</th>
                    <th>Últimos 7 días</th>
                    <th>Últimos 30 días</th>
                    <th>Este año (<?= $anio_actual ?>)</th>
                    <th><?= $anio_anterior ?></th>
                    <th><?= $anio_antepasado ?></th>
                    <th>Total Histórico</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ids = '';
                // Bucle de usuarios activos
                foreach ($blogusers as $user) {
                    if ($user->ID != 1 && $user->user_status != 9) {
                        ?>
                        <tr>
                            <td>
                                <button type="submit" name="id_usuario" value="<?= $user->ID ?>">
                                    <?= esc_html($user->user_login) ?>
                                </button>
                                <input type="hidden" name="Nombre_Usuario<?= $user->ID ?>" value="<?= esc_html($user->user_login) ?>">
                            </td>
                            <td><?= limpiarNumero(contarOrdenes($user->ID, $dias = 0)) ?></td>
                            <td><?= limpiarNumero(contarOrdenes($user->ID, $dias = 7)) ?></td>
                            <td><?= limpiarNumero(contarOrdenes($user->ID, $dias = 30)) ?></td>
                            <td><?= limpiarNumero(contarOrdenesAño($user->ID, $anio_actual)) ?></td>
                            <td><?= limpiarNumero(contarOrdenesAño($user->ID, $anio_anterior)) ?></td>
                            <td><?= limpiarNumero(contarOrdenesAño($user->ID, $anio_antepasado)) ?></td>
                            <td><?= limpiarNumero(contarOrdenesTotalId($user->ID)) ?></td>
                        </tr>
                        <?php
                        $ids .= ' AND user_id != ' . $user->ID;
                    }
                }
                ?>
                <tr>
                    <td>
                        <button type="submit" name="id_usuario" value="otros">
                            Usuarios no activos (eliminados)
                        </button>
                        <input type="hidden" name="Nombre_Usuariootros" value="Usuarios no activos (eliminados)">
                        <input type="hidden" name="IDsActivos" value="<?= $ids ?>">
                    </td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIds(0, $ids)) ?></td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIds(7, $ids)) ?></td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIds(30, $ids)) ?></td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIdsAño($anio_actual, $ids)) ?></td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIdsAño($anio_anterior, $ids)) ?></td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIdsAño($anio_antepasado, $ids)) ?></td>
                    <td><?= limpiarNumero(contarOrdenesOtrosIdsTotal($ids)) ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><b>TOTAL DE ORDENES</b></td>
                    <td><b><?= limpiarNumero(contarOrdenesT(0)) ?></b></td>
                    <td><b><?= limpiarNumero(contarOrdenesT(7)) ?></b></td>
                    <td><b><?= limpiarNumero(contarOrdenesT(30)) ?></b></td>
                    <td><b><?= limpiarNumero(contarOrdenesTAño($anio_actual)) ?></b></td>
                    <td><b><?= limpiarNumero(contarOrdenesTAño($anio_anterior)) ?></b></td>
                    <td><b><?= limpiarNumero(contarOrdenesTAño($anio_antepasado)) ?></b></td>
                    <td><b><?= limpiarNumero(contarOrdenesTotales()) ?></b></td>
                </tr>
                <tr style="background-color: #f9f9f9; font-style: italic;">
                    <td>Promedio de ordenes diario</td>
                    <td>-</td> <td><?= round(contarOrdenesT(7) / 7, 0) ?></td>
                    <td><?= round(contarOrdenesT(30) / 30, 0) ?></td>
                    <td><?= round(contarOrdenesTAño($anio_actual) / $dias_transcurridos_anio, 0) ?></td>
                    <td><?= round(contarOrdenesTAño($anio_anterior) / $dias_anio_anterior, 0) ?></td>
                    <td><?= round(contarOrdenesTAño($anio_antepasado) / $dias_anio_antepasado, 0) ?></td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="control" value="VerOrdenesEditadasPorUsuario">
    </form>
    <?php
}














    public function estadisticas1() //primera prueba con variables de ayuda
    { echo '<h1>Resumen de ordenes por usuario activo y fecha</h1>';

        $blogusers = get_users(array('fields' => array('user_login', 'ID', 'user_status')));
        ?>
                    <table class="resumen pure-table pure-table-horizontal">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Hoy</th>
                            <th>Últimos 7 días</th>
                            <th>Últimos 30 días</th>
                            <th>Este año</th>
                            <th>2020</th>
                            <th>2019</th>
                            <th>2018</th>
                            <th>2017</th>
                            <th>otros</th>
                            <th>Total</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
$h=$s=$m=$a=$_20=$_19=$_18=$_17=$o=$t=0;
                        foreach ($blogusers as $user) {

                            if ($user->ID != 1111 && $user->user_status!=9) { // 9 es usuario eliminado 
                                ?>
                                <tr>
                                    <td><?=esc_html($user->user_login)?></td>
                                    <td><?=$h=$h+contarOrdenes($user->ID,$dias=1)?></td>
                                    <td><?=$s=$s+contarOrdenes($user->ID,$dias=7)?></td>
                                    <td><?=$m=$m+contarOrdenes($user->ID,$dias=30)?></td>
                                    <td><?=$a=$a+contarOrdenesAño($user->ID,$año=2021)?></td>
                                    <td><?=$_20=$_20+contarOrdenesAño($user->ID,$año=2020)?></td>
                                    <td><?=$_19=$_19+contarOrdenesAño($user->ID,$año=2019)?></td>
                                    <td><?=$_18=$_18+contarOrdenesAño($user->ID,$año=2018)?></td>
                                    <td><?=$_17=$_17+contarOrdenesAño($user->ID,$año=2017)?></td>
                                    <td><?=$o=$o+contarOrdenesOtrosAños($user->ID)?></td>
                                    <td><?=$t=$t+contarOrdenesTotal($user->ID)?></td>
                                </tr>

                            <?php
                          
                            $ht=$ht+$h;
                            $st=$st+$s;
                            $mt=$mt+$m;
                            $at=$at+$a;
                            $_20t=$_20t+$_20;
                            $_19t=$_19t+$_19;
                            $_18t=$_18t+$_18;
                            $_17t=$_17t+$_17;
                            $ot=$ot+$o;
                            $tt=$tt+$t;
                            $h=$s=$m=$a=$_20=$_19=$_18=$_17=$o=$t=0;
                            }
                        }
                        ?>
                        <tr>
                            <td>Otros</td>
                            <td><?=contarOrdenesTodas($dias=1)-$ht?></td>
                            <td><?=contarOrdenesTodas($dias=7)-$st?></td>
                            <td><?=contarOrdenesTodas($dias=30)-$mt?></td>
                            <td><?=contarOrdenesTodasAño($año=2021)-$at?></td>
                            <td><?=contarOrdenesTodasAño($año=2020)-$_20t?></td>
                            <td><?=contarOrdenesTodasAño($año=2019)-$_19t?></td>
                            <td><?=contarOrdenesTodasAño($año=2018)-$_18t?></td>
                            <td><?=contarOrdenesTodasAño($año=2017)-$_17t?></td>
                            <td><?=contarOrdenesTodasOtrosAño()-$ot?></td>
                            <td><?=$tt?></td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Promedio diario</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                




    <?php
   

}





    public function getUsuarios()
    {

        $blogusers = get_users(array('fields' => array('user_login', 'ID', 'user_status')));
//$blogusers = get_users('user_status!=9');
// Array of stdClass objects.
        ?>
        <form method="post" class="pure-form pure-form-aligned" autocomplete="off">
            <fieldset>
                <div class="pure-controls">
                    <table class="pure-table pure-table-horizontal">
                        <thead>
                        <tr>
                            <th><i class="fa fa-user" aria-hidden="true"></i> Usuario</th>
                            <th><i class="fa fa-key" aria-hidden="true"></i> Contraseña</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php

                        foreach ($blogusers as $user) {

                         //   $user_info = get_userdata($orden['user_id']); echo utf8_decode(utf8_encode($user_info->display_name));

                            if ($user->ID != 1 && $user->user_status!=9) { // 9 es usuario eliminado 
                                ?>
                                <tr>
                                    <td> <?= esc_html($user->user_login) ?></td>
                                    <td><input autocomplete="new-password" type=password name="newpass<?= esc_html($user->ID) ?>"
                                               placeholder="Contraseña sin cambio"></td>
                                    <td>
                                        <?php if ($user->ID != 2) { ?>
                                            <form method="post">
                                                <input type="hidden" name="ID" value="<?= esc_html($user->ID) ?>">
                                                <button type="submit" class="pure-button pure-button-primary"
                                                        name="accion" value="Eliminar" onclick="return confirm('¿Confirma eliminación de usuario <?=esc_html($user->user_login)?>?');"><i class="fa fa-trash-o"></i> Eliminar usuario <?=esc_html($user->user_login)?>
                                                </button>
                                                <input type="hidden" name="control" value="Usuario">
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>

                            <?php
                            }
                        }
                        ?>
                        <tr>
                            <td><input autocomplete="off" type="text" name="newUser" placeholder="Nuevo usuario"></td>
                            <td><input autocomplete="new-password" type=password name="passNewUser" placeholder="Contraseña para nuevo usuario"></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    
                </div>

                <div class="pure-controls">
                    <button type="submit" class="pure-button pure-button-primary" name="accion" value="Guardar"><i
                            class="fa fa-floppy-o" aria-hidden="true"></i> Guardar cambios
                    </button>
                    <input type="hidden" name="control" value="Usuario">
                </div>
            </fieldset>
        </form>




<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.6.0/tables-min.css"> -->
    <?php
    }

   

public function BarcodePrint_css(){
if (comprobar_si_orden_existe($_POST['orden']) != 0) 

    $this->BarcodePrint_orden_verificada();
                else {
                
                $_POST['accion']='Reportes';
                get_header();
                info($i = "Reportes, buscar orden.");
                $this->getReporte();}

}



public function BarcodePrint_orden_verificada()
{

    global $wpdb;
    $ocado = $wpdb->get_row("
        SELECT  SQL_CACHE paciente.nombre as paciente 
        FROM orden
        inner join paciente on orden.paciente_dni = paciente.dni
        inner join doctor on orden.doctor_cmp = doctor.cmp
        where orden.id=" . $_POST['orden']);

        ?>


   
            <?=strtoupper($ocado->paciente);?><br>




<?php
$orden = isset($_POST['orden']) ? str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) : "00000000";



$qrs = [
    "http://t-x-m.com/barcode.asp?bc1=" . $orden . "&bc2=8&bc3=6&bc4=3.5&bc5=1&bc6=1&bc7=Tahoma&bc8=15&bc9=2", 
    "http://t-x-m.com/barcode.asp?bc1=" . $orden . "&bc2=8&bc3=6&bc4=3.5&bc5=1&bc6=1&bc7=Tahoma&bc8=15&bc9=2", 
    "http://t-x-m.com/barcode.asp?bc1=" . $orden . "&bc2=8&bc3=6&bc4=3.5&bc5=1&bc6=1&bc7=Tahoma&bc8=15&bc9=2"
];

$src_qr = $qrs[mt_rand(0, 2)];


//$src_qr = "http://t-x-m.com/barcode.asp?bc1=" . $orden . "&bc2=8&bc3=6&bc4=3.5&bc5=1&bc6=1&bc7=Tahoma&bc8=15&bc9=2";

?>
<img width="158" height="100" id="qr" src="<?= htmlspecialchars($src_qr) ?>" alt="<?= htmlspecialchars($orden) ?>">



        <!--    <img  width="158" height="100" id="qr" src='https://barcode.tec-it.com/barcode.ashx?data=<?= str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT); ?>&code=Code128&unit=Fit&dpi=300&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff' alt='<?= str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT); ?>'> -->
            <!-- decia dpi=96 lo cambie a 300  -->

 
<div class="noprint">

    <p>
        <button onclick=window.print()
        class="pure-button  pure-button-primary"><i class="fa fa-print"
        aria-hidden="true"></i> Imprimir código de barras (Ctrl+P)
    </button>
</p>

<p>
<!-- <button type="submit" name="accion" class="pure-button pure-button-primary" onclick="history.back()"><i
class="fa fa-print"
aria-hidden="true"></i> Imprimir resultados
</button> -->
<button type="submit" name="accion" class="pure-button pure-button-primary" onclick="history.back()"> << Volver a reportes de orden <?=$_POST['orden']?>
            </button>
</p>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script> -->


<!-- <a onclick="printJS('contenedor', 'html');">Print page</a> -->

<!-- <link rel="stylesheet" type="text/css" href="<?=get_bloginfo('template_url')?>/assets/barcode.css" media="print"> -->

<script type="text/javascript">
   /*  window.onload = function () {
    window.print()
} */
 </script>

</div>

<?php }

    


public function getSobres(){
if (comprobar_si_orden_existe($_POST['orden']) != 0) 

    $this->getSobres_orden_verificada();
                else {
                
                $_POST['accion']='Reportes';
                get_header();
                info($i = "Reportes, buscar orden.");
                $this->getReporte();}

}




    public function getSobres_orden_verificada()
    {

        global $wpdb;
        $ocado = $wpdb->get_row("
            SELECT SQL_CACHE  paciente.nombre as paciente, doctor.nombre as medico
            FROM orden
            inner join paciente on orden.paciente_dni = paciente.dni
            inner join doctor on orden.doctor_cmp = doctor.cmp
            where orden.id=" . $_POST['orden']);
//$wpdb->show_errors();$wpdb->print_error();
        //  echo $_POST[orden];

        ?>
        <style>
            #logo {
/*                background-image: url("<?php //echo site_url() ?>/wp-content/themes/vivilab/img/logopdf.png"); */
/*				background-image: url("http://scontent-mia1-1.xx.fbcdn.net/v/t1.0-9/14691068_10154388223068780_3521708186287021771_n.jpg?oh=5a1dfe7b3cc1da8bedcbf3d101a6af40&oe=5865239B");  fallo expiro */
		/*	background-image: url("https://scontent-mia1-2.xx.fbcdn.net/v/l/t1.0-9/14713552_10154388223058780_5672487486630782550_n.jpg?oh=8e541a69d5615dccf1b261784e70b794&oe=58D6B9FA"); */

                background-size: 208px 77px;
                background-repeat: no-repeat;
                width: 100%;
                height: 3cm;
            }
            table tr:hover {
            background-color: #fff;

        }
        </style>
        <!-- <div id="logo"></div> -->


<?php
$orden = isset($_POST['orden']) ? str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) : "00000000";

$qrs = [
    'https://t-x-m.com/barcode.asp?bc1='.$orden.'&bc2=8&bc3=160&bc4=101&bc5=1&bc6=1&bc7=Tahoma&bc8=12&bc9=3', 

    'https://barcode.tec-it.com/barcode.ashx?data='.$orden.'&code=Code128&imagetype=Png'
];

$src_qr = $qrs[mt_rand(0, 1)];

?>

 <img  width="160" height="101" id="qr" src="<?= htmlspecialchars($src_qr) ?>" alt="<?= htmlspecialchars($orden) ?>" >

        
      <!--  <img id="qr"
             src='http://www.mribti.com/barcode/image.php?code=<?= str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT); ?>&style=452&type=I25&width=100&height=70&xres=1&font=3'>
         -->

        <div id="divsobre">
            <table >
                <tr >
                    <td>PACIENTE<br><br>
                        MÉDICO<br><br>PTE.
                    </td>
                    <td>: <b><?= strtoupper($ocado->paciente); ?></b><br><br>
                        : <b><?= strtoupper($ocado->medico); ?></b><br><br>&nbsp;</td>
                </tr>

            </table>
        </div>

        <p>
            <button onclick="window.print()" class="pure-button  pure-button-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir sobre (Ctrl+P)</button>
            <!-- <button onclick="window.print()" id="print" class="pure-button  pure-button-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir sobre (Ctrl+P)</button> -->
        </p>

        <p>
            <!-- <button type="submit" name="accion" class="pure-button pure-button-primary" onclick="history.back()"><i
                    class="fa fa-print"
                    aria-hidden="true"></i> Imprimir resultados
            </button> -->
            <button type="button" name="accion" class="pure-button pure-button-primary" onclick="history.back()"> &lt;&lt; Volver a reportes de orden <?=$_POST['orden']?>
            </button>
        </p>


        <link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url'); ?>/assets/sobres2.css" media="print" />
        <script type="text/javascript">
/*
     window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Restaurada desde bfcache
        window.print();
    }
});

window.addEventListener('load', function() {
    // Carga normal (primera vez)
    window.print();
});
*/
 </script>


    <?php }




    public function setResultado()
    {
        //echo __METHOD__ . '<br>';
        $_POST['orden']=trim($_POST['orden']);
        if (!is_numeric($_POST['orden'])) getBuscarOrdenes($buscarpor = 'nombre');
        else {
            if (strlen($_POST['orden']) == 8) getBuscarOrden(); //getBuscarOrdenes($buscarpor = 'DNI');
            else  getBuscarOrden();
        }
    }


public function getReporte()
{ $current_user = wp_get_current_user();
script_buscar_ordenes();
?>


<form method="post" class="pure-form pure-form-aligned">
<fieldset>
<div class="pure-control-group">
<label>Orden Nº:</label>
<input type="text" name="orden" id="ordenes" class="fontAwesome" placeholder="&#xf002; Número de Orden" pattern='[0-9]{8,8}' maxlength="8" minlength="8" 
required autofocus/>                   
<?php 
if($current_user->user_id==63){
?>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfNazareno"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Imprimir</button>

<?php
} else 
if($current_user->user_status==0){ ?>

<button type="submit" class="pure-button pure-button-primary" 
name="accion" value="Imprimir">
<i class="fa fa-print" aria-hidden="true"></i> Imprimir*</button>

<button title="Imprimir código de barras" type="submit" class="pure-button pure-button-primary"
name="accion" value="Barcode" >
<i class="fa fa-barcode" aria-hidden="true"></i></button>

<button title="Imprimir código de barras" type="submit" class="pure-button pure-button-primary"
name="accion" value="Barcode2" >
<i class="fa fa-barcode" aria-hidden="true"></i></button>

<button title="Imprimir sobre" type="submit" class="pure-button pure-button-primary" name="accion" value="Sobre"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>

</div>
<div class="pure-control-group"><label>PDF:</label>

<button type="submit" class="pure-button pure-button-primary" 
name="accion" value="pdfv">
<i class="fa fa-file-pdf-o" aria-hidden="true"></i> VIVILAB</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfu"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> USAT</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfTF"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> T&F</button> 

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfGastroSalud"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Gastro Salud</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfBM"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> BM Clínica</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfSantaRosa"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Santa Rosa</button>

</div>
<div class="pure-control-group"><label></label>
<!--<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfNazareno"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Nazareno</button>-->



<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfUronor"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Uronor</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfJR"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> J&R</button> 

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfMediplus"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> MediPlus</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfInka"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Inka</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfCubaMedic"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Cuba Medic</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfBeneficencia"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> Beneficencia</button>

</div>
<div class="pure-control-group"><label></label>                    

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfTF2"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> T&F2 (PR)</button>

<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfTF3"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> T&F3 (AC)</button>
<!-- <button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfCerinor"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> CERINOR</button> -->
<!-- <button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfs"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> METROPOLITANA</button> -->        
<?php } else {?> 



<button type="submit" class="pure-button pure-button-primary" name="accion" value="Imprimir2"><i
class="fa fa-print" aria-hidden="true"></i> Imprimir*</button>

<button title="Imprimir código de barras" type="submit" class="pure-button pure-button-primary" name="accion" value="Barcode" ><i class="fa fa-barcode" aria-hidden="true"></i></button>

<button title="Imprimir código de barras" type="submit" class="pure-button pure-button-primary" name="accion" value="Barcode2" ><i class="fa fa-barcode" aria-hidden="true"></i></button>

<button title="Imprimir sobre" type="submit" class="pure-button pure-button-primary" name="accion" value="Sobre"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>

<!-- <button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfDk"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF Diagnostika</button> -->
<button type="submit" class="pure-button pure-button-primary" name="accion" value="pdfDk"><i
class="fa fa-file-pdf-o" aria-hidden="true"></i> VIVILAB</button>


<?php }?>                           

</div>

<input type="hidden" name="control" value="Resultado">

<?php 
if($current_user->user_id!=63){
?>

<BR><BR>
<span style=" color: #A9A9A9; padding-top:0px;  z-index:999999;">Historial de ordenes del 14/07/2010 (20110000) al 26/09/2016 (20123370).<BR>
Las ordenes del 28/09/2016 (10117312) al 20/10/2016 (10117606) se les cambio el primer primer dígito (2) por 1

<?php 
}
?>

<br><br> *Para una impresión en ventana aparte se debe mantener presionada la tecla "Ctrl" mientras se hace clic en el botón "Imprimir"
</span>
</fieldset>
</form>
<?php }


    public function getResultado()
    {

script_buscar_ordenes();
        ?>



        <form method="post" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-control-group">
                    <label>Buscar por orden o paciente:</label>
                    <input type="text" minlength="4" name="orden" id="ordenes"  class="fontAwesome" placeholder="&#xf002; Orden o Paciente"
                           required autofocus pattern="\S+.*.{3,}" title="Buscar por orden o paciente" >
                </div>

                <div class="pure-control-group">
                    <label></label>
                    <button type="submit" name="accion" value="Buscar" class="pure-button pure-button-primary">
                        <i class="fa fa-search" aria-hidden="true"></i> Buscar
                    </button>
                    <input type="hidden" name="control" value="Resultado">
                </div>
<BR><BR>
                <span style="color: #A9A9A9">Historial de ordenes del 14/07/2010 (20110000) al 26/09/2016 (20123370).<BR>
Las ordenes del 28/09/2016 (10117312) al 20/10/2016 (10117606) se les cambio el primer primer dígito (2) por 1</span>

            </fieldset>
        </form>
    <?php }

    public function setOrden2() /// no borrar confirmacion de setOrden()
    { select2files(); select2script();
        //echo __METHOD__ . '<br>';
        /*echo $_POST[items];
        $servicios = $_POST[items];
        foreach ($servicios as $servicio) {
        echo ' '.$servicio;
        } */
        //echo $_POST[orden].' orden_id: '.$_POST[orden_id];


        // print_r($_POST['itemsA']);


        global $wpdb;
        //if ($_POST['dni']) $paciente = $wpdb->get_row("SELECT nombre, sexo, natalicio FROM paciente WHERE dni = " . $_POST['dni']);
        //if ($_POST['cmp']) $doctor = $wpdb->get_row("SELECT nombre FROM doctor WHERE cmp = " . $_POST['cmp']);

        if (!$_POST['paciente'])  $_POST['paciente']='NN';
        if (!$_POST['doctor'])  $_POST['doctor']='NN';

         $paciente = $wpdb->get_row("SELECT  SQL_CACHE dni_dni, dni, sexo, natalicio FROM paciente WHERE nombre LIKE '" . $_POST['paciente']."'");
         $doctor = $wpdb->get_row("SELECT  SQL_CACHE cmp FROM doctor WHERE nombre LIKE '" . $_POST['doctor']."'");

        ?>
        <form method="post" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-control-group">
                    <label>Seleccionar análisis: </label>
                    <select style="width:370px" tabindex="1" name="items[]" class="select2" multiple="multiple"
                            required >
                        <?php
                        $ocado = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($ocado as $row) {
                            ?>
                            <option value="<?= $row->id ?>"
                                <?php foreach ($_POST['items'] as $servicio) {
                                    if ($servicio == $row->id) echo 'selected';
                                } ?>
                                >
                                <?= $row->nombre ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php
                    if (isset($_POST['itemsA'])) foreach ($_POST['itemsA'] as $row) {
                        ?>
                        <input type="hidden" name="itemsA[]" value="<?= $row; ?>"/>
                    <?php } ?>
                </div>


                <div class="pure-control-group">
                    <label><a tabindex="9" href="https://aplicaciones.cmp.org.pe/conoce_a_tu_medico/index.php" target="_blank">Médico</a>: </label>
                    <input readonly size="50" tabindex="11" type='text' name="medico" placeholder="Nombre del médico"
                           value="<?=$_POST["doctor"]; ?>" >
                    <input  type='hidden' readonly name="cmp" placeholder="NN" pattern='[0-9]{1,5}' maxlength="5" size="8"
                            value="<?php if(isset($doctor->cmp)) echo $doctor->cmp; ?>" >
                </div>

                <div class="pure-control-group">
                    <label>Paciente: </label>
                    <input readonly size="50" tabindex="12" type='text' name="paciente" placeholder="Nombre del paciente"
                           value="<?= $_POST['paciente'] ?>">
                    <input type="hidden" readonly  name="dni" placeholder="NN" pattern='[0-9]{0,8}' maxlength="8" size="8"
                           value="<?php if(isset($paciente->dni)) echo $paciente->dni; ?>" >
                    <input type="hidden" name="dniA" value="<?= $_POST['dniA']; ?>"/>
                </div>


                <div class="pure-control-group">
                    <label>Documento
                    : </label>
                    <input autofocus type="text" tabindex="1" name="dni_dni"  placeholder="Número de documento"
                           value="<?php if(isset($paciente->dni_dni) && $paciente->dni_dni>0) echo $paciente->dni_dni; ?>" >
                           <!-- 
                           <input autofocus type="text" tabindex="1" name="dni_dni" pattern="[0-9]{8,10}" maxlength="10" placeholder="Número de documento" 
                           value="<?php if(isset($paciente->dni_dni) && $paciente->dni_dni>0) echo $paciente->dni_dni; ?>" >                  
                       -->
                </div>

                
<!--
                <div class="pure-control-group">
                    <?php $sexo=''; if(!empty($paciente->sexo)) $sexo=$paciente->sexo  ?>
                    <label>Valores referenciales: </label>
                    <select class="fontAwesome" autofocus tabindex="1" name="sexo" required>
                    <option></option>
                        <option value="i" <?php if ($sexo == 'i') echo 'selected'; ?>>&#xf1ae; Infante</option>
                        <option value="m" <?php if ($sexo == 'm') echo 'selected'; ?>>&#xf182; Mujer</option>
                        <option value="h" <?php if ($sexo == 'h') echo 'selected'; ?>>&#xf183; Hombre</option>
                    </select>
                    <input type="hidden" name="sexo1" value="<?= $paciente->sexo ?>"/>
                </div>
-->
<input type="hidden" name="sexo" value="i">
<input type="hidden" name="sexo1" value="<?= $paciente->sexo ?>">

<!--
<div class="pure-control-group">

                    <label><a tabindex="8" href="http://200.48.13.46/cmp/busquecmp.swf" target="_blank">CMP</a>: </label>

                </div> -->



                <!--<div class="pure-control-group">
                    <label>DNI: </label>

                </div>-->


                <div class="pure-control-group">
                    <label>Natalicio: </label>
                    <input  tabindex="2" type=date name="natalicio" placeholder="Fecha de nacimiento"
                           value="<?php if(isset($paciente->natalicio)) echo $paciente->natalicio ?>"
                           max="<?= date_i18n('Y-m-d'); ?>">
                </div>



                <div class="pure-control-group">
                    <label>Fecha de orden: </label>
                    <input 
                    max ="<?=current_time('Y-m-d\TH:i:s')?>" 


                    tabindex="3" type=datetime-local name="forden"  value="<?php
                    if ($_POST["forden"]) {
                        $date = date_create($_POST["forden"]);
                        echo date_format($date, 'Y-m-d\TH:i:s');
                    } else echo current_time('Y-m-d\TH:i:s');
                    ?>">
                </div>




                <div class="pure-control-group">
                    <label>Observaciones: </label>
                    <input class="fontAwesome" tabindex="4" size="50" tabindex="5" type="text" name="nota"
                           placeholder="&#xf24a; Observaciones"
                           value="<?= $_POST['nota'] ?>">
                </div>





                <div class="pure-control-group">
                    <?php $tarifa=''; if(!empty($paciente->tarifa)) $tarifa=$paciente->tarifa  ?>
                    <label>Tarifa: </label>
                    <select class="fontAwesome" tabindex="5" name="tarifa" required>
                        <option value="n" <?php if ($_POST['tarifa'] == 'n') echo 'selected'; ?>>Normal</option>
                        <option value="s" <?php if ($_POST['tarifa'] == 's') echo 'selected'; ?>>Social</option>
                    </select>

                </div>







                <div class="pure-control-group">
                    <input type="hidden" name="control" value="Orden">
                    <input type="hidden" name="orden" value="<?= $_POST['orden']; ?>">
                    <label></label>
                    <button tabindex="6" type="submit" name="accion"
                            value="<?php if ($_POST['orden']) echo 'Actualizar'; else echo 'Confirmar' ?>"
                            class="pure-button  pure-button-primary"><i class="fa fa-floppy-o"
                                                                        aria-hidden="true"></i>
                        <?php if ($_POST['orden']) echo 'Actualizar'; else echo 'Confirmar' ?>
                        orden
                    </button>


                </div>
            </fieldset>
        </form>
    <?php }









public function setOrden__sindni() /// no borrar confirmacion de setOrden()
    { select2files(); select2script();
           if(!isset($_POST["orden"])){
        $_POST["orden"]="";
        //$_POST["dni"]="";
        //$_POST["cmp"]="";
        $_POST["nota"]="";
        $_POST["paciente"]="";
        $_POST["doctor"]="";
        //$_POST['items']="";
    }
        //echo __METHOD__ . '<br>';
        /*echo $_POST[items];
        $servicios = $_POST[items];
        foreach ($servicios as $servicio) {
        echo ' '.$servicio;
        } */
        //echo $_POST[orden].' orden_id: '.$_POST[orden_id];


        // print_r($_POST['itemsA']);


       // global $wpdb;
       // if ($_POST['dni']) $paciente = $wpdb->get_row("SELECT nombre, sexo, natalicio FROM paciente WHERE dni = " . $_POST['dni']);
       // if ($_POST['cmp']) $doctor = $wpdb->get_row("SELECT nombre FROM doctor WHERE cmp = " . $_POST['cmp']);

        ?>
        <form method="post" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-control-group">
                    <label>Seleccionar análisis: </label>
<?php if (!$_POST["orden"]) {
                    ?>
                    <select tabindex="1" name="items[]"
                            class="select2"
                            multiple="multiple"
                            required autofocus>
                        <?php
                        global $wpdb;
                        $ocado = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($ocado as $row) {
                            ?>
                            <option value="<?= $row->id ?>">
                                <?= $row->nombre ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <select  tabindex="1" name="items[]" class="select2" multiple="multiple" required autofocus>
                        <?php
                        global $wpdb;
                        $oAnalisis = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($oAnalisis as $analisis) {
                            ?>
                            <option value="<?= $analisis->id ?>"<?php
                            foreach ($_POST['items'] as $item) {
                                if ($item == $analisis->id) echo ' selected';
                            } ?>><?= $analisis->nombre ?></option>
                        <?php } ?>
                    </select>
                    <?php
                    foreach ($_POST['items'] as $row) {
                        ?>
                        <input type="hidden" name="itemsA[]" value="<?= $row; ?>"/>
                    <?php }
                    } ?>







                    <?php
                    if (isset($_POST['itemsA'])) foreach ($_POST['itemsA'] as $row) {
                        ?>
                        <input type="hidden" name="itemsA[]" value="<?= $row; ?>"/>
                    <?php } ?>
                </div>

<!--

                <div class="pure-control-group">
                    <label>Valores referenciales: </label>
                    <select autofocus tabindex="2" name="sexo" required>
                    <option></option>
                        <option value="i" <?php if (isset($paciente->sexo) == 'i') echo 'selected'; ?>>Infante</option>
                        <option value="m" <?php if (isset($paciente->sexo) == 'm') echo 'selected'; ?>>Mujer</option>
                        <option value="h" <?php if (isset($paciente->sexo) == 'h') echo 'selected'; ?>>Hombre</option>
                    </select>
                    <input type="hidden" name="sexo1" value="<?= $paciente->sexo; ?>"/>
                </div>
-->

<input type="hidden" name="sexo" value="i">
<input type="hidden" name="sexo1" value="<?= $paciente->sexo ?>">

<!--
<div class="pure-control-group">

                    <label><a tabindex="8" href="http://200.48.13.46/cmp/busquecmp.swf" target="_blank">CMP</a>: </label>
                    <input type='text' name="cmp" placeholder="CMP" pattern='[0-9]{1,5}' maxlength="5"
                           value="<?php //= $_POST['cmp']; ?>" readonly/>
                </div> -->

            <!--    <div class="pure-control-group">
                    <label>DNI: </label>
                    <input type='text' name="dni" placeholder="DNI" pattern='[0-9]{8,8}' maxlength="8"
                           value="<?php //= $_POST['dni']; ?>" readonly/>
                    <input type="hidden" name="dniA" value="<?php //= $_POST['dniA']; ?>"/>
                </div> -->
                <div class="pure-control-group">
                    <label>Paciente: </label>
                    <input tabindex="4" type='text' name="paciente" placeholder="Nombre del paciente"
                           value="<?=$_POST['paciente'] ?>"/>
                </div>

                <div class="pure-control-group">
                    <label>Natalicio: </label>
                    <input tabindex="5" type=date name="natalicio" placeholder="Fecha de nacimiento"
                           value="<?= $paciente->natalicio; ?>"
                           max="<?= date_i18n('Y-m-d'); ?>">
                </div>


                 <div class="pure-control-group">
                    <label>Médico: </label>
                    <input tabindex="3" type='text' name="medico" placeholder="Nombre del médico"
                           value="<?=$_POST['doctor'] ?>" required/>
                </div>

                <div class="pure-control-group">
                    <label>Observaciones: </label>
                    <input tabindex="6" type=text name="nota"
                           placeholder="Observaciones"
                           value="<?= $_POST['nota'] ?>"/>
                </div>
                <div class="pure-control-group">
                    <input type="hidden" name="control" value="Orden">
                    <input type="hidden" name="orden" value="<?= $_POST['orden']; ?>"/>
                    <label></label>
                    <button tabindex="7" type="submit" name="accion"
                            value="<?php if ($_POST['orden']) echo 'Actualizar'; else echo 'Confirmar' ?>"
                            class="pure-button  pure-button-primary"><i class="fa fa-floppy-o"
                                                                        aria-hidden="true"></i>
                        <?php if ($_POST['orden']) echo 'Actualizar'; else echo 'Confirmar' ?>
                        orden
                    </button>


                </div>
            </fieldset>
        </form>
    <?php }





public function setOrden() // remplazar el dni por el datalist
    { select2files(); select2script();

        if(!isset($_POST["orden"])){
           // echo 'orden nueva';
        $_POST["orden"]="";
        //$_POST["dni"]="";
        //$_POST["cmp"]="";
        $_POST["nota"]="";
        $_POST["doctor"]="";
        $_POST["paciente"]="";
        $_POST["forden"]="";
          // $_POST["sexo"]="";
    }
        //echo __METHOD__ . '<br>';
        //echo date_i18n('Y-m-d h:i:s');
        global $wpdb;
      /*  $pa='';n
        $me='';
        $pacientes = $wpdb->get_results("SELECT SQL_CACHE nombre FROM paciente order by nombre");
        foreach ($pacientes as $paciente) {
        $pa=$pa.'"'.$paciente->nombre.'",';}
        $medicos = $wpdb->get_results("SELECT SQL_CACHE nombre FROM doctor order by nombre");
        foreach ($medicos as $medico) {
            $me=$me.'"'.$medico->nombre.'",';}*/

     script_buscar_pacientes();
     script_buscar_doctores();

     ?>

     <script type="text/javascript">
               $(document).ready(function () {

            $('.select2-search__field').focus();

      });
     </script>

        <form method="post" class="pure-form pure-form-aligned">

            <div class="pure-control-group">
                <label><i class="fa fa-flask" aria-hidden="true"></i> Seleccionar análisis: </label>
                <?php if (!$_POST["orden"]) {
                    ?>
                    <select style="visibility:hidden" tabindex="1" name="items[]"
                            class="select2"
                            multiple="multiple"
                            required >
                        <?php
                        //global $wpdb;
                        $ocado = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($ocado as $row) {
                            ?>
                            <option value="<?= $row->id ?>"><?= $row->nombre ?></option>

                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <select  style="visibility:hidden" tabindex="1" name="items[]" class="select2" multiple="multiple" required autofocus>
                        <?php
                        global $wpdb;
                        $oAnalisis = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($oAnalisis as $analisis) {
                            ?>
                            <option value="<?= $analisis->id ?>"<?php
                            foreach ($_POST['items'] as $item) {
                                if ($item == $analisis->id) echo ' selected';
                            } ?>><?= $analisis->nombre ?></option>
                        <?php } ?>
                    </select>
                    <?php
                    foreach ($_POST['items'] as $row) {
                        ?>
                        <input type="hidden" name="itemsA[]" value="<?= $row; ?>"/>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="pure-control-group">
                <label><a tabindex="6" href="https://200.48.13.39/cmp/php/index.php" target="_blank" title="click para abrir el buscador del Colegio Médico">Médico</a>: </label>
                                <input style="width: 370px;" id="doctores" type="text" tabindex="1" name="doctor" placeholder="&#xf0f0; MÉDICO Apellidos y Nombres"
                       value="<?php if ($_POST['doctor']) echo $_POST['doctor'] ?>"  title="nombre del médico" class="fontAwesome">
            </div>

            <div class="pure-control-group">
                <label>Paciente: </label>
                                <input  class="fontAwesome" style="width: 370px;" id="pacientes" tabindex="2" type="text"  name="paciente" placeholder="&#xf193; PACIENTE Apellidos y Nombres"
                       value="<?php if ($_POST['paciente']) echo $_POST['paciente'] ?>"
                       title="nombre del paciente"/>


            </div>


            <div class="pure-control-group">
                <!--<label>Observaciones: </label>-->
                <input type="hidden" name="nota" placeholder="Observaciones" value="<?= $_POST['nota'] ?>" size="50" tabindex="4" >
                <input type="hidden" name="dniA" value="<?= $_POST['dni']; ?>">
                <input type="hidden" name="items11[]" value="<?= $_POST['items']; ?>">
                <input type="hidden" name="control" value="Orden">
                <input type="hidden" name="orden" value="<?= $_POST['orden']; ?>">
                <input type="hidden" name="tarifa" value="<?= $_POST['tarifa']; ?>">

                <input type="hidden" name="forden" value="<?= $_POST['forden']; ?>">
                <!--<input type="hidden" name="user_id" value="<?php //echo get_current_user_id() ?>">-->

            </div>
            <div class="pure-control-group">
                <label></label>
                <input tabindex="3" type="submit" name="accion" value="Siguiente"
                       class="pure-button pure-button-primary">
            </div>

        </form>

    <?php
    }





















    public function setOrden_este()
    { select2files(); select2script();

        if(!isset($_POST["orden"])){
        $_POST["orden"]="";
        $_POST["dni"]="";
        $_POST["cmp"]="";
        $_POST["nota"]="";
    }
        //echo __METHOD__ . '<br>';
        //echo date_i18n('Y-m-d h:i:s');
        ?>
        <form method="post" class="pure-form pure-form-aligned">

            <div class="pure-control-group">
                <label>Seleccionar análisis: </label>
                <?php if (!$_POST["orden"]) {
                    ?>
                    <select tabindex="1" name="items[]"
                            class="select2"
                            multiple="multiple"
                            required autofocus>
                        <?php
                        global $wpdb;
                        $ocado = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($ocado as $row) {
                            ?>
                            <option value="<?= $row->id ?>">
                                <?= $row->nombre ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <select  tabindex="1" name="items[]" class="select2" multiple="multiple" required autofocus>
                        <?php
                        global $wpdb;
                        $oAnalisis = $wpdb->get_results("SELECT SQL_CACHE id, nombre FROM analisis order by nombre");
                        foreach ($oAnalisis as $analisis) {
                            ?>
                            <option value="<?= $analisis->id ?>"<?php
                            foreach ($_POST['items'] as $item) {
                                if ($item == $analisis->id) echo ' selected';
                            } ?>><?= $analisis->nombre ?></option>
                        <?php } ?>
                    </select>
                    <?php
                    foreach ($_POST['items'] as $row) {
                        ?>
                        <input type="hidden" name="itemsA[]" value="<?= $row; ?>"/>
                    <?php } ?>
                <?php } ?>
            </div>

<div class="pure-control-group">
                <label><a tabindex="6" href="https://aplicaciones.cmp.org.pe/conoce_a_tu_medico/index.php" target="_blank" title="click para abrir el buscador del Colegio Médico">CMP</a>: </label>
                <input type="text" tabindex="2" pattern='[0-9]{1,5}' name="cmp" placeholder="CMP" maxlength="5"
                       value="<?php if ($_POST['cmp']) echo str_pad($_POST['cmp'], 5, "0", STR_PAD_LEFT) ?>" required title="5 dígitos"/>
            </div>

            <div class="pure-control-group">
                <label>DNI: </label>
                <input tabindex="3" type="text" pattern='[0-9]{8,8}' name="dni" placeholder="DNI" maxlength="8"
                       value="<?php if ($_POST['dni']) echo str_pad($_POST['dni'], 8, "0", STR_PAD_LEFT); ?>"
                       title="8 dígitos"/>
                <input type="hidden" name="dniA" value="<?= $_POST['dni']; ?>"/>
            </div>

            <div class="pure-control-group">
                <label>Observaciones: </label>
                <input tabindex="4" type=text name="nota" placeholder="Observaciones"
                       value="<?= $_POST['nota'] ?>"/>
                <input type="hidden" name="items11[]" value="<?= $_POST['items']; ?>"/>
                <input type="hidden" name="user_id" value="<?= get_current_user_id() ?>">
                <input type="hidden" name="control" value="Orden">
                <input type="hidden" name="orden" value="<?= $_POST['orden']; ?>"/>
            </div>
            <div class="pure-control-group">
                <label></label>
                <input tabindex="5" type="submit" name="accion" value="Siguiente"
                       class="pure-button pure-button-primary"/>
            </div>

        </form>

    <?php
    }

public function getOrden() //mensaje de confirmacion de analisis registrados y el número de la nueva orden
{
//echo __METHOD__ . '<br>';

global $wpdb;
global $orden_id;
//=$wpdb->insert_id;
/* $ocado = $wpdb->get_results("SELECT analisis.nombre FROM analisis inner join prueba on prueba.analisis_id = analisis.id
inner join item on item.prueba_id=prueba.id where orden_id=" . $orden_id . " group by nombre order by analisis.nombre asc");*/
$ocado = $wpdb->get_results("SELECT  SQL_CACHE analisis.nombre, analisis.tarifa FROM analisis inner join item_analisis on item_analisis.analisis_id = analisis.id
    where orden_id=" . $orden_id . " group by nombre order by analisis.nombre asc");


//$wpdb->show_errors();
//$wpdb->print_error();
    ?>


    <!-- aqí estaba el css de la caja prefactura -->

<div id="caja">

    <h1>Prefactura <?=$orden_id?></h1>
    <table>
        <!--<tr><td align="right" colspan="2"></td> </tr>-->
        <tr><td><b>Orden Nº</b></td><td>:<b> <?= str_pad($orden_id, 8, "0", STR_PAD_LEFT); ?></b></td></tr>
        <tr><td><b>Paciente</b></td><td>: <?=ucwords($_POST['paciente'])?></td></tr>
        <tr><td><b>DNI</b></td><td>: <?=$_POST['dni_dni']?></td></tr>
        <tr><td><b>Edad</b></td><td>: <?php
        $date = new DateTime(utf8_decode(utf8_encode($_POST['natalicio'])));
        if (utf8_decode(utf8_encode($_POST['natalicio'])) != '0000-00-00') {
            $datetime1 = date_create($date->format('Y-m-d'));
            $datetime2 = date_create(date_i18n('Y-m-d'));
            $interval = date_diff($datetime1, $datetime2);
            echo $interval->format('%y años, %m meses, %d días');
        }?></td></tr>
        <tr><td><b>Toma de muestra</b></td><td>: <?=date_format(date_create($_POST["forden"]), 'd/m/Y h:i a')?></td></tr>
    </table>
    <p></p>


    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.6.0/tables-min.css"> -->


    <table class="pure-table pure-table-horizontal">
        <thead><tr><th>Análisis</th><th>Tarifa</th></tr> </thead>
        <tbody>

            <?php
            $total=0;
            foreach ($ocado as $row) {
                if($_POST['tarifa']=='s') $row->tarifa=0;
                $total=$total+$row->tarifa;
                ?>


                <tr><td><?=ucwords($row->nombre)?></td><td align="right">S/. <?=sprintf('%0.2f',$row->tarifa)?></td></tr>

                <?php
            } ?>


            <tr><td><b>Total</b></td><td align="right"><b>S/. <?=sprintf('%0.2f',$total)?></b></td></tr>
        </tbody>

    </table>
    <div class="pure-control-group"><p>
        <button onclick="window.print()" type="submit" id="boton" class="pure-button pure-button-primary" ><i
            class="fa fa-print" aria-hidden="true"></i> Imprimir (Ctrl+P)</button>
        </p>

<?php 
if( $_POST["accion"]!="Actualizar"){
?>

        <button onclick="history.go(-2)" class="pure-button">&lt;&lt; Nueva Orden</button>

<?php } ?>

    </div>
    </div>
    <link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url'); ?>/assets/prefactura.css" media="print" />
 <script type="text/javascript">
/* window.onload=function(){window.print()} */
</script>   
        <script type="text/javascript">

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }                
            </script>

    
<?php }






    public function prefactura() //mensaje de confirmacion de analisis registrados y el número de la nueva orden
    {
        //echo __METHOD__ . '<br>';

        global $wpdb;
        //global $_POST["orden"];//=$wpdb->insert_id;
        /* $ocado = $wpdb->get_results("SELECT analisis.nombre FROM analisis inner join prueba on prueba.analisis_id = analisis.id
          inner join item on item.prueba_id=prueba.id where orden_id=" . $orden_id . " group by nombre order by analisis.nombre asc");*/
        $ocado = $wpdb->get_results("SELECT SQL_CACHE  analisis.nombre, analisis.tarifa FROM analisis inner join item_analisis on item_analisis.analisis_id = analisis.id
    where orden_id=" . $_POST["orden"] . " group by nombre order by analisis.nombre asc");


        //$wpdb->show_errors();
        //$wpdb->print_error();
        ?>


        <style type="text/css">
            #caja {
                border: 2px solid #CBCBCB;
                /*para Firefox*/
                -moz-border-radius: 15px 15px 15px 15px;
                /*para Safari y Chrome*/
                -webkit-border-radius: 15px 15px 15px 15px;
                /*para IE */
                behavior:url(border.htc);
                /* para Opera */
                border-radius: 15px 15px 15px 15px;
                width: 75%;
                padding-left: 20px;
                padding-bottom: 20px;
                font-size: 15px;
            }
        </style>

        <div id="caja">


            <table>
                <tr><td align="right" colspan="2"><h1>Prefactura <?=$_POST["orden"]?></h1></td> </tr>
                <tr><td><b>Orden Nº</b></td><td>:<b> <?= str_pad($_POST["orden"], 8, "0", STR_PAD_LEFT); ?></b></td></tr>
                <tr><td><b>Paciente</b></td><td>: <?=ucwords($_POST['paciente'])?></td></tr>
                <tr><td><b>Edad</b></td><td>: <?php
                        $date = new DateTime(utf8_decode(utf8_encode($_POST['natalicio'])));
                        if (utf8_decode(utf8_encode($_POST['natalicio'])) != '0000-00-00') {
                            $datetime1 = date_create($date->format('Y-m-d'));
                            $datetime2 = date_create(date_i18n('Y-m-d'));
                            $interval = date_diff($datetime1, $datetime2);
                            echo $interval->format('%y años, %m meses, %d días');
                        }?></td></tr>
                <tr><td><b>Toma de muestra</b></td><td>: <?=date_format(date_create($_POST["forden"]), 'd/m/Y h:i a')?></td></tr>
            </table>
            <p></p>




            <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/0.6.0/tables-min.css"> -->
            <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.6/tables-min.min.css" integrity="sha512-rrStVxoFD4BDNtBEi6bALwnp/F2yfG0bbFiAobb3BiCvwf8jwmFslEXSJmbG4/F0pEBZxGAUXaLCqvGHYyxEkg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
            <table class="pure-table pure-table-horizontal">
                <thead><tr><th>Análisis</th><th>Tarifa</th></tr> </thead>
                <tbody>

                <?php
                $total=0;
                foreach ($ocado as $row) {
                    if($_POST['tarifa']=='s') $row->tarifa=0;
                    $total=$total+$row->tarifa;
                    ?>


                    <tr><td><?=ucwords($row->nombre)?></td><td align="right">S/. <?=sprintf('%0.2f',$row->tarifa)?></td></tr>

                    <?php
                } ?>


                <tr><td><b>Total</b></td><td align="right"><b>S/. <?=sprintf('%0.2f',$total)?></b></td></tr>
                </tbody>


            </table>
        </div>

    <?php }


























    public function Importar()
    {
        $fila = 1;
        if (($gestor = fopen("C:\\Users\\fe\\GoogleDrive\\goviringo\\vivilab\\este.csv", "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ',')) !== FALSE) {
                $numero = count($datos);
                echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
                $fila++;
                for ($c = 0; $c < $numero; $c++) {
                    echo $c . " " . str_replace("\n", "<br />", utf8_encode(trim($datos[$c]))) . ",<br />\n";
                }
            }
            fclose($gestor);
        }
    }


public function BarcodePrint(){
if (comprobar_si_orden_existe($_POST['orden']) != 0)
{

global $wpdb;
    $row = $wpdb->get_var('SELECT SQL_CACHE paciente.nombre FROM paciente inner join orden on orden.paciente_dni=paciente.dni WHERE orden.id='.$_POST['orden']);

$o=str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT);
$p=utf8_decode( mb_convert_case(normalize_whitespace( $row ), MB_CASE_UPPER, "UTF-8")); 

require 'tfpdf.php';
        // $pdf = new tFPDF();  //header("Content-Encoding: None", true);
        $pdf = new tFPDF('L','mm',array(50.00,25.00));
        $pdf->SetMargins(0, 2, 0);
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 0);
        // $data = $pdf->LoadData();
        // $pdf->SetFont('helvetica', '', 9);
        //$pdf->SetMargins(10,65);
        // $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Helvetica','',7);
        // $pdf->Ln(0);
        $pdf->MultiCell(0,2.5,$p,0,'C');
        // $pdf->Image('https://barcode.tec-it.com/barcode.ashx?data='.str_pad($_POST['orden'], 8, '0', STR_PAD_LEFT).'&code=Code128&unit=Fit&dpi=300&imagetype=Png&rotation=0&color=%23000000&bgcolor=%23ffffff',0,0,-300,'PNG');
       // $pdf->Image('https://barcode.tec-it.com/barcode.ashx?data='.$o.'&code=Code128&dpi=160&imagetype=Png', 12.5, 7, 25, 0, 'PNG');

//la línea de abjo fallo 3/6/2026
//$pdf->Image('https://free-barcode.com/BarcodeOnline/barcode.asp?bc1='.$o.'&bc2=8&bc3=6&bc4=3.5&bc5=1&bc6=1&bc7=Tahoma&bc8=15&bc9=2', 12.5, 7, 25, 0, 'PNG');


//le agregue dos servicios al mismo tiempo para reducir las caidas 22/6/26
//$pdf->Image('https://barcode.tec-it.com/barcode.ashx?data='.$o.'&code=Code128&dpi=132&imagetype=Png', 12.5, 7, 25, 0, 'PNG');


// 22/6/26 buen servicio al parecer pero no se puede manipular sus diemnsiones, si vuelven a fallar los otros servicios cambiar por este "https://barcode.orcascan.com/?data=" . $o . "&type=code128&format=png&text=" . $o . "&padding=0&background=none&fontsize=50"


$qrs = [
    'https://t-x-m.com/barcode.asp?bc1='.$o.'&bc2=8&bc3=160&bc4=101&bc5=1&bc6=1&bc7=Tahoma&bc8=15&bc9=3'
];

$src_qr = $qrs[mt_rand(0, 0)];


 $pdf->Image($src_qr, 12.5, 7, 25, 0, 'PNG');










        // $pdf->Image('https://barcode.tec-it.com/barcode.ashx?data='.$o.'&code=Code128&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff', 12.5, 7, 25, 0, 'GIF');
        //$pdf->cMargin = 0;
        // $pdf->IncludeJS("print('true');");
        $pdf->Output('barcode_'.str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) . '.pdf', 'I');
        
    










} else {
                
    $_POST['accion']='Reportes';
    get_header();
    info($i = "Reportes, buscar orden.");
    $this->getReporte();
}

}







public function BarcodePrint2()
{
    if (comprobar_si_orden_existe($_POST['orden']) != 0) {
        global $wpdb;
        $row = $wpdb->get_var('SELECT SQL_CACHE paciente.nombre FROM paciente inner join orden on orden.paciente_dni=paciente.dni WHERE orden.id=' . $_POST['orden']);

        $o = str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT);
        $p = utf8_decode(mb_convert_case(normalize_whitespace($row), MB_CASE_UPPER, "UTF-8"));

        require 'tfpdf.php';
        $pdf = new tFPDF('L', 'mm', array(50.00, 25.00));
        $pdf->SetMargins(0, 2, 0);
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->MultiCell(0, 2.5, $p, 0, 'C');

        $qrs = [
        
            'https://barcode.tec-it.com/barcode.ashx?data=' . $o . '&code=Code128&imagetype=Png&onerror=Ignore'
        ];

        $src_qr = $qrs[mt_rand(0, 0)];

        $pdf->Image($src_qr, 12.5, 7, 25, 0, 'PNG');

        $pdf->Output('barcode_' . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) . '.pdf', 'I');
    } else {
        $_POST['accion'] = 'Reportes';
        get_header();
        info($i = "Reportes, buscar orden.");
        $this->getReporte();
    }
}










public function getImprimible($logo){
if (comprobar_si_orden_existe($_POST['orden']) != 0) 

    $this->getImprimible_orden_verificada($logo);
                else {
                
                $_POST['accion']='Reportes';
                get_header();
                info($i = "Reportes, buscar orden.");
                $this->getReporte();}

}




    public function getImprimible_orden_verificada($logo)
    {require 'pdf.php';
        $pdf = new PDF();  //header("Content-Encoding: None", true);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 55);
// Títulos de las columnas
// Carga de datos
        $data = $pdf->LoadData();
        $pdf->SetFont('helvetica', '', 9);
//$pdf->SetMargins(10,65);
        $pdf->AddPage('P', 'A4');
        $pdf->ImprovedTable($data);
//$pdf->cMargin = 0;
        $pdf->AliasNbPages();
   // ob_end_clean();
        //if (isset($logo) && $logo!= 'N') {
      /*  switch ($logo) {
            case 'V':
                $pdf->IncludeJS("print('true');");
                $pdf->Output();
                break;
            case 'U':
                $pdf->IncludeJS("print('true');");
                $pdf->Output();
                break;
            case 'N':
                $pdf->IncludeJS("print('true');");
                $pdf->Output();
                break;
        }*/

global $local;
        $local=$logo;
        if ($logo=='N') {
            $pdf->IncludeJS("print('true');");
            $pdf->Output();
        } else {
            $pdf->Output(str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) . '.pdf', 'D');
            // echo "<script language='javascript'>window.open('".str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) .".pdf','_blank','');</script>";
        }
    }






}
