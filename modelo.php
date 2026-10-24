<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */
class Modelo
{

public function insert_historial($e){    
    global $wpdb;
    $wpdb->insert( 
    'orden_historial', 
    array( 
        'orden' => $_POST["orden"], 
        'usuario' => get_current_user_id(), 
        'evento' => $e 
    ), 
    array( 
         
    ) 
);
}



    public function updateOrden() //eliminar agregar pruebas a las ordenes
    {

        global $paciente_dni;
        global $doctor_cmp;

        if ($_POST['dni']!='') $paciente_dni=$_POST['dni'];
        if ($_POST['cmp']!='') $doctor_cmp=$_POST['cmp'];

        global $orden_id;
        $orden_id = $_POST["orden"];
        global $wpdb;
        $wpdb->update(
            'orden',
            array('user_id' => get_current_user_id(),
                'paciente_dni' => $paciente_dni,//$_POST["dni"],
                'doctor_cmp' => $doctor_cmp,//$_POST["cmp"],
                'fecha' => $_POST["forden"],
                'tarifa' => $_POST["tarifa"],
               // 'dni_dni' => $_POST["dni_dni"],
                'nota' => trim($_POST["nota"])),
            array('id' => $_POST['orden'])
        );//$wpdb->show_errors();$wpdb->print_error();


        $ai = array_intersect($_POST['itemsA'], $_POST['items']);

        $ad = array_diff($_POST['itemsA'], $ai); //print_r($ad);
        foreach ($ad as $item) {//echo 'i '.$item;

            $wpdb->delete('item_analisis', array('orden_id' => $orden_id, 'analisis_id' => $item)); //$wpdb->show_errors(); //$wpdb->print_error();

            $pruebas = $wpdb->get_results("SELECT  SQL_CACHE id FROM prueba where analisis_id=" . $item); //$wpdb->show_errors(); //$wpdb->print_error();
            foreach ($pruebas as $prueba) {//echo ' p '.$prueba->id;
                $wpdb->delete('item', array('orden_id' => $orden_id, 'prueba_id' => $prueba->id)); //$wpdb->show_errors(); //$wpdb->print_error();
            }
        }

        $ad = array_diff($_POST['items'], $ai); //print_r($ad);
        foreach ($ad as $item) {//echo 'i '.$item;
            $wpdb->insert('item_analisis', array(
                'orden_id' => $orden_id,
                'analisis_id' => $item
            )); //$wpdb->show_errors(); //$wpdb->print_error();

        }

   $this->insert_historial($e='E'); //E del botón editar orden
}

    public function updatePacienteDoctor()
    {
        global $wpdb;



        $wpdb->update(
            'doctor',
            array('nombre' => ucwords(strtolower(trim($_POST['medico']))),),
            array('cmp' => $_POST['cmp'])
        );

        $wpdb->update(
            'paciente',
            array('nombre' => ucwords(strtolower(trim($_POST['paciente']))),
                'dni_dni' => trim($_POST['dni_dni']),
                'sexo' => strtolower($_POST['sexo']),
                'natalicio'=>$_POST['natalicio']
                ),
            array('dni' => $_POST['dni'])
        );

  $this->insert_historial($e='9'); 
   }

public function EliminarAnalisis(){
    global $wpdb;
    $cont=0;

    $pruebas = $wpdb->get_results("SELECT SQL_CACHE  id FROM prueba where analisis_id=" . $_POST['analisis_id']);

    foreach ($pruebas as $prueba) {
        $row = $wpdb->get_row("
            SELECT  SQL_CACHE prueba_id
            FROM item where prueba_id=" . $prueba->id);
        if($row) $cont=$cont+1;

    }
    

    if($cont==0) {

        foreach ($pruebas as $prueba) {

            $wpdb->delete('prueba', array('id' => $prueba->id));
        }
        $wpdb->delete('analisis', array('id' => $_POST['analisis_id']));
        info($i = "Analisis eliminado.");
    }

}

public function agregaranalisis(){


    global $wpdb;
    $wpdb->insert('analisis', array(
                    'nombre' => str_replace('  ',' ',trim($_POST['nanalisis'])),
                    'area' => trim($_POST['narea'])
                ));
    $_POST['analisis_id']=$wpdb->insert_id;


    $wpdb->insert('prueba', array(
        'analisis_id' => $_POST['analisis_id'],
        'numerodeorden' => 1,
        'prueba' => str_replace('  ',' ',trim($_POST['nanalisis']))
    ));


}


public function setCatalogo(){
global $wpdb;

if(!empty($_POST['id'])){
foreach ( $_POST['id'] as $id ) {
    //echo $id;
$wpdb->update(
                'prueba',
                array('numerodeorden' => $_POST['no'.$id],
                        'vn' => trim($_POST['vri'.$id]),
                        'vmax' => preg_replace('/\s+/', '',$_POST['vmax'.$id]),
                        'vmin' => preg_replace('/\s+/', '',$_POST['vmin'.$id]),
                       // 'vm' => trim($_POST['vrm'.$id]),
                       // 'vh' => trim($_POST['vrh'.$id]),
                        'unidades' => trim($_POST['unidades'.$id]),
                        'metodo' => trim($_POST['metodo'.$id])
            ),
                array('id' => $id)
            );
//$wpdb->show_errors();$wpdb->print_error();    
}} 

$wpdb->update(
                'analisis',
                array('area' => $_POST['area'],'tarifa' => $_POST['tarifa']),
                array('id' => $_POST['analisis_id'])
            );

if(trim($_POST['ordernew']) && trim($_POST['newprueba'])) {
    
    $wpdb->insert('prueba', array(
        'analisis_id' => $_POST['analisis_id'],
                    'numerodeorden' => trim($_POST['ordernew']),
                    'prueba' => str_replace('  ',' ',trim($_POST['newprueba'])),
                        ));
}
}


public function setEliminarPrueba(){
   global $wpdb;

$row = $wpdb->get_row("
            SELECT  SQL_CACHE prueba_id
            FROM item where prueba_id=" . $_POST['id']);
if(!$row) {$wpdb->delete('prueba', array('id' => $_POST['id']));
 info($i = "Prueba eliminada.");
}
else info($i = "No se puede eliminar una prueba utilizada en alguna orden.");

//$wpdb->show_errors();$wpdb->print_error();    
}



// public function EliminarUsuario(){
//    global $wpdb;

// $row = $wpdb->get_row("
//             SELECT user_id
//             FROM orden where user_id=" . $_POST['ID']);
// if(!$row) {$wpdb->delete($wpdb->users, array('ID' => $_POST['ID']));
//  info($i = "Usuario eliminado.");
// }
// else info($i = "No se puede eliminar un usuario con ordenes registradas.");

// //$wpdb->show_errors();$wpdb->print_error();    
// }




public function EliminarUsuario(){
   global $wpdb;

$row = $wpdb->get_row("
            SELECT  SQL_CACHE  user_id
            FROM orden where user_id=" . $_POST['ID']);
if(!$row) {$wpdb->delete($wpdb->users, array('ID' => $_POST['ID']));
 
}
else $wpdb->update(
            'wp_users',
            array('user_status' => 9, 'user_pass' => wp_generate_password()),
            array('ID' => $_POST['ID'])
        );
info($i = "Usuario eliminado.");
//$wpdb->show_errors();$wpdb->print_error();    
}


public function setUsuario(){


if(isset($_POST['newpass']))  wp_set_password ( trim($_POST['newpass']) , $_POST['userID']  );

}





public function setUsuarios(){
    global $wpdb;
if(trim($_POST['newUser']) && trim($_POST['passNewUser'])) {

    $wpdb->insert($wpdb->users, array(
                    'user_login' => str_replace('  ',' ',trim($_POST['newUser'])),
                    'user_pass' => wp_hash_password(trim($_POST['passNewUser'])),
                ));
}


$blogusers = get_users( array( 'fields' => array( 'ID' ) ) );
foreach ( $blogusers as $user ) {
    $newpass=trim($_POST['newpass'.$user->ID]);
if($newpass!=''){
  //  echo $newpass,' .. ';
    wp_set_password ( $newpass , $user->ID  );
    //$wpdb->show_errors();$wpdb->print_error();
    }
}


}
    public function NuevoPacienteDoctor()
    {
        global $wpdb;


$medico=ucwords(strtolower(trim($_POST['medico'])));
       // echo $medico;
        if ($_POST['cmp']=='') {
            global $doctor_cmp;
            $wpdb->insert('doctor', array(
                'nombre' => $medico
            ));
            //$wpdb->show_errors();$wpdb->print_error();
            $doctor_cmp = $wpdb->insert_id;

        }

        $paciente=ucwords(strtolower(trim($_POST['paciente'])));
      //  echo $paciente;
        if ($_POST['dni']=='') {
            global $paciente_dni;
            $_POST['dni_dni']=trim($_POST['dni_dni']);
            if($_POST['dni_dni']==0)$_POST['dni_dni']=NULL;
        $wpdb->insert('paciente', array(
            'nombre' => $paciente,
            'sexo'=>strtolower($_POST['sexo']),
            'natalicio'=>$_POST['natalicio'],
            'dni_dni' => $_POST['dni_dni']

        ));
        $paciente_dni = $wpdb->insert_id;
       // $wpdb->show_errors();$wpdb->print_error();

    } else {$wpdb->update(
            'paciente',
            array(
                'sexo' => strtolower($_POST['sexo']),
                'dni_dni' => trim($_POST['dni_dni']),
                'natalicio'=>$_POST['natalicio']
            ),
            array('dni' => $_POST['dni'])
        );//$wpdb->show_errors();$wpdb->print_error();
        }

    }

    public function setInsertarActualizarDatosPacienteDoctor()
    {
        global $wpdb;
//$wpdb->query('INSERT INTO doctor (nombre) VALUES ("' . ucwords(strtolower(trim($_POST['medico']))) . '")"');
        //$wpdb->query('INSERT INTO doctor (nombre) VALUES ("' . ucwords(strtolower(trim($_POST['medico']))) . '") ON DUPLICATE KEY UPDATE nombre="' . ucwords(strtolower(trim($_POST['medico']))) . '"'); //$wpdb->show_errors();//$wpdb->print_error();
        $wpdb->query('INSERT INTO doctor (cmp, nombre) VALUES (' . $_POST['cmp'] . ', "' . ucwords(strtolower(trim($_POST['medico']))) . '") ON DUPLICATE KEY UPDATE nombre="' . ucwords(strtolower(trim($_POST['medico']))) . '"'); 

        $wpdb->show_errors();
        $wpdb->print_error();
        
        //$_POST["cmp"]=$wpdb->insert_id;

        if ($_POST['dniA']) {
            $wpdb->update(
                'paciente',
                array('dni' => $_POST['dni'],),
                array('dni' => $_POST['dniA'])
            );

        }

//$wpdb->query('INSERT INTO paciente (nombre, sexo, natalicio) VALUES ( "' . ucwords(strtolower(trim($_POST['paciente']))) . '", "' . strtolower($_POST['sexo']) . '", "' . $_POST['natalicio'] . '")"');
        $wpdb->query('INSERT INTO paciente (dni_dni, dni, nombre, sexo, natalicio) VALUES (' . $_POST['dni_dni'] . ', ' . $_POST['dni'] . ', "' . ucwords(strtolower(trim($_POST['paciente']))) . '", "' . strtolower($_POST['sexo']) . '", "' . $_POST['natalicio'] . '") ON DUPLICATE KEY UPDATE nombre="' . ucwords(strtolower(trim($_POST['paciente']))) . '", sexo="' . strtolower($_POST['sexo']) . '", natalicio="' . $_POST['natalicio'] . '"'); //$wpdb->show_errors();//$wpdb->print_error();
        //$wpdb->query('INSERT INTO paciente ( nombre, sexo, natalicio) VALUES ( "' . ucwords(strtolower(trim($_POST['paciente']))) . '", "' . strtolower($_POST['sexo']) . '", "' . $_POST['natalicio'] . '") ON DUPLICATE KEY UPDATE nombre="' . ucwords(strtolower(trim($_POST['paciente']))) . '", sexo="' . strtolower($_POST['sexo']) . '", natalicio="' . $_POST['natalicio'] . '"'); 

        $wpdb->show_errors();
        $wpdb->print_error();
       
       // $_POST["dni"]=$wpdb->insert_id;
    }

    public function setActualizarDatosorden() //eliminar agregar pruebas a las ordenes
    {
        global $orden_id;
        $orden_id = $_POST["orden"];
        global $wpdb;
        $wpdb->update(
            'orden',
            array('user_id' => get_current_user_id(),
                'paciente_dni' => $_POST["dni"],
                'doctor_cmp' => $_POST["cmp"],
                'fecha' => $_POST["forden"],
                'nota' => trim($_POST["nota"])),
            array('id' => $_POST['orden'])
        );//$wpdb->show_errors();//$wpdb->print_error();

        //    echo 'Orden: ' . $_POST["orden"] . ' actualizada.';



        $ai = array_intersect($_POST['itemsA'], $_POST['items']);

        $ad = array_diff($_POST['itemsA'], $ai); //print_r($ad);
        foreach ($ad as $item) {//echo 'i '.$item;

            $wpdb->delete('item_analisis', array('orden_id' => $orden_id, 'analisis_id' => $item)); //$wpdb->show_errors(); //$wpdb->print_error();

            $pruebas = $wpdb->get_results("SELECT SQL_CACHE  id FROM prueba where analisis_id=" . $item); //$wpdb->show_errors(); //$wpdb->print_error();
            foreach ($pruebas as $prueba) {//echo ' p '.$prueba->id;
                $wpdb->delete('item', array('orden_id' => $orden_id, 'prueba_id' => $prueba->id)); //$wpdb->show_errors(); //$wpdb->print_error();
            }
        }


        /*$ad = array_diff($_POST['itemsA'], $ai); //print_r($ad);
        foreach ($ad as $item) {//echo 'i '.$item;
            $pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item); //$wpdb->show_errors(); //$wpdb->print_error();
            foreach ($pruebas as $prueba) {//echo ' p '.$prueba->id;
                $wpdb->delete('item', array('orden_id' => $orden_id, 'prueba_id' => $prueba->id)); //$wpdb->show_errors(); //$wpdb->print_error();
            }
        }*/



        $ad = array_diff($_POST['items'], $ai); //print_r($ad);
        foreach ($ad as $item) {//echo 'i '.$item;
           // $pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item); //$wpdb->show_errors(); //$wpdb->print_error();
            //foreach ($pruebas as $prueba) { // echo ' p '.$prueba->id;
                $wpdb->insert('item_analisis', array(
                    'orden_id' => $orden_id,
                    'analisis_id' => $item
                )); //$wpdb->show_errors(); //$wpdb->print_error();
            //}
        }





        /*$ad = array_diff($_POST['items'], $ai); //print_r($ad);
        foreach ($ad as $item) {//echo 'i '.$item;
            $pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item); //$wpdb->show_errors(); //$wpdb->print_error();
            foreach ($pruebas as $prueba) { // echo ' p '.$prueba->id;
                $wpdb->insert('item', array(
                    'orden_id' => $orden_id,
                    'prueba_id' => $prueba->id,
                )); //$wpdb->show_errors(); //$wpdb->print_error();
            }
        }*/







        /*if ($_POST['sexo1'] != $_POST['sexo']) {
            $wpdb->update(
                'item',
                array('valores' => ''),
                array('orden_id' => $_POST['orden'])
            );
//$wpdb->show_errors(); //$wpdb->print_error();
        }*/

     $this->insert_historial($e='8'); //E
 }


    public function NuevaOrden()
    {

        global $paciente_dni;
        global $doctor_cmp;

        if ($_POST['dni']!='') $paciente_dni=$_POST['dni'];
        if ($_POST['cmp']!='') $doctor_cmp=$_POST['cmp'];

        global $orden_id;

        global $wpdb;
        $wpdb->insert('orden', array(
            'user_id' => get_current_user_id(),
            'paciente_dni' => $paciente_dni,//$_POST['dni'],
            'doctor_cmp' => $doctor_cmp,//$_POST["cmp"],
            'nota' => trim($_POST["nota"]),
            'fecha' => $_POST["forden"],//date_i18n('Y-m-d h:i:s')
            'tarifa' => $_POST["tarifa"]
        )); //$wpdb->show_errors();$wpdb->print_error();
       // $wpdb->show_errors();$wpdb->print_error();
        $orden_id = $wpdb->insert_id;


        //insertar id de prueas en los items de la orden


        foreach ($_POST['items'] as $item_analisis) {
            //$pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item);//$wpdb->show_errors();//$wpdb->print_error();
            //foreach ($pruebas as $prueba) {
            $wpdb->insert('item_analisis', array(
                'orden_id' => $orden_id,
                'analisis_id' => $item_analisis,
            ));       //$wpdb->show_errors();//$wpdb->print_error();
            //}
        }

$_POST['orden']=$orden_id;
    $this->insert_historial($e='7'); 
     }

    public function setInsertarDatosNuevaDatosorden()
    {


        global $orden_id;
        global $wpdb;
        $wpdb->insert('orden', array(
            'user_id' => get_current_user_id(),
            'paciente_dni' => $_POST['dni'],
            'doctor_cmp' => $_POST["cmp"],
            'nota' => trim($_POST["nota"]),
            'fecha' => $_POST["forden"]//date_i18n('Y-m-d h:i:s')
        )); //$wpdb->show_errors();//$wpdb->print_error();
        $orden_id = $wpdb->insert_id;

        //insertar id de prueas en los items de la orden


        foreach ($_POST['items'] as $item_analisis) {
            //$pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item);//$wpdb->show_errors();//$wpdb->print_error();
            //foreach ($pruebas as $prueba) {
                $wpdb->insert('item_analisis', array(
                    'orden_id' => $orden_id,
                    'analisis_id' => $item_analisis,
                ));       //$wpdb->show_errors();//$wpdb->print_error();
            //}
        }

        /*foreach ($_POST['items'] as $item) {
            $pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item);//$wpdb->show_errors();//$wpdb->print_error();
            foreach ($pruebas as $prueba) {
                $wpdb->insert('item', array(
                    'orden_id' => $orden_id,
                    'prueba_id' => $prueba->id,
                ));       //$wpdb->show_errors();//$wpdb->print_error();
            }
        }*/
    $this->insert_historial($e='6'); 
}

    public function setOrden()
    {
        //echo __METHOD__ . '<br>';
        // global $orden_id;
        //if (!$_POST['dni']) $_POST['dni'] = rand(0, 9999999);
        //if (!$_POST['cmp']) $_POST['cmp'] = rand(0, 99999);

        if ($_POST['orden']!='') {
          //  echo 'actualizar orden';
/*
            $this->setActualizarDatosorden();
            $this->setInsertarActualizarDatosPacienteDoctor();*/

            $this->NuevoPacienteDoctor();
            $this->updateOrden();
            //$this->updatePacienteDoctor();


        } else {

            /*$this->setInsertarActualizarDatosPacienteDoctor();
            $this->setInsertarDatosNuevaDatosorden();*/
         //   echo 'nueva orden';
            $this->NuevoPacienteDoctor();
            $this->NuevaOrden();





        }

        /*

               //insertar id de prueas en los items de la orden
                      foreach ($_POST[items] as $item) {
                    $pruebas = $wpdb->get_results("SELECT id FROM prueba where analisis_id=" . $item);
                    //$wpdb->show_errors();//$wpdb->print_error();
                    foreach ($pruebas as $prueba) {
                        $wpdb->insert('item', array(
                            'orden_id' => $orden_id,
                            'prueba_id' => $prueba->id,
                        ));
                        //$wpdb->show_errors();//$wpdb->print_error();
                    }

                }
        //eliminar pruebas de las items de la orden
                if ($_POST[itemsA]) {
                    $resultados = array_diff($_POST[itemsA], $_POST[items]);
               // print_r($_POST['itemsA']).' ';
               // print_r($_POST['items']).' ';
                    print_r($resultados);
                    if ($resultados){
                    foreach ($resultados as $re) {
                        $wpdb->delete('item', array('orden_id' => $orden_id, 'prueba_id' => $re), array('%d', '%d'));
                        //$wpdb->show_errors();//$wpdb->print_error();
                    }}
                }
                */
        unset($_POST['itemsA']);
        unset($_POST['itemsA']);


        //$wpdb->show_errors();//$wpdb->print_error();

   //$this->insert_historial($e='5'); 
    }


    public function setResultado() //inserta y actualiza resultados
    {  
        //echo __METHOD__ . '<br>';

        //  echo "sexo-> ".$_POST[sexo]." <--";
        //if() $valores="vn";
        if(isset($_POST['sexo']))
        if ($_POST['sexo'] == 'i') $val = "vn";
        else {
            if ($_POST['sexo'] == 'm') $val = "vm";
            else $val = "vh";
        }

        global $wpdb;
        if(isset($_POST['prueba_id'])){
        foreach ($_POST['prueba_id'] as $value) {
            if($_POST[$value]!='') {

                //if ($_POST[$value]) { permite borrar
                $wpdb->query('INSERT INTO item (prueba_id, orden_id, resultado, valores,vmax,vmin)
                            VALUES 
                            (
                            ' . $value . ' , 
                            ' . $_POST['orden'] . ',
                            "' . trim($_POST[$value]) . '",
                            "' . trim($_POST['valores' . $value]) . '",
                            "' . preg_replace('/\s+/', '',$_POST['vmax' . $value]) . '",
                            "' . preg_replace('/\s+/', '',$_POST['vmin' . $value]) . '"
                            )
                            ON DUPLICATE KEY UPDATE 
                            resultado="' . trim($_POST[$value]) . '", 
                            valores="' . trim($_POST['valores' . $value]) . '",
                            vmax="' . preg_replace('/\s+/', '',$_POST['vmax' . $value]) . '",
                            vmin="' . preg_replace('/\s+/', '',$_POST['vmin' . $value]) . '"
                            '
                        );
               // $wpdb->show_errors();$wpdb->print_error();



                // } end if value
            } else {$wpdb->delete('item', array('prueba_id' => $value , 'orden_id' => $_POST['orden'])); 
            //$wpdb->show_errors();$wpdb->print_error();
              }


if($_POST['vmin' . $value]=='.') $_POST['vmin' . $value]='';
if($_POST['vmax' . $value]=='.') $_POST['vmax' . $value]='';

            $wpdb->update(
                'prueba',
                array(
                    'unidades' => trim($_POST['unidades' . $value]),  // string
                    $val => trim($_POST['valores' . $value]),
                    'metodo' => trim($_POST['metodo' . $value]),   // integer (number)
                    'vmin' => preg_replace('/\s+/', '',$_POST['vmin' . $value]),
                    'vmax' => preg_replace('/\s+/', '',$_POST['vmax' . $value]),
                ),
                array('id' => $value)
            ); //$wpdb->show_errors();//$wpdb->print_error();
            $wpdb->update(
                'orden',
                array('user_id' => get_current_user_id() ),
                array('id' => $_POST['orden'])
            );

        }

        $this->insert_historial($e='4'); 
    }
    }




/*
    public function setServicio()
    {
        //echo __METHOD__ . '<br>';

        global $wpdb;
        $wpdb->insert('servicios', array(
            'analisis_id' => $_POST["servicio"],
            'user_dni' => $_POST["user_id"],
        ));
        // 	$wpdb->show_errors();
        // $wpdb->print_error();
    }
*/
    /*public function delServicio()
    {
        //echo __METHOD__ . '<br>';
        global $wpdb;
        $wpdb->delete('servicios', array('id' => $_POST[id]), array('%d'));
    }*/

   
    





}

// 666666
// http://sql16.hostinger.mx/phpmyadmin/index.php?db=u297235866_labor&token=4611886737187527b82747349ed702f3


//$wpdb->query('INSERT INTO paciente (dni, nombre) VALUES ('.$_POST[dni].', "'.$_POST[paciente].'")	ON DUPLICATE KEY UPDATE nombre="'.$_POST[paciente].'"');
//$wpdb->query("INSERT INTO doctor (cmp, nombre) VALUES (2, 'insert') ON DUPLICATE KEY UPDATE nombre='update'");

/*
$wpdb->insert('paciente', array(
    'dni' => $_POST["dni"],
    'nombre' => $_POST["nombre"],
    'sexo' => $_POST["sexo"],
    'natalicio' => $_POST["natalicio"],
    ));

$wpdb->insert('doctor', array(
    'cmp' => $_POST["cmp"],
    'nombre' => $_POST["nombre"],
                ));
*/


