<template>
  <main class="contacto-page">

    <section class="hero-contacto">
      <div class="hero-content">

        <span class="hero-tag">FRONTERA LIVING</span>

        <h1>
          Estamos para<br>
          <strong>escucharte.</strong>
        </h1>

        <p>
          Si tenés una consulta, querés conocer nuestros productos
          o necesitás asesoramiento, estamos acá para ayudarte.
        </p>

      </div>

      <div class="hero-decoration"></div>
      <div class="hero-line"></div>
    </section>


    <section class="contacto-main">

      <div class="contacto-intro">
        <span>CONTACTO</span>

        <h2>Hablemos</h2>

        <p>
          Completá el formulario y nuestro equipo se pondrá en contacto
          con vos a la brevedad.
        </p>
      </div>


      <div class="contacto-layout">

        <!-- FORMULARIO -->
        <div class="form-section">

          <form
            @submit.prevent="enviarFormulario"
            class="contacto-form"
          >

            <div class="form-row">

              <div class="form-group">
                <label for="nombre">
                  Nombre y Apellido
                </label>

                <input
                  type="text"
                  id="nombre"
                  v-model="form.nombre"
                  placeholder="Escribí tu nombre"
                  required
                />
              </div>


              <div class="form-group">
                <label for="email">
                  Correo Electrónico
                </label>

                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  placeholder="ejemplo@correo.com"
                  required
                />
              </div>

            </div>


            <div class="form-row">

              <div class="form-group">
                <label for="telefono">
                  Teléfono
                </label>

                <input
                  type="tel"
                  id="telefono"
                  v-model="form.telefono"
                  placeholder="Tu número de teléfono"
                />
              </div>


              <div class="form-group">
                <label for="asunto">
                  Asunto
                </label>

                <input
                  type="text"
                  id="asunto"
                  v-model="form.asunto"
                  placeholder="Motivo de tu consulta"
                />
              </div>

            </div>


            <div class="form-group">

              <label for="mensaje">
                Mensaje
              </label>

              <textarea
                id="mensaje"
                rows="6"
                v-model="form.mensaje"
                placeholder="Contanos cómo podemos ayudarte..."
                required
              ></textarea>

            </div>


            <div class="form-bottom">

              <p>
                Te responderemos a la brevedad.
              </p>

              <button
                type="submit"
                class="btn-submit"
                :disabled="cargando"
              >

                <span>
                  {{ cargando ? 'Enviando...' : 'Enviar mensaje' }}
                </span>

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="19"
                  height="19"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <line
                    x1="5"
                    y1="12"
                    x2="19"
                    y2="12"
                  ></line>

                  <polyline
                    points="12 5 19 12 12 19"
                  ></polyline>
                </svg>

              </button>

            </div>

          </form>


          <!-- MENSAJES -->
          <div
            v-if="mensajeExito"
            class="alerta exito"
          >
            {{ mensajeExito }}
          </div>

          <div
            v-if="mensajeError"
            class="alerta error"
          >
            {{ mensajeError }}
          </div>

        </div>


        <!-- INFORMACIÓN -->
        <aside class="contacto-info">

          <div class="info-header">

            <span>FRONTERA LIVING</span>

            <h3>
              Encontranos
            </h3>

          </div>


          <!-- UBICACIÓN -->
          <div class="info-item">

            <div class="info-icon">

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="21"
                height="21"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path
                  d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0Z"
                ></path>

                <circle
                  cx="12"
                  cy="10"
                  r="3"
                ></circle>

              </svg>

            </div>


            <div>

              <small>
                UBICACIÓN
              </small>

              <p>
                Marcos Nicolini 1435<br>
                Parque Industrial<br>
                San Francisco, Córdoba
              </p>

            </div>

          </div>


          <!-- TELÉFONOS -->
          <div class="info-item">

            <div class="info-icon">

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="21"
                height="21"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path
                  d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.19 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.1 4.38 2 2 0 0 1 4.11 2.2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 10a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"
                ></path>
              </svg>

            </div>


            <div>

              <small>
                TELÉFONOS
              </small>

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

          </div>


          <!-- LÍNEAS ROTATIVAS -->
          <div class="info-item">

            <div class="info-icon">

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="21"
                height="21"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <circle
                  cx="12"
                  cy="12"
                  r="9"
                ></circle>

                <path
                  d="M12 7v5l3 2"
                ></path>

              </svg>

            </div>


            <div>

              <small>
                LÍNEAS ROTATIVAS
              </small>

              <p>
                431130
              </p>

            </div>

          </div>


          <!-- HORARIO -->
          <div class="info-item">

            <div class="info-icon">

              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="21"
                height="21"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <circle
                  cx="12"
                  cy="12"
                  r="9"
                ></circle>

                <polyline
                  points="12 7 12 12 15 14"
                ></polyline>

              </svg>

            </div>


            <div>

              <small>
                HORARIO DE ATENCIÓN
              </small>

              <p>
                Lunes a viernes<br>
                08:00 a 17:00 hs
              </p>

            </div>

          </div>


          <!-- GOOGLE MAPS -->
          <a
            class="map-link"
            href="https://www.google.com.ar/maps/place/Frontera+Living/@-31.4349744,-62.1158877,14.29z/data=!4m5!3m4!1s0x95cb288955d59421:0x67314a15dba85a6b!8m2!3d-31.4371009!4d-62.1258093"
            target="_blank"
            rel="noopener noreferrer"
          >

            <span>
              Ver ubicación en Google Maps
            </span>

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="18"
              height="18"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <line
                x1="5"
                y1="12"
                x2="19"
                y2="12"
              ></line>

              <polyline
                points="12 5 19 12 12 19"
              ></polyline>

            </svg>

          </a>

        </aside>

      </div>

    </section>


    <!-- MAPA -->
    <section class="map-section">

      <div class="map-title">

        <span>VISITANOS</span>

        <h2>
          Estamos acá.
        </h2>

      </div>


      <div class="map-container">

        <iframe
          src="https://www.google.com/maps?q=Frontera+Living,+Marcos+Nicolini+1435,+San+Francisco,+Córdoba&output=embed"
          width="100%"
          height="100%"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>

      </div>

    </section>

  </main>
</template>


<script>
export default {

  name: 'ContactoView',

  data() {

    return {

      form: {
        nombre: '',
        email: '',
        telefono: '',
        asunto: '',
        mensaje: ''
      },

      cargando: false,

      mensajeExito: '',

      mensajeError: ''

    };

  },


  methods: {

    async enviarFormulario() {

      this.cargando = true;

      this.mensajeExito = '';

      this.mensajeError = '';


      try {

        const response = await fetch(
          'http://localhost/conexion/contacto.php',
          {
            method: 'POST',

            headers: {
              'Content-Type': 'application/json'
            },

            body: JSON.stringify(this.form)
          }
        );


        const data = await response.json();


        if (
          response.ok &&
          data.status === 'success'
        ) {

          this.mensajeExito =
            '¡Mensaje enviado con éxito! Nos pondremos en contacto pronto.';


          this.form = {
            nombre: '',
            email: '',
            telefono: '',
            asunto: '',
            mensaje: ''
          };

        } else {

          this.mensajeError =
            data.message ||
            'Ocurrió un error al enviar el formulario.';

        }

      } catch (error) {

        this.mensajeError =
          'No se pudo conectar con el servidor. Verifica tu conexión PHP/XAMPP.';

      } finally {

        this.cargando = false;

      }

    }

  }

};
</script>


<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');



.contacto-page {

  width: 100%;

  background: #ffffff;

  color: #4A4A4E;

  font-family: 'Poppins', sans-serif;

}



.hero-contacto {

  position: relative;

  min-height: 500px;

  display: flex;

  align-items: center;

  padding: 100px 10%;

  background: #4A4A4E;

  overflow: hidden;

}


.hero-decoration {

  position: absolute;

  right: -80px;

  top: 0;

  width: 45%;

  height: 100%;

  background: #444448;

  clip-path: polygon(
    30% 0,
    100% 0,
    100% 100%,
    0 100%
  );

}


.hero-contacto::after {

  content: "";

  position: absolute;

  right: 9%;

  top: 0;

  width: 5px;

  height: 100%;

  background: #EB3135;

}


.hero-content {

  position: relative;

  z-index: 2;

  max-width: 700px;

}


.hero-tag {

  display: block;

  margin-bottom: 25px;

  color: #EB3135;

  font-size: 13px;

  font-weight: 700;

  letter-spacing: 4px;

}


.hero-content h1 {

  margin: 0 0 30px;

  color: #ffffff;

  font-size: clamp(52px, 7vw, 90px);

  line-height: 0.98;

  font-weight: 300;

  letter-spacing: -3px;

}


.hero-content h1 strong {

  font-weight: 700;

}


.hero-content p {

  max-width: 560px;

  margin: 0;

  color: #EDEDED;

  font-size: 17px;

  line-height: 1.8;

  font-weight: 300;

}


.hero-line {

  position: absolute;

  left: 10%;

  bottom: 0;

  width: 100px;

  height: 5px;

  background: #EB3135;

  z-index: 3;

}



.contacto-main {

  padding: 110px 10% 120px;

  background: #EDEDED;

}


.contacto-intro {

  max-width: 650px;

  margin-bottom: 65px;

}


.contacto-intro span {

  color: #EB3135;

  font-size: 12px;

  font-weight: 700;

  letter-spacing: 3px;

}


.contacto-intro h2 {

  margin: 12px 0 15px;

  color: #4A4A4E;

  font-size: clamp(38px, 5vw, 58px);

  line-height: 1;

  font-weight: 700;

}


.contacto-intro p {

  max-width: 550px;

  margin: 0;

  color: #666666;

  font-size: 15px;

  line-height: 1.7;

  font-weight: 300;

}



.contacto-layout {

  display: grid;

  grid-template-columns: 1.45fr 0.75fr;

  gap: 70px;

  align-items: start;

}


.form-section {

  padding: 50px;

  background: #ffffff;

  border-left: 4px solid #EB3135;

}


.contacto-form {

  display: flex;

  flex-direction: column;

  gap: 28px;

}


.form-row {

  display: grid;

  grid-template-columns: 1fr 1fr;

  gap: 25px;

}


.form-group {

  display: flex;

  flex-direction: column;

  gap: 9px;

}


.form-group label {

  color: #4A4A4E;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 1.5px;

  text-transform: uppercase;

}


.form-group input,
.form-group textarea {

  width: 100%;

  padding: 15px 0;

  border: none;

  border-bottom: 1px solid #BDC0C3;

  border-radius: 0;

  outline: none;

  background: transparent;

  color: #4A4A4E;

  font-family: 'Poppins', sans-serif;

  font-size: 14px;

  transition: border-color 0.3s ease;

}


.form-group textarea {

  resize: vertical;

  min-height: 130px;

}


.form-group input::placeholder,
.form-group textarea::placeholder {

  color: #999999;

}


.form-group input:focus,
.form-group textarea:focus {

  border-bottom-color: #EB3135;

}



.form-bottom {

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 25px;

  margin-top: 15px;

}


.form-bottom p {

  margin: 0;

  color: #888888;

  font-size: 12px;

  font-weight: 300;

}


.btn-submit {

  display: inline-flex;

  align-items: center;

  justify-content: center;

  gap: 15px;

  padding: 16px 28px;

  background: #EB3135;

  color: #ffffff;

  border: none;

  cursor: pointer;

  font-family: 'Poppins', sans-serif;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 1.5px;

  text-transform: uppercase;

  transition: all 0.3s ease;

}


.btn-submit:hover:not(:disabled) {

  background: #4A4A4E;

  transform: translateX(4px);

}


.btn-submit:disabled {

  opacity: 0.6;

  cursor: not-allowed;

}



.alerta {

  margin-top: 25px;

  padding: 15px 20px;

  font-size: 13px;

  font-weight: 500;

}


.alerta.exito {

  background: #EDEDED;

  color: #4A4A4E;

  border-left: 4px solid #EB3135;

}


.alerta.error {

  background: #ffebee;

  color: #c62828;

  border-left: 4px solid #c62828;

}



.contacto-info {

  padding: 45px 40px;

  background: #4A4A4E;

  color: #ffffff;

}


.info-header {

  padding-bottom: 30px;

  margin-bottom: 30px;

  border-bottom: 1px solid rgba(255,255,255,0.15);

}


.info-header span {

  color: #EB3135;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 2px;

}


.info-header h3 {

  margin: 8px 0 0;

  color: #ffffff;

  font-size: 30px;

  font-weight: 600;

}


.info-item {

  display: flex;

  gap: 16px;

  margin-bottom: 30px;

}


.info-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  width: 42px;

  min-width: 42px;

  height: 42px;

  background: rgba(235,49,53,0.12);

  color: #EB3135;

}


.info-item small {

  display: block;

  margin-bottom: 6px;

  color: #BDC0C3;

  font-size: 9px;

  font-weight: 700;

  letter-spacing: 1.5px;

}


.info-item p {

  margin: 0;

  color: #EDEDED;

  font-size: 13px;

  line-height: 1.7;

  font-weight: 300;

}


.info-item a {

  display: block;

  width: fit-content;

  color: #EDEDED;

  text-decoration: none;

  font-size: 13px;

  line-height: 1.8;

  transition: color 0.2s ease;

}


.info-item a:hover {

  color: #EB3135;

}



.map-link {

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 15px;

  margin-top: 15px;

  padding-top: 25px;

  border-top: 1px solid rgba(255,255,255,0.15);

  color: #ffffff;

  text-decoration: none;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 1px;

  text-transform: uppercase;

  transition: color 0.3s ease;

}


.map-link:hover {

  color: #EB3135;

}


.map-link svg {

  transition: transform 0.3s ease;

}


.map-link:hover svg {

  transform: translateX(5px);

}


.map-section {

  padding: 110px 10% 0;

  background: #ffffff;

}


.map-title {

  margin-bottom: 35px;

}


.map-title span {

  color: #EB3135;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 3px;

}


.map-title h2 {

  margin: 10px 0 0;

  color: #4A4A4E;

  font-size: clamp(35px, 4vw, 52px);

  font-weight: 700;

}


.map-container {

  width: 100%;

  height: 480px;

  overflow: hidden;

  border-top: 5px solid #EB3135;

}


.map-container iframe {

  display: block;

  width: 100%;

  height: 100%;

}



@media (max-width: 1000px) {

  .contacto-layout {

    grid-template-columns: 1fr;

    gap: 40px;

  }

}


@media (max-width: 700px) {

  .hero-contacto {

    min-height: 480px;

    padding: 80px 7%;

  }


  .hero-decoration {

    width: 30%;

  }


  .hero-contacto::after {

    right: 5%;

    width: 4px;

  }


  .hero-content h1 {

    font-size: 55px;

    letter-spacing: -2px;

  }


  .contacto-main {

    padding: 75px 7%;

  }


  .contacto-intro {

    margin-bottom: 40px;

  }


  .form-section {

    padding: 30px 25px;

  }


  .form-row {

    grid-template-columns: 1fr;

    gap: 28px;

  }


  .form-bottom {

    flex-direction: column;

    align-items: stretch;

  }


  .btn-submit {

    width: 100%;

  }


  .contacto-info {

    padding: 35px 25px;

  }


  .map-section {

    padding: 75px 7% 0;

  }


  .map-container {

    height: 350px;

  }

}


@media (max-width: 450px) {

  .hero-contacto {

    padding: 70px 5%;

  }


  .hero-content h1 {

    font-size: 46px;

  }


  .hero-content p {

    font-size: 15px;

  }


  .contacto-main {

    padding-left: 5%;

    padding-right: 5%;

  }


  .map-section {

    padding-left: 5%;

    padding-right: 5%;

  }

}

</style>
