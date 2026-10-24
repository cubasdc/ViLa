<?php  /* header('Cache-Control: public, max-age=31536000, immutable'); */ ?>
<?php if (is_user_logged_in()) { ?>
</div>
<div id="footer">
        <button class="accordion" title="accordion" id="accordion"><i class="fa fa-question-circle" ></i></button>
        <div class="panel" id="panel" tabindex="-1">
            <h3><i class="fa fa-question-circle" ></i> Ayuda</h3>
            <ul class="ayuda">
            <li>Usar la tecla "TAB" para pasar al siguiente campo.</li>
            <li>Usar juntas las teclas "SHIFT" y "TAB" para regresar un campo.</li>
            <li>Presionar "ENTER" para enviar un formulario.</li>
            <li>Usar la tecla "Ctrl" junto con el boton "Imprimir".</li>
            <li>Usar juntas las teclas "alt" + "o" para acceder al menú Ordenes.</li>
            <li>Usar juntas las teclas "alt" + "r" para acceder al menú Resultados.</li>
            </ul>
            <i class="fa fa-whatsapp" ></i> <a href="https://api.whatsapp.com/send?phone=51971363165&text=Consulta%20sobre%20el%20sistema%20ViviLab"> 971363165</a><br/>
            <i class="fa fa-phone" ></i>  971363165
        </div>

    <?php } else { ?>

    <?php } ?>

<?php if (is_user_logged_in()) { ?>
</div> <!-- fin del footer -->

   <!-- <link rel="stylesheet" href="https://unpkg.com/purecss@2.1.0/build/pure-min.css" integrity="sha384-yHIFVG6ClnONEA5yB5DJXfW2/KC173DIQrYoZMEtBvGzmf0PKiGyNEqe9N6BNDBH" crossorigin="anonymous"> -->
   <link rel="stylesheet" href="https://unpkg.com/purecss@2.1.0/build/pure-min.css" >
   <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pure/3.0.0/build/pure-min.css" > -->
    <!-- <link media="print" onload="this.media='all'" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" > -->
    <link   rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" >
    


    <?php include 'assets/script_sistema.js.php' ?>


<?php } else // para los visitantes
    
    { ?>


<?php } ?>
</body></html>