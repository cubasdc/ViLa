<?php header('Cache-Control: public, max-age=31536000, immutable'); ?>
<!DOCTYPE html>
<html lang="es-PE">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google" content="notranslate">
    

    <?php if (is_user_logged_in()) : ?>
        <!-- =========================================== -->
        <!-- SECCIÓN PARA USUARIOS AUTENTICADOS (SISTEMA) -->
        <!-- =========================================== -->
        
        <?php // include 'assets/style_sistema.css.php' // Alternativa comentada ?>
        
    <meta http-equiv="Cache-control" content="public, max-age=31536000">
        <!-- CSS principal del sistema (carga asíncrona) -->
        <link rel="stylesheet" href="<?= get_bloginfo('template_url'); ?>/assets/style_sistema.css">
        

        
        <!-- jQuery 3.6.0 desde CDN con integridad SRI (Subresource Integrity) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
                crossorigin="anonymous"></script>
        

        <link  rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
        <!-- jQuery UI desde CDN con SRI -->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" 
                integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" 
                crossorigin="anonymous"></script>
        
        <!-- Select2 CSS desde CDN, con estaba hasta 24/6/2026
        <link rel="stylesheet" 
              href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" 
                integrity="sha256-9yRP/2EFlblE92vzCA10469Ctd0jT48HnmmMw5rJZrA=" 
                crossorigin="anonymous"></script>

                -->


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js">
</script>                
        
        <!-- 
        Biblioteca PureCSS comentada (opciones modulares):
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.6/pure-min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.6/buttons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.6/menus-horizontal.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.6/forms-nr-min.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/2.0.6/tables-min.css">
        -->
        
        <title>Sistema ViviLab</title>

    <?php else : ?>
     
    <link rel="canonical" href="https://vivilabchiclayo.com/" >
    <title>ViviLab - Análisis de laboratorio en Chiclayo</title>
    <meta name="description" content="Toma de muestras a domicilio, resultados en línea, análisis de cortisol, insulina, orina, colesterol, preoperatorio, hemograma, urea, creatinina, PSA">
    
    <meta property="og:site_name" content="Laboratorio ViviLab Chiclayo"/>
    <meta property="og:title" content="Análisis de laboratorio en Chiclayo">
    <meta property="og:description" content="Toma de muestras a domicilio, resultados en línea, análisis de cortisol, insulina, orina, colesterol, preoperatorio, hemograma, urea, creatinina, PSA">
    
    <meta name="author" content="Laboratorio ViviLab Chiclayo">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
     <meta property="og:url" content="https://vivilabchiclayo.com/">
       
     
    <meta property="og:image:alt" content="ViviLab - Análisis de laboratorio en Chiclayo"/>
    <meta name="twitter:title" content="ViviLab - Análisis de laboratorio en Chiclayo"/>
    <meta property="og:locale" content="es_PE">

    <meta name="theme-color" content="#1976d2">
    <!-- <meta charset="UTF-8"> -->
    
    
    
    
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
        <link rel="preconnect" href="https://www.tiktok.com">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalBusiness",
      "name": "ViviLab - Análisis de laboratorio en Chiclayo",
      "image": "",
      "description": "Toma de muestras a domicilio, resultados en línea, análisis de cortisol, insulina, orina, colesterol, preoperatorio, hemograma, urea, creatinina, PSA",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Calle La Florida Urb. Santa Victoria, Clínica Chiclayo, 2do Piso Consultorio 202",
        "addressLocality": "Chiclayo",
        "addressRegion": "Lambayeque",
        "postalCode": "14001",
        "addressCountry": "PE"
      },
      "telephone": "+51923108568",
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
          "opens": "07:00",
          "closes": "20:00"
        }
      ],
      "url": "https://vivilabchiclayo.com"
    }
    </script>

    <style>
        /* CSS Reset & Variables */
        :root {
            --primary: #1976d2;
            --primary-dark: #0d47a1;
            --secondary: #4fc3f7;
            --bg-color: #f0f8ff;
            --text-main: #333;
            --text-light: #666;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-main); line-height: 1.6; display: flex; flex-direction: column; min-height: 100vh; }
        
        /* Utility */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; width: 100%; }
        .separator { height: 4px; width: 150px; background: linear-gradient(to right, var(--secondary), var(--primary)); margin: 20px auto; border-radius: 2px; }
        a { text-decoration: none; color: inherit; }

        /* Header */
        header { background: linear-gradient(135deg, #ffffff 0%, #e6f7ff 100%); padding: 30px 0; border-bottom: 3px solid var(--secondary); box-shadow: var(--shadow); }
        .logo-section { text-align: center; }
        .logo-main { font-size: clamp(3.5rem, 8vw, 7rem); font-weight: 800; letter-spacing: 2px; line-height: 1.1; margin-bottom: 10px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); }
        .vivi { color: var(--secondary); }
        footer .vivi { color: #fff; }
        header .lab  { color: var(--primary); }
        footer .lab  { color:#fff;}
        .slogan { font-size: clamp(1.1rem, 3vw, 1.5rem); color: var(--primary); font-weight: 600; font-style: italic; }
        .subtitle { font-size: 1.2rem; color: #444; font-weight: 500; margin-top: 5px; }
        .chiclayo { font-size: 1.4rem; color: #10528E;/*var(--primary);*/ font-weight: 600; background-color: #e6f7ff; padding: 5px 15px; border-radius: 20px; display: inline-block; margin-top: 10px; }

        /* Sections General */
        section { background-color: var(--white); border-radius: 15px; padding: 40px; margin: 40px 0; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); }
        .section-title, .form-title, .video-title { color: var(--primary); font-size: clamp(1.8rem, 4vw, 2.2rem); text-align: center; margin-bottom: 10px; }
        
        /* Form */
        .form-section { border-top: 5px solid var(--primary); }
        .form-subtitle { text-align: center; color: var(--text-light); margin-bottom: 30px; }
        .results-form { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
        .form-group input { width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 10px; font-size: 1.1rem; transition: border-color 0.3s; }
        .form-group input:focus { border-color: var(--secondary); outline: none; box-shadow: 0 0 0 3px rgba(79, 195, 247, 0.2); }
        
        .submit-btn { background: linear-gradient(to right, var(--secondary), var(--primary)); color: white; border: none; padding: 18px 40px; font-size: 1.2rem; font-weight: 600; border-radius: 10px; cursor: pointer; width: 100%; transition: transform 0.2s, box-shadow 0.2s; }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(25, 118, 210, 0.3); }
        .submit-btn:active { transform: translateY(0); }
        .form-note { text-align: center; margin-top: 20px; color: var(--text-light); font-size: 0.9rem; font-style: italic; }

        /* Video & Map Containers (Aspect Ratio Fix for CLS) */
        .video-container, .map-container { position: relative; width: 100%; overflow: hidden; border-radius: 15px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); background-color: #eee; }
        .tiktok-wrapper { max-width: 350px; margin: 0 auto; aspect-ratio: 9/16; }
        .map-wrapper { aspect-ratio: 16/9; max-height: 400px; }
        iframe { width: 100%; height: 100%; border: 0; display: block; }
        
        /* Services */
        .services-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .service-card { background-color: #f8fdff; border-radius: 10px; padding: 20px; border-left: 4px solid var(--secondary); transition: transform 0.3s; }
        .service-card:hover { transform: translateY(-3px); }
        .service-card h3 { color: var(--primary); margin-bottom: 10px; font-size: 1.3rem; }
        .service-card ul { list-style: none; }
        .service-card li { padding: 5px 0 5px 25px; position: relative; }
        .service-card li:before { content: "✓"; color: var(--secondary); font-weight: bold; position: absolute; left: 0; }
        
        .home-service { background-color: #e6f7ff; border-radius: 10px; padding: 25px; text-align: center; border: 2px solid var(--secondary); margin-top: 20px; }
        .home-service h3 { color: #115492; font-size: 1.5rem; margin-bottom: 10px; }

        /* Contact */
        .contact-section { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; }
        .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; }
        .contact-item { display: flex; align-items: flex-start; margin-bottom: 20px; }
        .contact-icon { background-color: rgba(255, 255, 255, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0; font-size: 1.5rem; }
        .contact-text h3 { font-size: 1.2rem; margin-bottom: 5px; opacity: 0.9; }
        .contact-text p { font-size: 1rem; }
        
        .social-links { display: flex; justify-content: center; gap: 15px; margin-top: 30px; flex-wrap: wrap; }
        .social-link { display: flex; align-items: center; justify-content: center; width: 50px; height: 50px; background-color: white; color: var(--primary); border-radius: 50%; font-size: 1.5rem; transition: transform 0.3s, background-color 0.3s; font-weight: bold; }
        .social-link:hover, .social-link:focus { transform: translateY(-3px); background-color: var(--secondary); color: white; outline: 3px solid rgba(255,255,255,0.5); }
        
        .schedule { background-color: rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 20px; text-align: center; height: auto; display: flex; flex-direction: column; justify-content: center; }
        .highlight { color: #ffeb3b; font-weight: bold; margin-top: 5px; display: block; }

        /* Footer */
        footer { background-color: var(--primary-dark); color: white; padding: 40px 0; text-align: center; margin-top: auto; }
        .footer-logo { font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; display: block; }
        .url { color: #E8E8E8 ;/*var(--secondary);*/ font-weight: 600; margin: 10px 0; display: block; }
        .copyright { color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; margin-top: 20px; }

        /* Modal */
        .confirmation { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(5px); }
        .confirmation-content { background-color: white; padding: 40px; border-radius: 15px; max-width: 500px; width: 90%; text-align: center; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3); border-top: 5px solid var(--secondary); animation: fadeIn 0.3s ease-out; }
        .confirmation h2 { color: var(--primary); margin-bottom: 20px; }
        .close-btn { background-color: var(--primary); color: white; border: none; padding: 12px 30px; border-radius: 8px; cursor: pointer; font-size: 1rem; margin-top: 20px; }
        .close-btn:hover { background-color: var(--primary-dark); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            section { padding: 25px; margin: 20px 0; }
            header { padding: 20px 0; }
        }

  .webmaster {
   
           
            font-style: italic;
        }
.webmaster a {text-decoration: underline;}
    </style>

 <link data-default-icon="https://favicon-generator.org/favicon-generator/htdocs/favicons/2016-10-20/dd88b45aa6e66f4ade5461d80eac8f89.ico" 
          data-badged-icon="https://favicon-generator.org/favicon-generator/htdocs/favicons/2016-10-20/dd88b45aa6e66f4ade5461d80eac8f89.ico" 
          rel="shortcut icon" 
          href="https://favicon-generator.org/favicon-generator/htdocs/favicons/2016-10-20/dd88b45aa6e66f4ade5461d80eac8f89.ico">   

      
        


        <script type="module" src="https://cdn.jsdelivr.net/npm/@justinribeiro/lite-tiktok@0.1.0/lite-tiktok.js"></script>


    <?php endif; ?>
</head>

<body>
        <?php if (is_user_logged_in()) : ?>
    
            <?php    
        // Obtiene información del usuario actual
            $current_user = wp_get_current_user();
            ?>
            
        <!-- Cabecera del sistema/sitio -->
        <div id="head">

            <!-- Menú de navegación del sistema -->
            <div class="pure-menu pure-menu-horizontal">
                <!-- Botones de navegación histórica -->
                <button onclick="history.back()" class="pure-button">&lt;&lt;</button>
                <button onclick="history.go(1)" class="pure-button">&gt;&gt;</button>
                
                <ul class="pure-menu-list">
                    
                    <!-- ORDENES -->
                    <li class="pure-menu-item">
                        <form method="post" class="pure-form">
                            &nbsp;&nbsp;
                            <button name="accion" value="Ordenes" type="submit" class="pure-button" accesskey="o">
                                <i class="fa fa-flask" aria-hidden="true"></i> 
                                Ordenes (alt+o)
                            </button>
                            <input type="hidden" name="control" value="Orden">
                        </form>
                    </li>
                    
                    <!-- RESULTADOS -->
                    <li class="pure-menu-item">
                        <form method="post" class="pure-form">
                            <button name="accion" value="Resultados" type="submit" class="pure-button" accesskey="r">
                                <i class="fa fa-table" aria-hidden="true"></i> 
                                Resultados (alt+r)
                            </button>
                            <input type="hidden" name="control" value="Resultado">
                        </form>
                    </li>
                    
                    <!-- REPORTES/IMPRESIONES -->
                    <li class="pure-menu-item">
                        <form method="post" class="pure-form">
                            <button name="accion" value="Reportes" type="submit" class="pure-button" accesskey="i">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i> 
                                Impresiones (alt+i)
                            </button>
                            <input type="hidden" name="control" value="Resultado">
                        </form>
                    </li>
                    
                    <!-- CATÁLOGO -->
                    <li class="pure-menu-item">
                        <form method="post" class="pure-form">
                            <button name="accion" value="" type="submit" class="pure-button">
                                <i class="fa fa-database" aria-hidden="true"></i> 
                                Catálogo de análisis
                            </button>
                            <input type="hidden" name="control" value="Catalogo">
                        </form>
                    </li>
                    
                    <!-- USUARIO -->
                    <li class="pure-menu-item">
                        <form method="post" class="pure-form">
                            <?php
                            // Determina el texto según el nivel de usuario
                            $user_text = ($current_user->ID <= 2) ? 'Usuarios' : 'Usuario';
                            ?>
                            <button name="accion" value="<?= $user_text ?>" type="submit" class="pure-button" 
                                    title="Cambiar contraseña de usuario">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                <?= esc_html($current_user->user_login) ?>
                            </button>
                            <input type="hidden" name="control" value="Usuario">
                        </form>
                    </li>
                    
                    <!-- ESTADÍSTICAS (solo para admin) -->
                    <?php if ($current_user->ID <= 2) : ?>
                        <li class="pure-menu-item">
                            <form method="post" class="pure-form">
                                <button name="accion" value="" type="submit" class="pure-button" title="Estadisticas">
                                    <i class="fa fa-flag"></i>
                                </button>
                                <input type="hidden" name="control" value="Estadisticas">
                            </form>
                        </li>
                    <?php endif; ?>
                    
                    <!-- CERRAR SESIÓN -->
                    <li class="pure-menu-item">
                        <a accesskey="s" 
                           onclick="return confirm('Acepte para salir del sistema.\n(Se perderán los datos que no haya guardado)');"
                           title="Cerrar sistema" 
                           class="pure-button" 
                           href="<?= esc_url(wp_logout_url(home_url() . '/sistema')) ?>">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> 
                            (alt+s)
                        </a>
                    </li>
                    
                </ul>
            </div><!-- /.pure-menu -->
            
   
    </div><!-- /#head -->
    
    <!-- Contenedor principal del contenido -->
    <div id="contenedor">
        <?php endif; ?>
   