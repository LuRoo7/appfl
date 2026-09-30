<template>
  <main class="curriculum-view">

    <section class="curriculum-hero">

      <div class="hero-decoration"></div>

      <div class="hero-content">

        <span class="hero-tag">
          FRONTERA LIVING
        </span>

        <h1>
          Formá parte<br>
          <strong>de nuestro equipo.</strong>
        </h1>

        <p>
          Queremos conocer tu talento. Dejanos tu currículum
          y formá parte de nuestras futuras búsquedas laborales.
        </p>

      </div>

      <div class="hero-line"></div>

    </section>


    <section class="curriculum-content">

      <div class="content-header">

        <span>
          TRABAJÁ CON NOSOTROS
        </span>

        <h2>
          Dejá tu currículum
        </h2>

        <p>
          Completá el proceso cargando tu currículum vitae.
          Podés enviarlo en formato PDF, JPG o PNG.
        </p>

      </div>


      <div class="curriculum-layout">

        <aside class="info-panel">

          <div class="info-number">
          </div>

          <h3>
            Tu próximo<br>
            desafío puede<br>
            estar acá.
          </h3>

          <p>
            En Frontera Living valoramos las personas,
            el compromiso y las ganas de crecer.
          </p>


          <div class="steps">

            <div class="step">


              <div>
                <strong>
                  Prepará tu CV
                </strong>

                <p>
                  Elegí un archivo actualizado.
                </p>
              </div>

            </div>


            <div class="step">

              <div>
                <strong>
                  Cargalo
                </strong>

                <p>
                  Seleccioná tu archivo desde tu computadora.
                </p>
              </div>

            </div>


            <div class="step">

              <div>
                <strong>
                  Enviá
                </strong>

                <p>
                  Nuestro equipo recibirá tu información.
                </p>
              </div>

            </div>

          </div>

        </aside>


        <div class="form-section">

          <div class="form-header">

            <span>
              CARGAR ARCHIVO
            </span>

            <h3>
              Presentá tu CV
            </h3>

          </div>


          <form @submit.prevent="subirArchivo">

            <div class="campo">

              <label
                for="archivo"
                class="upload-area"
                :class="{ 'archivo-cargado': archivoSeleccionado }"
              >

                <div class="upload-icon">

                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path
                      d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                    ></path>

                    <polyline
                      points="17 8 12 3 7 8"
                    ></polyline>

                    <line
                      x1="12"
                      y1="3"
                      x2="12"
                      y2="15"
                    ></line>

                  </svg>

                </div>


                <div class="upload-text">

                  <strong v-if="!archivoSeleccionado">
                    Seleccioná tu currículum
                  </strong>

                  <strong v-else>
                    Archivo seleccionado
                  </strong>

                  <span v-if="!archivoSeleccionado">
                    Hacé clic para elegir un archivo
                  </span>
  
                  <span v-else>
                    {{ archivoSeleccionado.name }}
                  </span>

                </div>


                <div class="upload-format">
                  PDF · JPG · PNG
                </div>

              </label>


              <input
                type="file"
                id="archivo"
                @change="seleccionarArchivo"
                accept=".pdf,.jpg,.jpeg,.png"
                required
              />

            </div>


            <!-- VISTA PREVIA -->
            <div
              v-if="vistaPrevia"
              class="area-preview"
            >

              <div class="preview-header">

                <div>

                  <span>
                    VISTA PREVIA
                  </span>

                  <h4>
                    Documento seleccionado
                  </h4>

                </div>

                <div class="file-badge">
                  {{ esPdf ? 'PDF' : 'IMG' }}
                </div>

              </div>


              <div class="visor">

                <img
                  v-if="esImagen"
                  :src="vistaPrevia"
                  alt="Vista previa"
                  class="img-preview"
                />


                <iframe
                  v-else-if="esPdf"
                  :src="vistaPrevia"
                  class="pdf-preview"
                ></iframe>

              </div>


              <span class="info-file">
                {{ archivoSeleccionado.name }}
              </span>

            </div>


            <!-- BOTÓN -->
            <button
              type="submit"
              class="btn-enviar"
              :disabled="cargando"
            >

              <span>
                {{ cargando ? 'Enviando...' : 'Enviar currículum' }}
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

          </form>


          <!-- MENSAJES -->
          <p
            v-if="mensajeError"
            class="alerta error"
          >
            {{ mensajeError }}
          </p>


          <p
            v-if="mensajeExito"
            class="alerta exito"
          >
            {{ mensajeExito }}
          </p>

        </div>

      </div>

    </section>


    <!-- CIERRE -->
    <section class="curriculum-footer">

      <div>

        <span>
          FRONTERA LIVING
        </span>

        <h2>
          Construyamos juntos<br>
          lo que viene.
        </h2>

      </div>

      <div class="footer-number">
        45+
        <small>
          AÑOS DE TRAYECTORIA
        </small>
      </div>

    </section>

  </main>
</template>


<script>
export default {

  name: 'CurriculumView',

  data() {

    return {

      usuario: null,

      archivoSeleccionado: null,

      vistaPrevia: null,

      esImagen: false,

      esPdf: false,

      cargando: false,

      mensajeExito: '',

      mensajeError: ''

    };

  },


  mounted() {

    const sesion = localStorage.getItem('usuario');

    if (sesion) {

      this.usuario = JSON.parse(sesion);

    }

  },


  methods: {

    seleccionarArchivo(event) {

      const archivo = event.target.files[0];

      if (!archivo) return;


      this.archivoSeleccionado = archivo;


      if (this.vistaPrevia) {

        URL.revokeObjectURL(this.vistaPrevia);

      }


      this.esImagen =
        archivo.type.startsWith('image/');

      this.esPdf =
        archivo.type === 'application/pdf';


      this.vistaPrevia =
        URL.createObjectURL(archivo);

    },


    async subirArchivo() {

      if (!this.archivoSeleccionado) {

        this.mensajeError =
          'Por favor, seleccioná un archivo.';

        return;

      }


      this.cargando = true;

      this.mensajeExito = '';

      this.mensajeError = '';


      const formData = new FormData();

      formData.append(
        'curriculum',
        this.archivoSeleccionado
      );


      try {

        const response = await fetch(
          'http://localhost/conexion/subir_curriculum.php',
          {
            method: 'POST',
            body: formData
          }
        );


        const data =
          await response.json();


        if (data.mensaje) {

          this.mensajeExito =
            data.mensaje;


          this.archivoSeleccionado =
            null;

          this.vistaPrevia =
            null;

          this.esImagen =
            false;

          this.esPdf =
            false;


          const input =
            document.getElementById('archivo');

          if (input) {

            input.value = '';

          }

        } else {

          this.mensajeError =
            data.error ||
            'Ocurrió un error al procesar el archivo.';

        }

      } catch (error) {

        this.mensajeError =
          'Error de conexión con el servidor.';

      } finally {

        this.cargando = false;

      }

    }

  }

};
</script>


<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');


/* =========================================
   BASE
========================================= */

.curriculum-view {

  width: 100%;

  background: #ffffff;

  color: #4A4A4E;

  font-family: 'Poppins', sans-serif;

}


/* =========================================
   HERO
========================================= */

.curriculum-hero {

  position: relative;

  min-height: 500px;

  display: flex;

  align-items: center;

  padding: 100px 10%;

  background: #4A4A4E;

  overflow: hidden;

}


.hero-content {

  position: relative;

  z-index: 2;

  max-width: 760px;

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

  font-size: clamp(50px, 7vw, 88px);

  line-height: 0.98;

  font-weight: 300;

  letter-spacing: -3px;

}


.hero-content h1 strong {

  font-weight: 700;

}


.hero-content p {

  max-width: 580px;

  margin: 0;

  color: #EDEDED;

  font-size: 17px;

  line-height: 1.8;

  font-weight: 300;

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


.curriculum-hero::after {

  content: "";

  position: absolute;

  right: 9%;

  top: 0;

  width: 5px;

  height: 100%;

  background: #EB3135;

}


.hero-line {

  position: absolute;

  bottom: 0;

  left: 10%;

  width: 100px;

  height: 5px;

  background: #EB3135;

  z-index: 3;

}


/* =========================================
   CONTENIDO
========================================= */

.curriculum-content {

  padding: 110px 10% 120px;

  background: #EDEDED;

}


.content-header {

  max-width: 650px;

  margin-bottom: 65px;

}


.content-header > span {

  color: #EB3135;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 3px;

}


.content-header h2 {

  margin: 12px 0 15px;

  color: #4A4A4E;

  font-size: clamp(38px, 5vw, 58px);

  line-height: 1;

  font-weight: 700;

}


.content-header p {

  max-width: 570px;

  margin: 0;

  color: #666666;

  font-size: 15px;

  line-height: 1.7;

  font-weight: 300;

}


/* =========================================
   LAYOUT
========================================= */

.curriculum-layout {

  display: grid;

  grid-template-columns: 0.75fr 1.25fr;

  gap: 70px;

  align-items: stretch;

}


/* =========================================
   PANEL INFORMACIÓN
========================================= */

.info-panel {

  position: relative;

  padding: 50px 45px;

  background: #4A4A4E;

  color: #ffffff;

  overflow: hidden;

}


.info-number {

  margin-bottom: 25px;

  color: #EB3135;

  font-size: 12px;

  font-weight: 700;

  letter-spacing: 2px;

}


.info-panel h3 {

  margin: 0 0 25px;

  color: #ffffff;

  font-size: 34px;

  line-height: 1.15;

  font-weight: 600;

}


.info-panel > p {

  margin-bottom: 45px;

  color: #EDEDED;

  font-size: 14px;

  line-height: 1.8;

  font-weight: 300;

}


/* Línea decorativa */

.info-panel::after {

  content: "";

  position: absolute;

  right: -80px;

  bottom: -80px;

  width: 220px;

  height: 220px;

  border: 1px solid rgba(235,49,53,0.35);

  border-radius: 50%;

}


/* =========================================
   PASOS
========================================= */

.steps {

  display: flex;

  flex-direction: column;

  gap: 25px;

}


.step {

  display: flex;

  gap: 15px;

  padding-top: 20px;

  border-top: 1px solid rgba(255,255,255,0.12);

}


.step > span {

  color: #EB3135;

  font-size: 11px;

  font-weight: 700;

}


.step strong {

  display: block;

  margin-bottom: 4px;

  color: #ffffff;

  font-size: 13px;

  font-weight: 600;

}


.step p {

  margin: 0;

  color: #BDC0C3;

  font-size: 11px;

  line-height: 1.5;

  font-weight: 300;

}


/* =========================================
   FORMULARIO
========================================= */

.form-section {

  padding: 50px;

  background: #ffffff;

  border-left: 4px solid #EB3135;

}


.form-header {

  margin-bottom: 35px;

}


.form-header span {

  color: #EB3135;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 2px;

}


.form-header h3 {

  margin: 8px 0 0;

  color: #4A4A4E;

  font-size: 28px;

  font-weight: 700;

}


/* =========================================
   UPLOAD
========================================= */

.campo {

  margin-bottom: 30px;

}


.campo input[type="file"] {

  display: none;

}


.upload-area {

  position: relative;

  display: flex;

  align-items: center;

  gap: 20px;

  min-height: 150px;

  padding: 30px;

  border: 1px dashed #BDC0C3;

  background: #EDEDED;

  cursor: pointer;

  transition: all 0.3s ease;

}


.upload-area:hover {

  border-color: #EB3135;

  background: #f7f7f7;

}


.upload-area.archivo-cargado {

  border-color: #EB3135;

  background: #fff7f7;

}


.upload-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  width: 62px;

  min-width: 62px;

  height: 62px;

  background: #4A4A4E;

  color: #ffffff;

}


.upload-area.archivo-cargado .upload-icon {

  background: #EB3135;

}


.upload-text {

  display: flex;

  flex-direction: column;

  gap: 5px;

}


.upload-text strong {

  color: #4A4A4E;

  font-size: 15px;

  font-weight: 600;

}


.upload-text span {

  color: #777777;

  font-size: 12px;

  font-weight: 300;

}


.upload-format {

  position: absolute;

  right: 20px;

  top: 18px;

  color: #999999;

  font-size: 9px;

  font-weight: 700;

  letter-spacing: 1px;

}


/* =========================================
   PREVIEW
========================================= */

.area-preview {

  margin-bottom: 30px;

  padding: 25px;

  background: #EDEDED;

}


.preview-header {

  display: flex;

  align-items: center;

  justify-content: space-between;

  margin-bottom: 20px;

}


.preview-header span {

  display: block;

  margin-bottom: 5px;

  color: #EB3135;

  font-size: 9px;

  font-weight: 700;

  letter-spacing: 2px;

}


.preview-header h4 {

  margin: 0;

  color: #4A4A4E;

  font-size: 16px;

  font-weight: 600;

}


.file-badge {

  padding: 7px 10px;

  background: #4A4A4E;

  color: #ffffff;

  font-size: 9px;

  font-weight: 700;

}


.visor {

  display: flex;

  align-items: center;

  justify-content: center;

  width: 100%;

  min-height: 200px;

  background: #ffffff;

  border: 1px solid #BDC0C3;

  overflow: hidden;

}


.img-preview {

  display: block;

  max-width: 100%;

  max-height: 400px;

  object-fit: contain;

}


.pdf-preview {

  display: block;

  width: 100%;

  height: 400px;

  border: none;

}


.info-file {

  display: block;

  margin-top: 10px;

  color: #777777;

  font-size: 11px;

  overflow: hidden;

  text-overflow: ellipsis;

  white-space: nowrap;

}


/* =========================================
   BOTÓN
========================================= */

.btn-enviar {

  display: flex;

  align-items: center;

  justify-content: center;

  gap: 15px;

  width: 100%;

  padding: 17px 25px;

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


.btn-enviar:hover:not(:disabled) {

  background: #4A4A4E;

}


.btn-enviar:disabled {

  background: #BDC0C3;

  cursor: not-allowed;

}


.btn-enviar svg {

  transition: transform 0.3s ease;

}


.btn-enviar:hover:not(:disabled) svg {

  transform: translateX(5px);

}


/* =========================================
   ALERTAS
========================================= */

.alerta {

  margin-top: 20px;

  padding: 15px 18px;

  font-size: 13px;

  font-weight: 500;

}


.alerta.error {

  background: #ffebee;

  color: #c62828;

  border-left: 4px solid #c62828;

}


.alerta.exito {

  background: #EDEDED;

  color: #4A4A4E;

  border-left: 4px solid #EB3135;

}


/* =========================================
   FOOTER CURRICULUM
========================================= */

.curriculum-footer {

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 40px;

  padding: 90px 10%;

  background: #ffffff;

}


.curriculum-footer span {

  color: #EB3135;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 3px;

}


.curriculum-footer h2 {

  margin: 12px 0 0;

  color: #4A4A4E;

  font-size: clamp(32px, 4vw, 50px);

  line-height: 1.05;

  font-weight: 700;

}


.footer-number {

  display: flex;

  flex-direction: column;

  align-items: flex-end;

  color: #EB3135;

  font-size: 70px;

  line-height: 0.9;

  font-weight: 700;

}


.footer-number small {

  margin-top: 10px;

  color: #4A4A4E;

  font-size: 9px;

  font-weight: 700;

  letter-spacing: 2px;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1000px) {

  .curriculum-layout {

    grid-template-columns: 1fr;

    gap: 40px;

  }

}


@media (max-width: 700px) {

  .curriculum-hero {

    min-height: 470px;

    padding: 80px 7%;

  }


  .hero-decoration {

    width: 30%;

  }


  .curriculum-hero::after {

    right: 5%;

    width: 4px;

  }


  .hero-content h1 {

    font-size: 54px;

    letter-spacing: -2px;

  }


  .curriculum-content {

    padding: 75px 7%;

  }


  .content-header {

    margin-bottom: 40px;

  }


  .info-panel {

    padding: 40px 30px;

  }


  .form-section {

    padding: 30px 25px;

  }


  .upload-area {

    align-items: flex-start;

    padding: 25px;

  }


  .upload-format {

    position: static;

    margin-left: auto;

  }


  .curriculum-footer {

    flex-direction: column;

    align-items: flex-start;

    padding: 70px 7%;

  }


  .footer-number {

    align-items: flex-start;

  }

}


@media (max-width: 500px) {

  .curriculum-hero {

    padding: 70px 5%;

  }


  .hero-content h1 {

    font-size: 45px;

  }


  .hero-content p {

    font-size: 15px;

  }


  .curriculum-content {

    padding-left: 5%;

    padding-right: 5%;

  }


  .upload-area {

    flex-direction: column;

    align-items: flex-start;

  }


  .upload-format {

    margin-left: 0;

  }


  .curriculum-footer {

    padding-left: 5%;

    padding-right: 5%;

  }

}

</style>
```
