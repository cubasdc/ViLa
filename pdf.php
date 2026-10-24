<?php require('tfpdf.php');class PDF extends tFPDF
{


    var $javascript;
    var $n_js;

    function IncludeJS($script)
    {
        $this->javascript = $script;
    }

    function _putjavascript()
    {
        $this->_newobj();
        $this->n_js = $this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) ' . ($this->n + 1) . ' 0 R]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS ' . $this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources()
    {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog()
    {
        parent::_putcatalog();
        if (!empty($this->javascript)) {
            $this->_out('/Names <</JavaScript ' . ($this->n_js) . ' 0 R>>');
        }
    }


// Cargar los datos
    function LoadData()
    {
        global $wpdb;
        $ocado = $wpdb->get_results("
            SELECT  SQL_CACHE area, analisis.id as analid, prueba.id, nombre, prueba.prueba, resultado, unidades, item.valores as valores, vn,vm,vh,metodo,item.vmax as ivmax,item.vmin as ivmin
            FROM item
            inner join prueba on item.prueba_id = prueba.id
            inner join analisis on analisis.id = prueba.analisis_id
            where item.orden_id=" . $_POST['orden'] . " and resultado <> '' order by analisis.area, analisis.nombre, prueba.numerodeorden asc");
        //$wpdb->show_errors();//$wpdb->print_error();

        return $ocado;
    }


// Una tabla más completa
    function ImprovedTable_este($data)
    {

        $w = array(80, 40, 25, 55);

        $this->SetLineWidth(0.001);
        $this->SetFont('helvetica', '', 9);
        
        // Datos
        $area = '';
        $temp = '';
        $h = 5;
        $hl = 1;
        $cont = 0;
        $y=0;
        $sub = '';

        foreach ($data as $rowP) {
            //color interlineado
            $cont = $cont + 1;
            if ($cont % 2 == 0) {
                $this->SetFillColor(240);
            } else {
                $this->SetFillColor(255);
            }

            if ($rowP->resultado == '.') {
                $rowP->resultado = '';
                $sub = '';                
            } //else $sub = ' ';

            if ($area != '' && $area != $rowP->area) {
                if (is_numeric($rowP->area) && $y<=227) {
                    $this->Ln(3);
                    $this->Line(5, $y, 205, $y);
                    //$this->Ln();
                } else $this->AddPage('P', 'A4');
                //echo $this->Cell(0, 5, $y,'',2,'',true);
            }


            if ($rowP->metodo <> "")  $metodo = " (" . $rowP->metodo . ")";      else         $metodo = "";

            if ($temp != $rowP->analid) {

                if ($rowP->nombre == $rowP->prueba) {
                    $this->Cell($w[0], $h, $sub . utf8_decode($rowP->prueba . $metodo), '', 0, '', true);
                    $this->MCell($w[1], $h, utf8_decode($rowP->resultado), '', 0, 'R', true);
                    $this->Cell($w[2], $h, $rowP->unidades, '', 0, '', true);
                    $this->MultiCell($w[3], $h, utf8_decode(str_replace('—', '-', $rowP->valores)), '', '', true);
                  //  $this->Ln($hl);
                } else {
                    $this->SetFont('helvetica', 'B');
                    $this->Cell($w[0], $h, utf8_decode($rowP->nombre . $metodo), '', 0, '', true);
                    $this->SetFont('helvetica', '');
                    $this->MCell($w[1], $h, '', '', 0, 'R', true);
                    $this->Cell($w[2], $h, '', '', 0, '', true);
                    $this->MultiCell($w[3], $h, '', '', '', true);
                  //  $this->Ln($hl);


                    $this->Cell($w[0], $h, $sub . utf8_decode($rowP->prueba . $metodo), '', 0, '', true);
                    $this->MCell($w[1], $h, utf8_decode($rowP->resultado), '', 0, 'R', true);
                    $this->Cell($w[2], $h, $rowP->unidades, '', 0, '', true);
                    $this->MultiCell($w[3], $h, utf8_decode(str_replace('—', '-', $rowP->valores)), '', '', true);
                  //  $this->Ln($hl);
                }

            } else {

                $this->Cell($w[0], $h, $sub . utf8_decode($rowP->prueba . $metodo), '', 0, '', true);
                $this->MCell($w[1], $h, utf8_decode($rowP->resultado), '', 0, 'R', true);
                $this->Cell($w[2], $h, $rowP->unidades, '', 0, '', true);
                $this->MultiCell($w[3], $h, utf8_decode(str_replace('—', '-', $rowP->valores)), '', '', true);
             //   $this->Ln($hl);


            }

            $temp = $rowP->analid;
            $area = $rowP->area;
            $y = $this->GetY()+1;
            $sub = ''; //dejar de usar esto


            $nb=$this->NbLines($w[1],utf8_decode($rowP->resultado));
//$hv=$this->NbLines($w[3],$rowP->valores);
//$nb=max($hr,$hv);
            $hs=5*($nb);
            $this->SetY($this->GetY()+$hs);
//$this->Ln($hs);

        }
        // Línea de cierre    $this->Cell(array_sum($w),0,'','T');

    }

function logo_vivilab_dibujado(){        $this->SetTextColor(221,46,76);
        $this->SetFont('helvetica', 'B', 46);
        $this->SetXY(29.7,21.3);
        $this->_out(sprintf('BT %.2F Tz ET',82.5));
        $this->Cell(0,0,'ViviLab',0,0,'');
        $this->SetTextColor(7,128,0);
        $this->SetXY(53.5,21.3);
        $this->SetTextColor(47,70,132);
        $this->Cell(0,0,'Lab',0,0,'');
    

        $this->_out(sprintf('BT %.2F Tz ET',55));
        $this->SetFont('helvetica', 'B', 54);
        $this->SetXY(9.5,21.5);
        $this->SetTextColor(221,46,76);
        $this->Cell(0,0,'V',0,0,'');

        $this->SetXY(16,26.5);
        $this->SetTextColor(47,70,132);
        $this->Cell(0,0,'L',0,0,'');

        $this->SetXY(29.7,30);
        $this->SetFont('helvetica', 'I', 10);
        $this->_out(sprintf('BT %.2F Tz ET',75));
        $this->Cell(0,0,'Seguridad y confianza en tus resultados',0,0,'');

        $this->SetLineWidth(0.8);
        $this->SetDrawColor(47,70,132);
        $this->Line(10.5,10.8,22.5,10.8);
        $this->Line(22.7,10.8,22.7,18.1);
        $this->Line(22.8,18.7,28.9,31.5);
        $this->Line(28.9,31.9,27.1,34.7);
        $this->Line(10.5,34.9,26.8,34.9);

        $this->_out(sprintf('BT %.2F Tz ET',100));
        $this->SetLineWidth(0.1);
        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(0,0,0);

}

// Cabecera de página
    function Header()
    {
        $this->SetLineWidth(0.2);

        // Logo     //$this->Image(site_url().'/wp-content/themes/vivilab/img/logopdf.png', 10, 10, 80, 0, 'PNG');

        if ($_POST["accion"] == 'pdfv' || $_POST["accion"] == 'pdfweb') 


$this->logo_vivilab_dibujado();

            // $this->Image('https://1.bp.blogspot.com/-soGkO7GfLbo/YT4ahF9CkvI/AAAAAAABhBo/2Bzt9fxlkSkXXXImljC8Rd7lCt24Fe0uACLcBGAsYHQ/s0/logo_vivilab_este.png', 10, 10, 0, 0, 'PNG');
            // $this->Image('https://1.bp.blogspot.com/-R0z-Mx7AEt0/YSUiE5-aqJI/AAAAAAABg1o/cD4Jh64blo4GQQbbXZdtF2FUedw0laZUwCLcBGAsYHQ/ezgif.com-gif-maker.gif', 10, 10, 0, -94, 'GIF');

       // $this->Image('http://www.mribti.com/barcode/image.php?code=' . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) . '&style=196&type=C128C&width=100&height=70&xres=1&font=3', 100, 10, 0, 0, 'PNG');

       // $this->Image('https://barcode.tec-it.com/barcode.ashx?data=' . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT) . '&code=Code128&imagetype=Png', 100, 10, 0, 15, 'PNG');

        if ($_POST["accion"] == 'pdfu'){
           // $this->Image('https://2.bp.blogspot.com/-8P6fEnWvAg0/XjbvrqCLyYI/AAAAAAABOoU/WQv0lKlPljEvWBfPBCrqn_mdhlVyJTRLgCK4BGAYYCw/logo_vivilab.png', 10, 10, 0, 25, 'PNG');
           // $this->Image('https://1.bp.blogspot.com/-soGkO7GfLbo/YT4ahF9CkvI/AAAAAAABhBo/2Bzt9fxlkSkXXXImljC8Rd7lCt24Fe0uACLcBGAsYHQ/s0/logo_vivilab_este.png', 10, 10, 0, 0, 'PNG');


        // $this->SetFillColor(7,128,137);    
$this->logo_vivilab_dibujado();




           $this->Image('https://1.bp.blogspot.com/-8aJ1OD8I_QU/YT2D4y4DzyI/AAAAAAABhBI/2e2hEr_roOIml9fPd0Glhnp5cm8U88_KgCLcBGAsYHQ/s0/logo_clinica_usat_este.png', 165, 10, 0, 0, 'PNG');
           // $this->Image('https://2.bp.blogspot.com/-FVyUv5G81BU/XjbvgxrC1nI/AAAAAAABOoM/2QSchGqlT7oCEMlzRw8zy63vBTXmAVv7wCK4BGAYYCw/logo_clinica_usat.png', 165, 10, 0, 25, 'PNG');
       }
       if ($_POST["accion"] == 'pdfs'){
           $this->Image('https://3.bp.blogspot.com/-2l8y0hrVAbw/XjbwzFveDxI/AAAAAAABOpY/KWRU4YlqtRU9czwaBtUGE1ur-XxDpe4rgCK4BGAYYCw/clinica_metropolitana_logo.png', 10, 10, 0, 25, 'PNG');
				//$this->Image('http://35.184.191.22/wp-content/uploads/2017/01/logo_salud_mujer.png', 150, 10, 0, 25, 'PNG');
           $this->Image('https://2.bp.blogspot.com/-8P6fEnWvAg0/XjbvrqCLyYI/AAAAAAABOoU/WQv0lKlPljEvWBfPBCrqn_mdhlVyJTRLgCK4BGAYYCw/logo_vivilab.png', 145, 13, 0, 20, 'PNG');
       }			
       if ($_POST["accion"] == 'pdfDk'){
          $this->Image('https://2.bp.blogspot.com/-8P6fEnWvAg0/XjbvrqCLyYI/AAAAAAABOoU/WQv0lKlPljEvWBfPBCrqn_mdhlVyJTRLgCK4BGAYYCw/logo_vivilab.png', 10, 10, 0, 25, 'PNG');
              //$this->Image('http://35.184.191.22/wp-content/uploads/2017/12/fiagnostika.png', 10, 10, 0, 25, 'PNG');
        //$this->Image('http://35.184.191.22/wp-content/uploads/2017/01/logo_salud_mujer.png', 150, 10, 0, 25, 'PNG');
      } 
      if ($_POST["accion"] == 'pdfTF'){ //tf t&f calidad y salud 
          // $this->Image('https://2.bp.blogspot.com/-eDdQ2lmP8LY/XjbxB3tqdAI/AAAAAAABOpw/zfuPW9axiloKl6geq1UlwgZqV3vVoO_GQCK4BGAYYCw/TF_logo-min.png', 10, 10, 0, 25, 'PNG');
        
        $this->SetFillColor(7,128,137);
        $this->Rect(10, 9.5, 78.5,25,'F');
        
        $this->SetFillColor(255,255,255);
        $this->Rect(13.5, 14.5, 15.5,15.5,'F');
    
        $this->SetTextColor(7,128,137);
        $this->SetFont('helvetica', 'B', 37.5);
        $this->SetXY(13.5,23.5);
    $this->_out(sprintf('BT %.2F Tz ET',88));
        $this->Cell(16,0,'TF',0,0,'');
    
        $this->SetXY(18,25.6);
        $this->SetFont('helvetica', 'B', 15);
        $this->Cell(0,0,'&',0,1,'L');
    
    
        $this->SetTextColor(255,255,255);
        $this->SetXY(30,20);
    $this->SetFont('helvetica', 'B', 28);
    $this->_out(sprintf('BT %.2F Tz ET',60));
    $this->Cell(55,0,'CALIDAD Y SALUD',0,0,'');
    // $this->CellFitScaleForce(55,0,'CALIDAD Y SALUD',0,0,'',1);
        // $this->Cell(0,0,'CALIDAD Y SALUD',0,1,'L');

    $this->_out(sprintf('BT %.2F Tz ET',100));
        $this->SetXY(30.5,27);
        $this->SetTextColor(123,198,207);
    $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0,0,'MEDICINA OCUPACIONAL',0,1,'L');

        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(0,0,0);



      }



if ($_POST["accion"] == 'pdfJR'){ //tf t&f calidad y salud 
          // $this->Image('https://2.bp.blogspot.com/-eDdQ2lmP8LY/XjbxB3tqdAI/AAAAAAABOpw/zfuPW9axiloKl6geq1UlwgZqV3vVoO_GQCK4BGAYYCw/TF_logo-min.png', 10, 10, 0, 25, 'PNG');
        
        $this->SetFillColor(7,128,137);
        $this->Rect(10, 9.5, 78.5,25,'F');
        
        $this->SetFillColor(255,255,255);
        $this->Rect(13.5, 14.5, 17,17,'F');
    
        $this->SetTextColor(7,128,137);
        $this->SetFont('helvetica', 'B', 35);
        $this->SetXY(12.6,23.5);
    $this->_out(sprintf('BT %.2F Tz ET',88));
        $this->Cell(16,0,'J R',0,0,'');
    
        $this->SetXY(18,25.4);
        $this->SetFont('helvetica', 'B', 17);
        $this->Cell(0,0,'&',0,1,'L');
    
    
        $this->SetTextColor(255,255,255);
        $this->SetXY(30,20);
    $this->SetFont('helvetica', 'B', 28);
    $this->_out(sprintf('BT %.2F Tz ET',60));
    $this->Cell(55,0,'CALIDAD Y SALUD',0,0,'');
    // $this->CellFitScaleForce(55,0,'CALIDAD Y SALUD',0,0,'',1);
        // $this->Cell(0,0,'CALIDAD Y SALUD',0,1,'L');

    $this->_out(sprintf('BT %.2F Tz ET',100));
        $this->SetXY(30.5,27);
        $this->SetTextColor(123,198,207);
    $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0,0,'MEDICINA OCUPACIONAL',0,1,'L');

        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(0,0,0);



      }



      if ($_POST["accion"] == 'pdfTF2'){
      //  local      $this->Image('http://127.0.0.1:4001/wordpress/wp-content/uploads/2020/09/cabeceraTF2.png', 28.5, 15.5, 0, 27.2, 'PNG');
        // $this->Image('https://1.bp.blogspot.com/-BynVIXpKFYw/X3fKZkEepDI/AAAAAAABX0E/KXVIB5QWAKEcCi5E46IfCDmcIfQCIKVxACLcBGAsYHQ/s16000/cabeceraTF2-min.png', 28.5, 15.5, 0, 27.2, 'PNG');
        
    }

    if ($_POST["accion"] == 'pdfTF3'){
      //  local      $this->Image('http://127.0.0.1:4001/wordpress/wp-content/uploads/2020/09/cabeceraTF2.png', 28.5, 15.5, 0, 27.2, 'PNG');
        // $this->Image('https://1.bp.blogspot.com/-dUaByxu-S5k/YBzxfPpDvQI/AAAAAAABbPY/wF6yFKZGi_ofCbjv2cwXTfK0Ld3-fRN0ACLcBGAsYHQ/s16000/tyf3.png', 28.5, 15.5, 0, 27.2, 'PNG');
        
    }

    if ($_POST["accion"] == 'pdfCerinor'){
      $this->Image('https://2.bp.blogspot.com/-UOEPDXb9tsI/XjbxInx7fkI/AAAAAAABOp8/qgSGmlrFulwms6SyBUdNANl_dK_8Ql_8gCK4BGAYYCw/pdfCerinor.png', 10, 10, 0, 25, 'PNG');

    }
    if ($_POST["accion"] == 'pdfGastroSalud'){
      $this->Image('https://1.bp.blogspot.com/-Zbk0weLC-XM/YT2G8OTEBZI/AAAAAAABhBU/KCp0ssg59IQReFn_70M8VS2MfzCWAUoRwCLcBGAsYHQ/s0/gastrosalud_este.png', 10, 10, 0, 0, 'PNG');
      // $this->Image('https://1.bp.blogspot.com/-wq07WGAkn0o/Xz1C7i3HPdI/AAAAAAABXCg/Mu4BN-_DC_QTS3Z489VI2MqKsOZTQ0BbgCLcBGAsYHQ/gastrosalud5.png', 10, 10, 0, 25, 'PNG');
    }

    if ($_POST["accion"] == 'pdfBM'){
      $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2023/10/bm_blanco__.png', 10, 10, 0, 0, 'PNG');
    }
    
    if ($_POST["accion"] == 'pdfMediplus'){

      $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2024/12/mediplus-1.png', 10, 10, 0, 0, 'PNG');
    $this->SetXY(35,10);
    $this->Cell(0,0,'LABORATORIO CLINICO',0,0,'');
    $this->SetXY(42,27);
    $this->Cell(0,0,'CEL: 972698701',0,0,'');
    }

    if ($_POST["accion"] == 'pdfCubaMedic'){

      $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2025/09/cubamedic_.png', 10, 10, 0, 0, 'PNG');
    
    }

    if ($_POST["accion"] == 'pdfBeneficencia'){

      $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2025/10/beneficencia.png', 10, 10, 0, 0, 'PNG');
    
    }


/**
    if ($_POST["accion"] == 'pdfNazareno'){
      $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2023/10/nazareno2.png', 10, 10, 0, 0, 'PNG');
    }
**/

    if ($_POST["accion"] == 'pdfSantaRosa'){

        $this->logo_vivilab_dibujado();
           $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2023/10/santarosa.png', 115, 10, 0, 0, 'PNG');
    }


    if ($_POST["accion"] == 'pdfInka'){

        $this->logo_vivilab_dibujado();
           $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2025/09/inka336.png', 115, 10, 0, 0, 'PNG');
    }
    if ($_POST["accion"] == 'pdfUronor'){

        $this->logo_vivilab_dibujado();
            $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2023/10/uronor.png', 115, 10, 0, 0, 'PNG');
           //$this->Image('http://localhost/vivilab2023/wp-content/uploads/2024/12/uronor2.png', 115, 10, 0, 0, 'PNG');
    }  

  global $wpdb;
  global $orden;
  $orden = $wpdb->get_row("SELECT SQL_CACHE dni_dni, nota, doctor_cmp, paciente_dni, fecha, user_id, paciente.nombre as paciente, natalicio, sexo, doctor.nombre as doctor FROM orden inner join paciente on orden.paciente_dni=paciente.dni inner join doctor on orden.doctor_cmp=doctor.cmp WHERE id=" . $_POST['orden'], ARRAY_A);
        //$date = new DateTime($orden[fecha]);
        //$wpdb->show_errors();//$wpdb->print_error();
  $orden['dni_dni']=$orden['dni_dni'];
  $date = new DateTime($orden['natalicio']);
  if ($orden['natalicio'] != '0000-00-00') {
    $datetime1 = date_create($date->format('Y-m-d'));
    $datetime2 = date_create(date_i18n('Y-m-d'));
    $interval = date_diff($datetime1, $datetime2);
    $edad = $interval->format('%y años %m meses %d días');
    // $edad = $interval->format('%y años, %m meses, %d días');
    // $edad_covid="EDAD: ".$edad;
    } else {
      $edad="";       
    } 
// if(!isset($edad))$edad="";
$user_info = get_userdata($orden['user_id']);
$orden['paciente']=utf8_decode(normalizar_nombre($orden['paciente']));


if ($_POST["accion"] == 'pdfTF3' ){ //ANTIGENO-CORONAVIRUS SARS-CoV-2
    
    // if($edad!='')$edad = "EDAD: ".$edad;

    $w = array(18.5,0, 92,);
    $h=7;

    $this->SetFont('helvetica', 'B', 10);
    $this->SetY(53);

    $this->Cell($w[0]);     
    $this->Cell($w[1], $h, 'DATOS DEL PACIENTE: ' . $orden['paciente'], '', 0, '');
    // $this->Cell($w[1], $h, 'DATOS DEL PACIENTE: ' . utf8_decode(ucwords(strtolower($orden['paciente']))), '', 0, '');
    $this->Ln();

    $this->Cell($w[0]); 
    $this->Cell($w[2], $h, 'EDAD: '. utf8_decode($edad), '', 0, '');
    $this->Cell($w[1], $h, 'DOCUMENTO: '.str_pad($orden['dni_dni'], 8, '0', STR_PAD_LEFT),'',0,'');
    $this->Ln();

    $this->Cell($w[0]); 
    $this->Cell($w[2],$h,''.$orden['nota'],'', 0,'');
    $this->Cell($w[1],$h,'MEDICO SOLICITANTE: ' . utf8_decode(ucwords(strtolower($orden['doctor']))),'',0,'');
    $this->Ln();

    $this->Cell($w[0]); 
    $this->Cell($w[2],$h,'FECHA DE TOMA DE MUESTRA: ' . date_format(date_create($orden['fecha']), 'd-m-Y'),'', 0,'');
    $this->Cell($w[1],$h,'ANALISTA: ' . utf8_decode(ucwords(strtolower($user_info->user_login))),'',0,'');
    $this->Ln(18);


    $this->SetFont('helvetica','BU',12);
    $this->Cell($w[0]); 
    $this->Cell($w[2],$h,'PRUEBA DE ANTIGENO CUALITATIVO-SARS-CoV-2:','', 0,'');
    $this->Ln();


    $w = array(72, 85, 53,18.5);

    $this->SetFont('helvetica', 'B', 10);
    $this->SetY(95);
        //$this->Cell(0, 1, '', 'TRLB');
    $this->Ln();
    $this->Cell($w[3]); 
    $this->Cell($w[0], 8, 'PRUEBA', 'TRLB', 0, 'C');
    $this->Cell($w[1], 8, 'RESULTADO', 'TRLB', 0, 'C');
    // $this->Cell($w[2], 5, 'METODO', 'TRLB', 0, 'C');


        //$this->Ln();        

//end pdfTF3 cabecera

} else

if ($_POST["accion"] == 'pdfTF2' ){ //PRUEBA RAPIDA SARS-CoV-2 IgG/IgM:

    // $edad = $interval->format('%y');

    $w = array(18.5,0, 92,);
    $h=7;

    $this->SetFont('helvetica', 'B', 10);
    $this->SetY(53);

    $this->Cell($w[0]);     
    $this->Cell($w[1], $h, 'DATOS DEL PACIENTE: ' . $orden['paciente'], '', 0, '');
    $this->Ln();

    $this->Cell($w[0]); 
    $this->Cell($w[2], $h, 'EDAD: ' . utf8_decode($edad), '', 0, '');
    $this->Cell($w[1], $h, 'DOCUMENTO: '.str_pad($orden['dni_dni'], 8, '0', STR_PAD_LEFT),'',0,'');
    $this->Ln();

    $this->Cell($w[0]); 
    $this->Cell($w[2],$h,''.$orden['nota'],'', 0,'');
    $this->Cell($w[1],$h,'MEDICO SOLICITANTE: ' . utf8_decode(ucwords(strtolower($orden['doctor']))),'',0,'');
    $this->Ln();

    $this->Cell($w[0]); 
    $this->Cell($w[2],$h,'FECHA DE TOMA DE MUESTRA: ' . date_format(date_create($orden['fecha']), 'd-m-Y'),'', 0,'');
    $this->Cell($w[1],$h,'ANALISTA: ' . utf8_decode(ucwords(strtolower($user_info->user_login))),'',0,'');
    $this->Ln(18);


    $this->SetFont('helvetica','BU',12);
    $this->Cell($w[0]); 
    $this->Cell($w[2],$h,'PRUEBA RAPIDA SARS-CoV-2 IgG/IgM:','', 0,'');
    $this->Ln();


    $w = array(72, 85, 63,18.5);

    $this->SetFont('helvetica', 'B', 10);
    $this->SetY(95);
        //$this->Cell(0, 1, '', 'TRLB');
    $this->Ln();
    $this->Cell($w[3]); 
    $this->Cell($w[0], 9, 'PRUEBA', 'TRLB', 0, 'C');
    $this->Cell($w[1], 9, 'RESULTADO', 'TRLB', 0, 'C');
    // $this->Cell($w[2], 5, 'METODO', 'TRLB', 0, 'C');


        //$this->Ln();        

//end pdfTF2 cabecera

} else{


    if($orden['dni_dni'])$orden['dni_dni']=' / DNI '.str_pad($orden['dni_dni'], 8, '0', STR_PAD_LEFT);
        //if ($orden['sexo'] == 'h') $vr = 'hombre'; else if ($orden['sexo'] == 'm') $vr = 'mujer'; else $vr = 'infante';


    if ($orden['nota']) $ob = 'Observaciones'; else $ob = '';
    if ($orden['nota']) $nota =  $orden['nota'] ;
    if(!isset($nota))$nota="";

    $w = array(20, 80, 30,0);
    $h=5;
    $this->SetFont('helvetica', '', 10);
    $this->SetY(50);

    $this->Cell(0, 1, '', 'TRL');
    $this->Ln();
    $this->Cell($w[0], $h, ' Paciente', 'L', 0, '');
    $this->Cell($w[1], $h, ': ' . $orden['paciente'], '', 0, '');
    $this->Cell($w[2], $h, utf8_decode('Orden Nº'), '');
    $this->Cell($w[3], $h, ': ' . str_pad($_POST['orden'], 8, "0", STR_PAD_LEFT), 'R');
    $this->Ln();

    $this->Cell($w[0], $h, ' Edad', 'L');
    $this->Cell($w[1], $h, ': ' . utf8_decode($edad).$orden['dni_dni'], '', 0, '');

    $this->Cell($w[2], $h, 'Toma de muestra', '');

    if ($_POST["accion"] == 'pdfSantaRosa'){
        $this->Cell($w[3], $h, ': ' . date_format(date_create($orden['fecha']), 'd/m/Y'), 'R');
    }else {$this->Cell($w[3], $h, ': ' . date_format(date_create($orden['fecha']), 'd/m/Y h:i A'), 'R');}
    $this->Ln();

    if($orden['doctor']=='NN') $orden['doctor']='';
    $this->Cell($w[0], $h, utf8_decode(' Médico'), 'L');
    $this->Cell($w[1], $h, ': ' . utf8_decode( normalizar_nombre($orden['doctor'])), '', 0, '');

    $this->Cell($w[2], $h, 'Analista', '');

    if ($_POST["accion"] == 'pdfSantaRosa'){
    $this->Cell($w[3], $h, ': ' . utf8_decode($user_info->display_name), 'R'); //user_login
    }else{
        $this->Cell($w[3], $h, ': ' . utf8_decode(ucwords(strtolower($user_info->user_login))), 'R');
    }

    $this->Ln();

        //$this->Cell($w[0], 4, ' CMP', 'L');
        //$this->Cell($w[1], 4, ': ' . $orden['doctor_cmp'], '', 0, '');
       // $this->Cell($w[0], 4, ' Fecha', 'L');
        //$this->Cell($w[1], 4, ': '.date_i18n('d/m/Y'), '', 0, '');
    if($nota){
        $this->Cell($w[0], $h, ' Nota', 'L');
        $this->MultiCell(0, $h, ': ' . utf8_decode($nota),'R','L');
    }
        //$this->Ln();
    $this->Cell(0, 1, '', 'BRL');

    $w = array(80, 55, 55);


// Anchuras de las columnas

        //$header = array(utf8_decode('EXAMEN'), 'RESUL', 'TADO', 'RANGO REFERENCIAL');
        // Cabeceras
    $this->SetFont('helvetica', 'B', 10);
    $this->SetY(80);
    $this->Cell($w[0], 5, utf8_decode('EXAMEN'), 'B', 0, '');
    $this->Cell($w[1], 5, 'RESULTADO', 'B', 0, 'L');
       // $this->Cell($w[2], 5, '', 'B', 0, 'L');
    $this->Cell($w[2], 5, 'RANGO REFERENCIAL', 'B', 0, '');
    $this->Ln();
        /*
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],'B',0,'C');
        $this->Ln();
        */
        // Arial bold 15

        // Movernos a la derecha
        //$this->Cell(80);
        // Título
        //$this->Cell(30,10,'Title',1,0,'C');
        // Salto de línea
        $this->Ln(2);
    }


}

// Pie de página
function Footer()
{

$this->SetFont('helvetica', '', 8);





if ($_POST["accion"] == 'pdfDk' || $_POST["accion"] == 'Imprimir2'){
      $this->Image('https://1.bp.blogspot.com/-zEh5edwxpcw/XjbwcLKszUI/AAAAAAABOo4/B9Aueq67Jpo54dM5MavNEuj17J9bmj_RwCK4BGAYYCw/yoverapuican.jpg', 161, 237, 0, 20, 'JPG'); //firma
    $this->SetXY(155, -45);
    $this->MultiCell(50, 4, utf8_decode("_________________________\nÁngela V. Yovera Puican\nMédica Patóloga Clínica\nCMP 54524 RNE 28576"), 0, 'C');
} else {

    if ($_POST["accion"] == 'pdfTF2' || $_POST["accion"] == 'pdfTF3'){

        $this->SetFillColor(38,182,208);
        $this->SetDrawColor(38,182,208);

// require('rounded_rect.php');
$this->SetLineWidth(0.3);
$this->RoundedRect(148, 14, 40, 11, 1.5, 'D');

        //logotf
        //$this->SetDrawColor(38,182,208);
$this->_out(sprintf('BT %.2F Tz ET',88));
        $this->SetTextColor(255,255,255);
        $this->Rect(29, 15, 19,19,'F');
        
        $this->SetXY(29.1,26);
    $this->SetFont('helvetica', 'B', 45);
        $this->Cell(19,0,'TF',0,1,'L');
        $this->SetXY(34.3,28.5);
    $this->SetFont('helvetica', 'B', 19.5);
        $this->Cell(0,0,'&',0,1,'L');
        $this->SetTextColor(38,182,208);
    
$this->_out(sprintf('BT %.2F Tz ET',85));
        $this->SetXY(49.5,18.5);
    $this->SetFont('helvetica', 'B', 21);
        $this->Cell(58.5,0,'CALIDAD Y SALUD',0,1,'L');
$this->_out(sprintf('BT %.2F Tz ET',100));
        $this->SetXY(49.5,25);
    $this->SetFont('helvetica', 'B', 11);
        $this->Cell(0,0,'MEDICINA OCUPACIONAL',0,1,'L');
        
    $this->SetFont('helvetica', 'B', 12);
        $this->SetXY(28,40);
        $this->Cell(0,0,'SERVICIO DE LABORATORIO CLINICO',0,1,'L');
        
    $this->SetFont('helvetica', 'B', 10);
        $this->SetXY(149,18);
        $this->Cell(0,0,'CODIGO RENIPRESS',0,1,'L');

    $this->SetFont('helvetica', '', 10);
        $this->SetXY(160,22);
        $this->Cell(0,0,'00026958',0,1,'L');




$this->SetTextColor(0,0,0);
    // $this->Image('https://1.bp.blogspot.com/-4HFuKaqH3LA/X3fL1K4NbAI/AAAAAAABX0Q/auOnEMNnADQu2RkKhiFQxcomDR1XwY-rwCLcBGAsYHQ/s16000/biologo-min.jpg', 50, 239, 0, 24, 'JPG'); //firma
    // $this->Image('https://1.bp.blogspot.com/-pTdRjKl9tUU/YSVlnJP67jI/AAAAAAABg1w/1FA-RjVxyj0NdoIRrRnsJLhUKz6klHgcACLcBGAsYHQ/s0/fchavez2.jpg', 140, 235,0,-70, 'JPG'); 
    // $this->MultiCell(50, 3.5, utf8_decode("_______________________\nDr. Manuel Chavez G.\nMédico Patólogo\nCMP 21067 RNE 11679"), 0, 'C');
    $this->SetFont('helvetica', '', 9.5);
    //firma chavez
    $this->Image('https://1.bp.blogspot.com/-eM0H51nvn8E/YTz4pCK39DI/AAAAAAABhAk/d5Bj8ot4Ypw29LX7Fzgi-UsMxrtjVHaigCLcBGAsYHQ/s0/firma_chavez_este.jpg', 53,232,0,0, 'JPG');
    //firma bilogo
    $this->Image('https://1.bp.blogspot.com/-uqAaMRD6zwU/YTz4pJSPomI/AAAAAAABhAs/6ul58k2tLjEUuh48c61Sl1X8VX9jFylkgCLcBGAsYHQ/s0/firma_biologo_este.jpg', 130,235,0,0, 'JPG');
    //imagen del fondo
    $this->Image('https://1.bp.blogspot.com/-hPIg9i5XTCQ/YTz4pE4rkWI/AAAAAAABhAo/8ivUAD7_2uEl9irvfU7P1YiEXV-xUeqwQCLcBGAsYHQ/s0/footer_covid_este.png
        ', 0,281,0,0, 'PNG');
    //pin mapa
    $this->Image('https://1.bp.blogspot.com/-N377ZNL5iLA/YTz4qMvQIEI/AAAAAAABhAw/90JUkbvB2ZQXCfgSPWPS_M-M4R62ru0QACLcBGAsYHQ/s0/pinmapa_este.png', 43,282,0,0, 'PNG');
    $this->SetXY(49,286);
    $this->Cell(0,0,utf8_decode('Los Pinos N° 106, Urb. Santa Victoria - Chiclayo'),0,1,'L');
    //pin telefono      
    $this->Image('https://1.bp.blogspot.com/-J3dqMpRdefQ/YTz4qdRHBlI/AAAAAAABhA0/-Pd1DQo87cUIlJM4IRJlHRgSTQ0CGnOPQCLcBGAsYHQ/s0/telefono_covid_este.png
        ', 130,282,0,0, 'PNG');
    $this->SetXY(139,286);
    $this->Cell(0,0,'074-620802',0,1,'L');





    }
else {

if ($_POST["accion"] == 'pdfNazareno'){
      $this->Image('https://vivilabchiclayo.com/wp-content/uploads/2024/06/firma_nazareno_.png', 161, 237, 0, 20, 'PNG'); //firma
   
} else{
// https://2.bp.blogspot.com/-UwyTNaHN3XE/XjbwPvy7zGI/AAAAAAABOow/pVMHJx7gTLwmn9LGZay4hvTxRBoepM7xACK4BGAYYCw/fchavez.jpg   
$this->Image('https://1.bp.blogspot.com/-dgLTnsj7gHU/YSVrr6FmOLI/AAAAAAABg14/8-ypDap3JJYj59GUjClMRinTuzZeptAogCLcBGAsYHQ/s0/fchavez2%2B%25282%2529.jpg', 168, 239,23.54,19.98, 'JPG'); //firma
$this->SetXY(155, -45);
$this->MultiCell(50, 4, utf8_decode("_______________________\nDr. Manuel Chavez G.\nMédico Patólogo\nCMP 21067 RNE 11679"), 0, 'C');
}



} }
// Posición: a 1,5 cm del final
$this->SetY(-35);
// Número de página
if ($_POST["accion"] != 'pdfTF2' && $_POST["accion"] != 'pdfTF3'){    

$this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
$this->Ln();
}


if ($_POST["accion"] == 'pdfDk'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
//$this->MultiCell(0, 5, utf8_decode("Clínica Chiclayo - La Florida - Consultorio 202 - 2do Piso - Urb. Santa Victoria \n Telf. 74-237114 / Cel: 968835223 - Chiclayo - Perú \n E-mail: vivilab2009@hotmail.com"),'','C',true);
//$this->MultiCell(0, 4, utf8_decode("Clínica Chiclayo, consultorio 207, 2do piso, calle Florida 225, urb. Santa Victoria, Chiclayo, Lambayeque, Perú. \n Teléfonos: --- \n Email: ---"),'','C',true);
$this->MultiCell(0, 4, utf8_decode("Clínica Chiclayo, consultorio 202 - 207, 2do piso, calle Florida 225, urb. Santa Victoria, Chiclayo, Lambayeque, Perú. \n Teléfonos: (074)237114, 968835223 \n Email: vivilab2009@hotmail.com"),'','C',true);
}

if ($_POST["accion"] == 'pdfv' || $_POST["accion"] == 'pdfweb'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
//$this->MultiCell(0, 5, utf8_decode("Clínica Chiclayo - La Florida - Consultorio 202 - 2do Piso - Urb. Santa Victoria \n Telf. 74-237114 / Cel: 968835223 - Chiclayo - Perú \n E-mail: vivilab2009@hotmail.com"),'','C',true);
$this->MultiCell(0, 4, utf8_decode("\nLaboratorio de Análisis Clínicos y Microbiológicos VIVILAB SAC\nRUC: 20480146311 - Código IPRES: 14143"),'','C',true);
//$this->MultiCell(0, 4, utf8_decode("Clínica Chiclayo, consultorio 202, 2do piso, calle Florida 225, urb. Santa Victoria, Chiclayo, Lambayeque, Perú. \n Teléfonos: (074)237114, 968835223 \n Email: vivilab2009@hotmail.com"),'','C',true);
}
if ($_POST["accion"] == 'pdfu'){
//$this->SetTextColor(53, 76, 139);
//$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 3.5, utf8_decode("º Predio María Cruz S/N Parcela Nº 4 - Ciudad del Chofer - Chiclayo - Telf. (074) 634924 \nº Calle La Florida 225 Consultorio 202 - 2do Piso - Urb. Santa Victoria - Telf. (074) 237114 / Cel: 968835223 \n  Chiclayo - Perú \n  E-mail: vivilab2009@hotmail.com"),'','L',false);
}
if ($_POST["accion"] == 'pdfs'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Manuel María Izaga 154 - Chiclayo \n Teléfonos: (074)228802 \n 968835223"),'','C',true);
}
if ($_POST["accion"] == 'pdfTF'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Los Pinos 106 - Urb. Santa Victoria - Chiclayo \n Teléfonos: 968835223 \n 979683461"),'','C',true);
}
if ($_POST["accion"] == 'pdfJR'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Calle Colón S/N - Olmos \n Teléfono: 978 014 514"),'','C',true);
}


if ($_POST["accion"] == 'pdfBM'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Dirección: Av. Santa Victoria 416 - Chiclayo \n Teléfonos: 074 226136 \n 968835223"),'','C',true);
}

if ($_POST["accion"] == 'pdfMediplus'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Laboratorio Clínico MediPlus | Teléfono: 972698701 | Dirección: Calle Tacna N° 070 - Chiclayo"),'','C',true);
}


if ($_POST["accion"] == 'pdfCubaMedic'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Centro Médico Cuba Medic | Teléfono: 951806557 | Dirección: Calle Gloria 160 Urb. Libertadores - Chiclayo"),'','C',true);
}

if ($_POST["accion"] == 'pdfBeneficencia'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Sociedad de Beneficencia Chiclayo | Teléfonos: (074)235241 (074)233691 Anexo 222 | Dirección: Elías Aguirre N 250 (frente a la Plazuela) - Chiclayo"),'','C',true);
}

/**
if ($_POST["accion"] == 'pdfNazareno'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode(""),'','C',true);
}
**/

if ($_POST["accion"] == 'pdfSantaRosa' || $_POST["accion"] == 'pdfInka'){
    $current_user = wp_get_current_user();;
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("\nLaboratorio de Análisis Clínicos y Microbiológicos VIVILAB SAC\nRUC: 20480146311 - Código IPRES: 14143"),'','C',true);
// Date du jour
        setlocale(LC_TIME, "es-PE");
        date_default_timezone_set('America/Lima');
        $date_du_jour = utf8_encode(strftime('%d/%m/%Y'));
        $this->MultiCell(0, 4, utf8_decode("Emisión: " . $date_du_jour . ""),'','R',true);

        

}

if ($_POST["accion"] == 'pdfUronor'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode(""),'','C',true);
}


// if ($_POST["accion"] == 'pdfTF3'){
// $this->Ln();         
// $this->Ln(); 
// $this->Ln();         
// $this->Ln();                             
// $this->SetTextColor(53, 76, 139);
// $this->SetFillColor(236, 240, 247);
// $this->SetFont('', '', '');
// $this->MultiCell(0, 4, utf8_decode("Los Pinos 106 - Urb. Santa Victoria - Chiclayo \n Teléfono: 074-620802"),'','C',true);
// }

if ($_POST["accion"] == 'pdfTF2'){ // no tiene pie de página
}
if ($_POST["accion"] == 'pdfCerinor'){
$this->SetTextColor(53, 76, 139);
$this->SetFillColor(236, 240, 247);
$this->SetFont('', '', '');
$this->MultiCell(0, 4, utf8_decode("Calle Francisco Cabrera 1400 - Chiclayo \n Teléfono: (074) 233882"),'','C',true);
}

}




public function ImprovedTable_barcode(){
$this->SetFont('Helvetica','',12);
$this->Cell(60,4,'Lacodigoteca.com',0,1,'C');
}





public function ImprovedTable($data)
{



    if ($_POST["accion"] == 'pdfTF3'){
        $w = array(72, 85, 53,18.5);
        
        //$this->SetFont('helvetica', 'B', 10);
        //$this->SetY(95);
        //$this->Cell(0, 1, '', 'TRLB');
        $this->Ln();
        $this->SetFont('helvetica', 'B', 10);
        
        foreach ($data as $rowP) {

            $this->Cell($w[3]); 
            $this->Cell($w[0], 4, '', 'TL', 0, 'L');
            $this->Cell($w[1], 4, '', 'TRL', 0, 'C');
            // $this->Cell($w[2], 4, '', 'TR', 0, 'C');
            $this->Ln();    
            $this->Cell($w[3]); 
        //$this->Cell($w[0], 12, $rowP->prueba, 'RL', 0, 'L');
            $this->Cell($w[0], 20, utf8_decode('ANTIGENO-CORONAVIRUS SARS-CoV-2'), 'L', 0, 'C'); 
            $this->Cell($w[1], 20, $rowP->resultado, 'RL', 0, 'C');
       // $this->MultiCell($w[2], 4, utf8_decode($rowP->metodo), 'RL','C', false);
            // $this->Cell($w[2], 12, utf8_decode('INMUNOCROMATOGRAFIA'), 'R', 0, 'C');
            $this->Ln();                   
            $this->Cell($w[3]); 
            $this->Cell($w[0], 4, '', 'BL', 0, 'L');
            $this->Cell($w[1], 4, '', 'BRL', 0, 'C');
            // $this->Cell($w[2], 4, '', 'BR', 0, 'C');

            $this->Ln();                   
        }

        // $this->Cell($w[3]); 
        $this->SetTextColor(89,89,89);
        $this->SetXY(28.5,142);
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(30, 8, utf8_decode('TIPO DE MUESTRA:'), '', 0, '');          
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 8, utf8_decode(' Hisopado Nasofaríngeo'), '', 0, '');
        
        $this->Line(28.5,151,185.5,151);    
        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(28.5,153);
        $this->Cell(0, 4, utf8_decode('METODOLOGIA:'), '', 0, ''); 
        $this->SetFont('helvetica', '', 8);
        $this->SetXY(59,153);
        $this->MultiCell(0, 4, utf8_decode('INMUNOCROMATOGRAFIA
Sensibilidad relativa: 97.3% / Especificidad relativa: 100 % / Precisión: 99%'), '','', false);  
        
        $this->Line(28.5,163,185.5,163);    
        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(28.5,165);
        $this->Cell(0, 8, utf8_decode('MARCA: '), '', 0, ''); 
        $this->SetFont('helvetica', '', 8);
        $this->SetXY(42,165);
        $this->Cell(0, 8, utf8_decode('Lifotronic SARS-CoV-2 Antigen (GICA) LOTE: SAR22001B0 VCTO: 06-07-2024'), '', 0, ''); 
        
        $this->Line(28.5,173,185.5,173);    
        $this->SetXY(28.5,174);
        $this->Cell(0, 8, utf8_decode('La presente prueba detecta cualitativamente el Antígeno de la proteína de la nucleocápside del SARS-CoV-2'), '', 0, ''); 
        
        $this->Line(28.5,182,185.5,182);    
        $this->SetXY(28.5,183);
        $this->Cell(0, 8, utf8_decode('NOTA: Los resultados son reportados a la plataforma SISCOVID.'), '', 0, ''); 


  //       $this->Ln(); 
  //       $this->SetFont('helvetica', 'B', 8);
  //       $w = array(95, 30, 38,18.5);
  //       $this->Ln();        
  //       $this->Cell($w[3], 5); 
  //       $this->Cell($w[0], 5, 'MARCA: ', 'TRL', 0, 'L');
  //       $this->Cell($w[1], 5, 'NUMERO DE LOTE: ', 'TRL', 0, 'L');
  //       $this->Cell($w[2], 5, 'FECHA DE VENCIMIENTO: ', 'TRL', 0, 'L');
  //       $this->Ln();        
  //       $this->Cell($w[3], 5); 
  //       $this->SetFont('helvetica', '', 8);
  //       $this->Cell(95, 5, utf8_decode("AMP RAPID TEST SARS-COV-2 Ag AMEDA Labordiagnostik GmbH"), 'BRL', 0, 'L');
  // //$this->MultiCell($w[0], 5, utf8_decode("AMP RAPID TEST SARS-COV-2  \n Ag AMEDA Labordiagnostik GmbH"), 'R','L', false);      
  //       $this->Cell(30, 5, '20111016', 'BRL', 0, 'L');
  //       $this->Cell(38, 5, '30 Noviembre 2022', 'BRL', 0, 'L');
  //       $this->Ln(25);        

  //       $this->SetFont('helvetica','',8);
  //       $this->Cell($w[3]); 
  //       $this->Cell(0,5,utf8_decode("La presente prueba detecta cualitativamente el antígeno de la proteína de la nucleocápside del SARS-CoV-2."),'', 0,'');
  //       $this->Ln();
  //       $this->SetFont('helvetica','',8);
        
/*        $w = array(25, 48, 90,18.5);
        
        $this->Cell($w[3]); 
        $this->Cell($w[0], 6, '', 'TL', 0, 'L');
        $this->Cell($w[1], 6, '', 'T', 0, 'L');
        $this->Cell($w[2], 6, '', 'TR', 0, 'L');
        $this->Ln();    

        $this->Cell($w[3]); 
        $this->Cell($w[0], 6, 'IgM(+) IgG(-)', 'L', 0, 'L');
        $this->Cell($w[1], 6, utf8_decode('Estado temprano de la infección'), '', 0, 'L');$this->MultiCell($w[2], 6, $this->Cell($w[1], 6, utf8_decode('Estado temprano de la infección'), '', , 'R','L', false);
        $this->MultiCell($w[2], 6, 'Aislamiento domiciliario por 14 dias y seguimiento medico.', 'R','L', false);

$this->Cell($w[3]); 
        $this->Cell($w[0], 6, 'IgM(+) IgG(+)', 'L', 0, 'L');
        $this->Cell($w[1], 6, utf8_decode('Fase activa de la infección'), '', 0, 'L');
        $this->MultiCell($w[2], 6, 'Aislamiento domiciliario por 14 dias y seguimiento medico.', 'R','L', false);

$this->Cell($w[3]); 
        $this->Cell($w[0], 6, 'IgM(-) IgG(+)', 'L', 0, 'L');
        $this->Cell($w[1], 6, utf8_decode("Fase Final de la infección/"), '', 0, 'L');
        $this->MultiCell($w[2], 6, utf8_decode('Aislamiento domiciliario por 7 dias y evaluación medica tomando en'), 'R','L', false);        

$this->Cell($w[3]); 
        $this->Cell($w[0], 2, '', 'L', 0, 'L');
        $this->Cell($w[1], 2, utf8_decode("Infección Pasada"), '', 0, 'L');
        $this->MultiCell($w[2], 2, utf8_decode('consideración el periodo de infección para reincorporación laboral.'), 'R','L', false);                

        $this->Cell($w[3]); 
        $this->Cell($w[0], 6, '', 'BL', 0, 'L');
        $this->Cell($w[1], 6, '', 'B', 0, 'L');
        $this->Cell($w[2], 6, '', 'BR', 0, 'L');
        */
        // $this->Ln();
        // $this->Cell($w[3]);     
        // $this->Cell(0, 6, 'NOTA: Los resultados son reportados a la plataforma SISCOVID, para su monitoreo y seguimiento', '', 0, 'L');

    }




    else

    {



        if ($_POST["accion"] == 'pdfTF2'){
            $w = array(72, 85, 63,18.5);

        $this->SetFont('helvetica', 'B', 10);
        //$this->Cell(0, 1, '', 'TRLB');
            $this->Ln();
        $this->SetXY(28.5,111);

            foreach ($data as $rowP) {
if($rowP->resultado!='.'){
                // $this->Cell($w[3]); 
                // $this->Cell($w[0], 4, '', 'TRL', 0, 'L');
                // $this->Cell($w[1], 4, '', 'TRL', 0, 'C');
                // $this->Cell($w[2], 4, '', 'TRL', 0, 'C');
                // $this->Ln();    
                // $this->Cell($w[3]); 
                $this->Cell($w[0], 14, $rowP->prueba, 'LTRB', 0, 'L');
                $this->Cell($w[1], 14, $rowP->resultado, 'LTRB', 0, 'C');
                // $this->MultiCell($w[2], 4, utf8_decode($rowP->metodo), 'RL','C', false);

                // $this->Cell($w[3]); 
                // $this->Cell($w[0], 4, '', 'BRL', 0, 'L');
                // $this->Cell($w[1], 4, '', 'BRL', 0, 'C');
                // $this->Cell($w[2], 4, '', 'BRL', 0, 'C');

                 $this->Ln();
                 $this->SetXY(28.5,125);                   
            }}   
            $this->SetXY(28.5,143);
            $this->SetTextColor(89,89,89);
            $this->SetFont('helvetica', 'B', 8);
            $this->Cell(0,4,'METODOLOGIA:','',0,'');
            $this->SetFont('helvetica', '', 8);
            $this->SetXY(55,143);
            $this->MultiCell(0, 4, 'INMUNOCROMATOGRAFIA
Ig M: Sensibilidad relativa: 95.7% / Especificidad relativa: 97.3 %
Ig  G : Sensibilidad relativa: 91.8% / Especificidad relativa: 96.4 %', '','', false);

$this->Line(28.5,157,185.5,157);            
            $this->SetXY(28.5,160);
            $this->Cell(0,4,'MARCA: AMP RAPID TEST SARS-COV-2 IgG/IgM -AMEDA Labordiagnostik GmbH','',0,'');

$this->Line(28.5,166,185.5,166);            
            $this->SetXY(28.5,168);
            $this->SetFont('helvetica', 'B', 8);
            $this->Cell(0,4,'INTERPRETACION DE RESULTADOS DE PRUEBA RAPIDA SARS-CoV-2 IgG/IgM','',0,'');

            $this->SetFont('helvetica', '', 8);
            $this->SetXY(28.5,173);
 $this->MultiCell(0, 4, 'IgM(+) IgG(-)
IgM(+) IgG(+)
IgM(-) IgG(+)', '','', false);

            $this->SetXY(50,173);
  $this->MultiCell(0, 4, utf8_decode('Estado temprano de la infección
Fase activa de la infección
Fase Final de la infección/
Infección Pasada'), '','', false);
            $this->SetXY(98,173);
$this->MultiCell(0, 4, utf8_decode('Aislamiento domiciliario por 14 dias y seguimiento medico.
Aislamiento domiciliario por 14 dias y seguimiento  medico.
Aislamiento domiciliario por 7 dias y evaluación medica tomando en
consideración  el periodo de infección para reincorporación laboral'), '','', false);  
$this->Line(28.5,193,185.5,193);            
            $this->SetXY(28.5,195);
            $this->Cell(0,4,'NOTA: Los resultados son reportados a la plataforma SISCOVID.','',0,'');
            
            // $w = array(65, 40, 58,18.5);
            // $this->Ln();        
            // $this->Cell($w[3], 5); 
            // $this->Cell($w[0], 5, 'MARCA: ', 'TRL', 0, 'L');
            // $this->Cell($w[1], 5, 'NUMERO DE LOTE: ', 'TRL', 0, 'L');
            // $this->Cell($w[2], 5, 'FECHA DE VENCIMIENTO: ', 'TRL', 0, 'L');
            // $this->Ln();        
            // $this->Cell($w[3], 5); 
            // $this->SetFont('helvetica', '', 8);
            // $this->Cell($w[0], 5, 'AMP DIAGNOSTICS AUSTRIA', 'BRL', 0, 'L');
            // $this->Cell($w[1], 5, '20045566', 'BRL', 0, 'L');
            // $this->Cell($w[2], 5, '2022-04', 'BRL', 0, 'L');
            // $this->Ln(25);        

            // $this->SetFont('helvetica','BU',9);
            // $this->Cell($w[3]); 
            // $this->Cell(0,5,'INTERPRETACION DE RESULTADOS DE PRUEBA RAPIDA DE DETECCION DE COVID-19 POSITIVO','', 0,'');
            // $this->Ln();
            // $this->SetFont('helvetica','',8);

            // $w = array(25, 48, 90,18.5);

            // $this->Cell($w[3]); 
            // $this->Cell($w[0], 6, '', 'TL', 0, 'L');
            // $this->Cell($w[1], 6, '', 'T', 0, 'L');
            // $this->Cell($w[2], 6, '', 'TR', 0, 'L');
            // $this->Ln();    

            // $this->Cell($w[3]); 
            // $this->Cell($w[0], 6, 'IgM(+) IgG(-)', 'L', 0, 'L');
            // $this->Cell($w[1], 6, utf8_decode('Estado temprano de la infección'), '', 0, 'L');
            // $this->MultiCell($w[2], 6, 'Aislamiento domiciliario por 14 dias y seguimiento medico.', 'R','L', false);

            // $this->Cell($w[3]); 
            // $this->Cell($w[0], 6, 'IgM(+) IgG(+)', 'L', 0, 'L');
            // $this->Cell($w[1], 6, utf8_decode('Fase activa de la infección'), '', 0, 'L');
            // $this->MultiCell($w[2], 6, 'Aislamiento domiciliario por 14 dias y seguimiento medico.', 'R','L', false);

            // $this->Cell($w[3]); 
            // $this->Cell($w[0], 6, 'IgM(-) IgG(+)', 'L', 0, 'L');
            // $this->Cell($w[1], 6, utf8_decode("Fase Final de la infección/"), '', 0, 'L');
            // $this->MultiCell($w[2], 6, utf8_decode('Aislamiento domiciliario por 7 dias y evaluación medica tomando en'), 'R','L', false);        

            // $this->Cell($w[3]); 
            // $this->Cell($w[0], 2, '', 'L', 0, 'L');
            // $this->Cell($w[1], 2, utf8_decode("Infección Pasada"), '', 0, 'L');
            // $this->MultiCell($w[2], 2, utf8_decode('consideración el periodo de infección para reincorporación laboral.'), 'R','L', false);                

            // $this->Cell($w[3]); 
            // $this->Cell($w[0], 6, '', 'BL', 0, 'L');
            // $this->Cell($w[1], 6, '', 'B', 0, 'L');
            // $this->Cell($w[2], 6, '', 'BR', 0, 'L');

            // $this->Ln();
            // $this->Cell($w[3]);     
            // $this->Cell(0, 6, 'NOTA: Los resultados son reportados a la plataforma SISCOVID, para su monitoreo y seguimiento', '', 0, 'L');

        } else{

         $area = '';
         $temp = '';
         $h = 5;
         $hl = 1;
         $i = 0;
         $y = 0;
         $sub = '';
         $B='';
         global $current_user;
       $current_user->user_status=''; //negrita para resultado fuera de rango referencial
       $this->SetLineWidth(0.001);



       //Table with 20 rows and 4 columns
       $this->SetWidths(array(80, 55, 55));

       foreach ($data as $rowP) {
         $i = $i + 1;
         if ($i % 2 == 0) {
             $this->SetFillColor(240);
         } else {
             $this->SetFillColor(255);
         }

         if ($rowP->resultado == '.') {
             $rowP->resultado = '';
             $rowP->unidades = '';
             $rowP->metodo = '';
             $rowP->valores = '';
             $sub = '';
             $B='B';
         } 

         if($rowP->ivmin != '' and $rowP->ivmax != ''){
            if ($rowP->resultado < $rowP->ivmin) {
             $current_user->user_status='B';
         } 

         if ($rowP->resultado  > $rowP->ivmax) {
             $current_user->user_status='B';
         }
     }


           //else $sub = ' ';

     if ($area != '' && $area != $rowP->area) {
         if (is_numeric($rowP->area) && $y <= 227) {
             $this->Ln(3);
             $this->Line(10, $y, 200, $y);
                   //$this->Ln();
         } else $this->AddPage('P', 'A4');
               //echo $this->Cell(0, 5, $y,'',2,'',true);
     
     } 

    if ($temp != $rowP->analid && $area =='z') {
     $this->AddPage('P', 'A4');
      }










     if ($rowP->metodo <> "") $metodo = " (" . $rowP->metodo . ")"; else $metodo = "";

           //$metodo = $rowP->metodo;
     if ($temp != $rowP->analid) {

         if ($rowP->nombre == $rowP->prueba) {
             $this->SetFont('', 'B', '');
             $this->Row(array(utf8_decode($rowP->prueba . $metodo), utf8_decode($rowP->resultado . ' ' . $rowP->unidades), utf8_decode(str_replace('—', '-', $rowP->valores))));
                   //$this->Row(array(utf8_decode($rowP->prueba)));

         } else { 
                //alternar color filas
             $this->SetFont('', 'B', '');
                   //$this->Row(array(utf8_decode($rowP->nombre . $metodo), '', '')); //le quite el metodo al titulo sin resultado
             $this->Row(array(utf8_decode($rowP->nombre), '', ''));
             $this->SetFont('', $B, '');
             $i = $i + 1;
             if ($i % 2 == 0) {
                 $this->SetFillColor(240);
             } else {
                 $this->SetFillColor(255);
             }
             $this->Row(array(utf8_decode($rowP->prueba . $metodo), utf8_decode($rowP->resultado . ' ' . $rowP->unidades), utf8_decode(str_replace('—', '-', $rowP->valores))));
         }

     } else {
         $this->SetFont('', $B, '');
         $this->Row(array(utf8_decode($sub . $rowP->prueba . $metodo), utf8_decode($rowP->resultado . ' ' . $rowP->unidades), utf8_decode(str_replace('—', '-', $rowP->valores))));
     }
     $temp = $rowP->analid;
     $area = $rowP->area;
     $y = $this->GetY() + 1;
           $sub = ''; //dejar de usar esto
           $B='';
           $current_user->user_status='';
       } 
   } } 
}


}   













