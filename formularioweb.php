<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */ ?>
    <header role="banner">
        <div class="container">
            <div class="logo-section">
                <div class="logo-main">
                    <span class="vivi">VIVI</span><span class="lab">LAB</span>
                </div>
               <!-- <p class="slogan">"Seguridad y confianza en tus resultados"</p> -->
                <h1 class="subtitle">Laboratorio de Análisis Clínicos y Microbiológicos en Chiclayo - Perú</h1>
               <!-- <div class="chiclayo">Chiclayo — Perú</div> -->
            </div>
        </div>
    </header>
    
    <main class="container" role="main">
        <section class="form-section" aria-labelledby="form-heading">
            <h2 id="form-heading" class="form-title">Consulta tus resultados en línea</h2>
            <p class="form-subtitle">Ingresa los datos solicitados para acceder a tus resultados.</p>
            <div class="separator"></div>
            
            <form method="post" class="results-form" id="resultsForm">
               
                
                <div class="form-group">
                    <label for="dniweb">Número de documento (DNI/CE)</label>
                    <input type="text" id="dniweb" name="dniweb" placeholder="Ingrese su número de documento" required autocomplete="off"  class="validate">
                </div>
               
                <div class="form-group">
                    <label for="ordenweb">Número de orden</label>
                    <input type="text" id="ordenweb" name="ordenweb" placeholder="Ej: 20202020" required autocomplete="off"  class="validate" >
                </div>


                <button type="submit" class="submit-btn"  name="accion" value="pdfweb" onclick="return confirm('Acepte para iniciar la descarga de sus resultados en formato PDF.');" >Consultar Resultados</button>
                <p class="form-note">* Resultados disponibles según tiempo indicado en toma de muestra.</p>
            </form>
        </section>
        
        <section class="video-section" aria-labelledby="video-heading">
            <h2 id="video-heading" class="video-title">Conoce más sobre VIVILAB</h2>
            <div class="separator"></div>
            
            <div class="video-container tiktok-wrapper">
               <lite-tiktok videoid="7363729151083171078" ></lite-tiktok>
             
            </div>
            
            <p style="text-align:center; margin-top: 20px; color: #666; font-size: 0.9rem;">
                <a href="https://www.tiktok.com/@vivilab2009" target="_blank" rel="noopener noreferrer" style="color: var(--primary); font-weight: 600;">Visitar @vivilab2009 en TikTok</a>
            </p>
        </section>
        
        <section class="services-section" aria-labelledby="services-heading">
            <h2 id="services-heading" class="section-title">Servicios y Exámenes</h2>
            <div class="separator"></div>
            
            <div class="services-grid">
                <div class="service-card">
                    <h3>Exámenes de Hormonas</h3>
                    <ul><li>Hormonas tiroideas</li><li>Hormonas sexuales</li><li>Cortisol</li><li>Insulina</li></ul>
                </div>
                <div class="service-card">
                    <h3>Marcadores Tumorales</h3>
                    <ul><li>CA125</li><li>CA19-9</li><li>PSA total y libre</li><li>CEA</li></ul>
                </div>
                <div class="service-card">
                    <h3>Pruebas de Rutina</h3>
                    <ul><li>Glucosa</li><li>Orina completa</li><li>Colesterol total</li><li>Triglicéridos</li></ul>
                </div>
                <div class="service-card">
                    <h3>Perfiles Especializados</h3>
                    <ul><li>Perfil lipídico</li><li>Perfil hepático</li><li>Perfil preoperatorio</li><li>Hemograma completo</li></ul>
                </div>
                <div class="service-card">
                    <h3>Otras Pruebas</h3>
                    <ul><li>Urea y creatinina</li><li>PCR</li><li>Grupo sanguíneo</li><li>Tiempo de coagulación</li></ul>
                </div>
                <div class="service-card">
                    <h3>Pruebas Especiales</h3>
                    <ul><li>Pruebas de embarazo</li><li>Alergias</li><li>Infecciosas</li><li>COVID-19</li></ul>
                </div>
            </div>
            
            <div class="home-service">
                <h3>🏠 TOMA DE MUESTRAS A DOMICILIO</h3>
                <p>Comodidad y seguridad en tu hogar. Solicita nuestro servicio.</p>
                <p style="margin-top: 10px; font-weight: 600; color: #115492;">Chiclayo y distritos aledaños</p>
            </div>
        </section>

        <section class="location-section" aria-labelledby="map-heading">
            <h2 id="map-heading" class="video-title">Ubicación</h2>
            <div class="separator"></div>
            
            <div class="video-container map-wrapper">
                <iframe 
                    title="Ubicación del laboratorio ViviLab, Chiclayo" 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.836750341757!2d-79.8364736!3d-6.7750849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x904cef02b8686731%3A0x6b4f73827593649!2sCalle%20La%20Florida%20202%2C%20Chiclayo%2014001!5e0!3m2!1ses-419!2spe!4v1715640000000!5m2!1ses-419!2spe" 
                    loading="lazy"
                    allowfullscreen="" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <p style="text-align: center; margin-top: 20px; color: #666; font-size: 0.9rem;">
                Dirección: Clínica Chiclayo, 2do Piso Consultorio 202, Calle La Florida Urb. Santa Victoria, Chiclayo
            </p>
        </section>
        
        <section class="contact-section" aria-labelledby="contact-heading">
            <h2 id="contact-heading" class="section-title" style="color: white;">Contacto y Horarios</h2>
            <div class="separator" style="background: white;"></div>
            
            <div class="contact-grid">
                <div class="info-column">
                    <div class="contact-item">
                        <div class="contact-icon" aria-hidden="true">📞</div>
                        <div class="contact-text">
                            <h3>Teléfonos</h3>
                            <p><a href="tel:+51923108568" style="text-decoration: underline;">923 108 568</a> / 968 835 223</p>
                            <p>(074) 237114</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon" aria-hidden="true">✉️</div>
                        <div class="contact-text">
                            <h3>Email</h3>
                            <p><a href="mailto:vivilab2009@hotmail.com">vivilab2009@hotmail.com</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon" aria-hidden="true">📍</div>
                        <div class="contact-text">
                            <h3>Dirección</h3>
                            <p>Clínica Chiclayo Consultorio 202 (2do piso)</p>
                            <p>Calle La Florida - Urb. Santa Victoria</p>
                            
                        </div>
                    </div>
                </div>
                
                <div class="schedule-column">
                    <div class="contact-item">
                        <div class="contact-icon" aria-hidden="true">🕒</div>
                        <div class="contact-text">
                            <h3>Horario Normal</h3>
                            <p>Lunes a domingo: 7:00 AM - 8:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="schedule">
                        <h3>🌙 Atención 24 Horas</h3>
                        <p>Personal disponible fuera del horario</p>
                        <span class="highlight">Servicio 24/7</span>
                    </div>
                </div>
            </div>
            
            <div class="social-links">
                <a href="https://web.facebook.com/ViviLabChiclayo" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Síguenos en Facebook">f</a>
                <a href="https://www.tiktok.com/@vivilab2009" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Síguenos en TikTok">t</a>
                <a href="https://wa.me/51923108568" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Contáctanos por WhatsApp">w</a>
                <a href="mailto:vivilab2009@hotmail.com" class="social-link" aria-label="Envíanos un correo">✉</a>
            </div>
        </section>
    </main>
    
    <footer role="contentinfo">
        <div class="container">
            <span class="footer-logo">
                <span class="vivi">VIVI</span><span class="lab">LAB</span>
            </span>
            <a href="https://vivilabchiclayo.com" class="url">vivilabchiclayo.com</a>
            <p>Laboratorio de Análisis Clínicos y Microbiológicos en Chiclayo — Perú</p>
            <p class="copyright">© <script>document.write(new Date().getFullYear());</script> VIVILAB Chiclayo. Todos los derechos reservados. • <span  class="webmaster">Web developer: <a title="webmaster: +51971363165" href="https://api.whatsapp.com/send?phone=+51971363165&text=Servicio%20de%20desarrollo%20de%20p%C3%A1ginas%20web.%0A%20Precios%20desde%20$100%20al%20a%C3%B1o.%0A%20Consultas%20sin%20compromiso.">JorgeCubas</a></span></p>
           
        </div>
    </footer>
 
<script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84q0uHVRRxEtvFPiQYbXWUorga2aqZJ0z"></script>