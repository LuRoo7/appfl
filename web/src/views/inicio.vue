<template>
  <div class="inicio">

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <span class="hero-subtitle">FRONTERA LIVING</span>

        <h1>
          Productos para<br>
          disfrutar la vida
        </h1>

        <p class="hero-text">
          Diseñamos productos para disfrutar en cada hogar
          y formar parte de los momentos más especiales.
        </p>

        <router-link to="/empresa" class="btn-primary">
          Conocé nuestra empresa
        </router-link>
      </div>
    </section>


    <!-- Sección Novedades -->
    <section class="novedades">

      <div class="section-title">

        <span>FRONTERA LIVING</span>

        <h2>Últimas novedades</h2>

        <p>
          Descubrí nuestros nuevos modelos, pensados para combinar
          diseño, calidad y confort.
        </p>

      </div>


      <div class="productos">

        <article class="producto-card">

          <div class="image-placeholder">
            <span>Imagen Sofá Chesterfield</span>
          </div>

          <div class="producto-info">

            <h3>Chesterfield</h3>

            <p>
              Diseño clásico y elegancia para tu hogar.
            </p>

            <router-link to="/productos" class="link-action">
              Ver producto

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>

            </router-link>

          </div>

        </article>


        <article class="producto-card">

          <div class="image-placeholder">
            <span>Imagen Sofá SOHO</span>
          </div>

          <div class="producto-info">

            <h3>SOHO</h3>

            <p>
              Comodidad y diseño en un sofá pensado para disfrutar.
            </p>

            <router-link to="/productos" class="link-action">
              Ver producto

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>

            </router-link>

          </div>

        </article>


        <article class="producto-card">

          <div class="image-placeholder">
            <span>Imagen Sofá Avril</span>
          </div>

          <div class="producto-info">

            <h3>Avril</h3>

            <p>
              Una propuesta moderna para espacios únicos.
            </p>

            <router-link to="/productos" class="link-action">
              Ver producto

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>

            </router-link>

          </div>

        </article>

      </div>

    </section>


    <!-- Sección Nosotros -->
    <section class="nosotros">

      <div class="nosotros-image-placeholder">
        <span>Imagen Fábrica / Nosotros</span>
      </div>

      <div class="nosotros-content">

        <span class="badge-subtitle">
          MÁS DE 45 AÑOS DE TRAYECTORIA
        </span>

        <h2>
          Más de 45 años creando confort
        </h2>

        <p>
          En Frontera Living nos especializamos en la fabricación
          de muebles de living de alta calidad, combinando diseño,
          innovación y confort.
        </p>

        <p>
          Nuestra fábrica se encuentra en el Parque Industrial
          de San Francisco, Córdoba, dentro de un predio de 27.300 m²
          donde trabajamos constantemente para ofrecer productos
          que acompañen cada momento de la vida.
        </p>

        <router-link to="/empresa" class="btn-primary">
          Conocé más sobre nosotros
        </router-link>

      </div>

    </section>


    <!-- Parallax Section -->
    <section class="parallax">

      <div class="parallax-box">

        <div class="parallax-content">

          <span>
            DISEÑO · CALIDAD · CONFORT
          </span>

          <h2>
            Tu hogar,<br>
            tu lugar favorito.
          </h2>

        </div>

      </div>

    </section>


    <!-- =========================================
         CONTACTO + UBICACIÓN
    ========================================== -->

    <section class="contacto">

      <!-- Información -->

      <div class="contacto-info">

        <span class="contacto-label">
          FRONTERA LIVING
        </span>

        <h2>
          Estamos
          <em>acá.</em>
        </h2>

        <p class="contacto-descripcion">
          Encontranos en nuestro Parque Industrial
          de San Francisco, Córdoba.
        </p>


        <div class="contacto-datos">

          <!-- Teléfonos -->

          <div class="contacto-dato">

            <span>TELÉFONOS</span>

            <a href="tel:+543564445900">
              +54 (3564) 445900
            </a>

            <a href="tel:+543564445955">
              +54 (3564) 445955
            </a>

            <a href="tel:+543564445888">
              +54 (3564) 445888
            </a>

          </div>


          <!-- Líneas rotativas -->

          <div class="contacto-dato">

            <span>LÍNEAS ROTATIVAS</span>

            <a href="tel:+543564431130">
              431130
            </a>

          </div>


          <!-- Dirección -->

          <div class="contacto-dato direccion">

            <span>DIRECCIÓN</span>

            <a
              href="https://www.google.com.ar/maps/place/Frontera+Living/@-31.4349744,-62.1158877,14.29z/data=!4m5!3m4!1s0x95cb288955d59421:0x67314a15dba85a6b!8m2!3d-31.4371009!4d-62.1258093"
              target="_blank"
              rel="noopener noreferrer"
            >
              Marcos Nicolini 1435
              <br>
              Parque Industrial
              <br>
              San Francisco, Córdoba
            </a>

          </div>

        </div>

      </div>


      <!-- Mapa -->

      <div class="contacto-mapa">

        <iframe
          src="https://www.google.com/maps?q=Frontera+Living,+Marcos+Nicolini+1435,+San+Francisco,+Córdoba&output=embed"
          width="100%"
          height="100%"
          style="border:0;"
          allowfullscreen
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Ubicación de Frontera Living"
        ></iframe>


        <a
          class="mapa-link"
          href="https://www.google.com.ar/maps/place/Frontera+Living/@-31.4349744,-62.1158877,14.29z/data=!4m5!3m4!1s0x95cb288955d59421:0x67314a15dba85a6b!8m2!3d-31.4371009!4d-62.1258093"
          target="_blank"
          rel="noopener noreferrer"
        >
          VER EN GOOGLE MAPS →
        </a>

      </div>

    </section>

  </div>
</template>


<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');


/* =========================================
   BASE
========================================= */

.inicio {

  width: 100%;

  font-family: 'Poppins', sans-serif;

  color: #4A4A4E;

}


/* =========================================
   HERO
========================================= */

.hero {

  width: 100%;

  min-height: calc(100vh - 80px);

  background:
    linear-gradient(
      rgba(43, 43, 46, 0.75),
      rgba(43, 43, 46, 0.85)
    ),
    url('@/assets/carrusel/frente.jpg')
    no-repeat center center / cover;

  display: flex;

  align-items: center;

  padding: 80px 10%;

}

.hero-content {

  max-width: 650px;

  color: #ffffff;

}

.hero-subtitle,
.section-title span,
.badge-subtitle,
.parallax-content span {

  font-size: 13px;

  letter-spacing: 3px;

  font-weight: 700;

  color: #EB3135;

  text-transform: uppercase;

  display: block;

  margin-bottom: 8px;

}

.hero h1 {

  margin: 15px 0 25px;

  font-size: clamp(40px, 5.5vw, 75px);

  line-height: 1.05;

  font-weight: 800;

  color: #ffffff;

}

.hero-text {

  font-size: 17px;

  line-height: 1.7;

  margin-bottom: 35px;

  color: #EDEDED;

  font-weight: 300;

}


/* =========================================
   BOTONES
========================================= */

.btn-primary {

  display: inline-flex;

  align-items: center;

  justify-content: center;

  padding: 14px 32px;

  background: #EB3135;

  color: #ffffff;

  text-decoration: none;

  font-size: 13px;

  font-weight: 600;

  text-transform: uppercase;

  letter-spacing: 1px;

  border-radius: 6px;

  border: none;

  transition: all 0.3s ease;

  box-shadow:
    0 4px 15px rgba(235, 49, 53, 0.25);

}

.btn-primary:hover {

  background: #ffffff;

  color: #4A4A4E;

  transform: translateY(-2px);

}


/* =========================================
   NOVEDADES
========================================= */

.novedades {

  width: 100%;

  padding: 100px 8%;

  background: #EDEDED;

}

.section-title {

  max-width: 600px;

  margin-bottom: 50px;

}

.section-title h2 {

  margin: 10px 0 15px;

  font-size: 40px;

  font-weight: 700;

  color: #4A4A4E;

}

.section-title p {

  color: #666;

  font-size: 16px;

  line-height: 1.6;

}

.productos {

  display: grid;

  grid-template-columns:
    repeat(auto-fit, minmax(300px, 1fr));

  gap: 30px;

}

.producto-card {

  background: #ffffff;

  border-radius: 12px;

  overflow: hidden;

  box-shadow:
    0 10px 25px rgba(0, 0, 0, 0.05);

  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease;

  border: 1px solid #BDC0C3;

}

.producto-card:hover {

  transform: translateY(-6px);

  box-shadow:
    0 15px 35px rgba(0, 0, 0, 0.1);

}

.image-placeholder {

  width: 100%;

  height: 280px;

  background-color: #BDC0C3;

  display: flex;

  align-items: center;

  justify-content: center;

  color: #4A4A4E;

  font-size: 14px;

  font-weight: 500;

  border-bottom: 1px solid #EDEDED;

}

.producto-info {

  padding: 25px;

}

.producto-info h3 {

  color: #4A4A4E;

  font-size: 22px;

  font-weight: 700;

  margin-bottom: 10px;

}

.producto-info p {

  color: #666;

  font-size: 14px;

  line-height: 1.6;

  margin-bottom: 20px;

}

.link-action {

  display: inline-flex;

  align-items: center;

  gap: 8px;

  color: #EB3135;

  text-decoration: none;

  font-size: 13px;

  font-weight: 600;

  text-transform: uppercase;

  letter-spacing: 0.5px;

  transition: gap 0.2s ease;

}

.link-action:hover {

  gap: 12px;

  color: #4A4A4E;

}


/* =========================================
   NOSOTROS
========================================= */

.nosotros {

  width: 100%;

  display: grid;

  grid-template-columns: 1fr 1fr;

  min-height: 600px;

}

.nosotros-image-placeholder {

  background: #BDC0C3;

  display: flex;

  align-items: center;

  justify-content: center;

  color: #4A4A4E;

  font-size: 15px;

  font-weight: 500;

}

.nosotros-content {

  display: flex;

  flex-direction: column;

  justify-content: center;

  padding: 80px 10%;

  background: #4A4A4E;

  color: #ffffff;

}

.nosotros-content h2 {

  font-size: 42px;

  font-weight: 700;

  line-height: 1.15;

  margin: 15px 0 25px;

  color: #ffffff;

}

.nosotros-content p {

  line-height: 1.7;

  color: #EDEDED;

  font-size: 15px;

  margin-bottom: 15px;

  font-weight: 300;

}

.nosotros-content .btn-primary {

  align-self: flex-start;

  margin-top: 20px;

}


/* =========================================
   PARALLAX
========================================= */

.parallax {

  width: 100%;

  height: 450px;

  padding: 60px 8%;

  background: #EDEDED;

}

.parallax-box {

  width: 100%;

  height: 100%;

  background: #4A4A4E;

  border-radius: 16px;

  display: flex;

  align-items: center;

  justify-content: center;

}

.parallax-content {

  background:
    rgba(255, 255, 255, 0.95);

  padding: 45px 60px;

  text-align: center;

  border-radius: 12px;

  border: 1px solid #EDEDED;

  box-shadow:
    0 10px 30px rgba(0, 0, 0, 0.1);

}

.parallax-content h2 {

  color: #4A4A4E;

  font-size: 45px;

  font-weight: 800;

  line-height: 1.1;

  margin-top: 10px;

}


/* =========================================
   CONTACTO + MAPA
========================================= */

.contacto {

  width: 100%;

  display: grid;

  grid-template-columns: 0.9fr 1.1fr;

  min-height: 650px;

  background: #EDEDED;

  overflow: hidden;

}


/* Información de contacto */

.contacto-info {

  display: flex;

  flex-direction: column;

  justify-content: center;

  padding: 100px 10%;

  background: #4A4A4E;

  color: #ffffff;

}

.contacto-label {

  margin-bottom: 25px;

  color: #EB3135;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 4px;

}

.contacto-info h2 {

  margin: 0 0 30px;

  font-size: clamp(60px, 7vw, 105px);

  line-height: 0.85;

  letter-spacing: -5px;

  font-weight: 800;

  text-transform: uppercase;

}

.contacto-info h2 em {

  color: #EB3135;

  font-style: normal;

}

.contacto-descripcion {

  max-width: 430px;

  margin: 0 0 55px;

  color: #EDEDED;

  font-size: 16px;

  line-height: 1.8;

  font-weight: 300;

}


/* Datos */

.contacto-datos {

  display: grid;

  grid-template-columns: 1fr 1fr;

  gap: 40px;

}

.contacto-dato {

  display: flex;

  flex-direction: column;

}

.contacto-dato span {

  margin-bottom: 15px;

  color: #BDC0C3;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 3px;

}

.contacto-dato a {

  width: fit-content;

  margin-bottom: 5px;

  color: #ffffff;

  font-size: 15px;

  line-height: 1.6;

  font-weight: 300;

  text-decoration: none;

  transition: color 0.3s ease;

}

.contacto-dato a:hover {

  color: #EB3135;

}


/* Dirección */

.contacto-dato.direccion {

  grid-column: 1 / -1;

}

.contacto-dato.direccion a {

  font-size: 16px;

  line-height: 1.7;

}


/* =========================================
   MAPA
========================================= */

.contacto-mapa {

  position: relative;

  min-height: 650px;

  background: #BDC0C3;

}

.contacto-mapa iframe {

  position: absolute;

  inset: 0;

  width: 100%;

  height: 100%;

  border: 0;

  filter: grayscale(100%);

}


/* Botón del mapa */

.mapa-link {

  position: absolute;

  right: 30px;

  bottom: 30px;

  z-index: 2;

  padding: 16px 22px;

  background: #EB3135;

  color: #ffffff;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 2px;

  text-decoration: none;

  transition:
    background 0.3s ease,
    transform 0.3s ease;

}

.mapa-link:hover {

  background: #4A4A4E;

  transform: translateY(-3px);

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 900px) {

  .hero {

    padding: 60px 6%;

  }

  .nosotros {

    grid-template-columns: 1fr;

  }

  .nosotros-image-placeholder {

    min-height: 300px;

  }

  .nosotros-content {

    padding: 60px 6%;

  }

  .contacto {

    grid-template-columns: 1fr;

  }

  .contacto-info {

    min-height: auto;

    padding: 90px 8%;

  }

  .contacto-mapa {

    min-height: 500px;

  }

}


@media (max-width: 600px) {

  .hero {

    padding: 40px 20px;

  }

  .novedades {

    padding: 60px 20px;

  }

  .section-title h2,
  .nosotros-content h2 {

    font-size: 32px;

  }

  .parallax {

    height: 350px;

    padding: 0;

  }

  .parallax-box {

    border-radius: 0;

  }

  .parallax-content {

    padding: 30px 20px;

    width: 85%;

  }

  .parallax-content h2 {

    font-size: 30px;

  }


  /* Contacto móvil */

  .contacto-info {

    padding: 80px 6%;

  }

  .contacto-info h2 {

    font-size: 60px;

    letter-spacing: -4px;

  }

  .contacto-descripcion {

    margin-bottom: 40px;

  }

  .contacto-datos {

    grid-template-columns: 1fr;

    gap: 30px;

  }

  .contacto-dato.direccion {

    grid-column: auto;

  }

  .contacto-mapa {

    min-height: 400px;

  }

  .mapa-link {

    right: 20px;

    bottom: 20px;

  }

}

</style>
