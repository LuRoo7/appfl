<template>
  <main class="registro-page">

    <!-- CONTENIDO -->
    <section class="registro-section">

      <!-- MARCA -->
      <div class="marca">

        <span class="marca-linea"></span>

        <span>
          FRONTERA LIVING
        </span>

      </div>


      <!-- HEADER -->
      <div class="registro-header">

        <span class="registro-tag">
          REGISTRO
        </span>

        <h1>
          Creá tu<br>
          <strong>cuenta.</strong>
        </h1>

        <p>
          Registrate para acceder a todas las funcionalidades
          de Frontera Living.
        </p>

      </div>


      <!-- CARD -->
      <div class="registro-card">

        <form @submit.prevent="registrarUsuario">

          <!-- NOMBRE -->
          <div class="form-group">

            <label for="nombre">
              Nombre completo
            </label>

            <div class="input-container">

              <input
                type="text"
                id="nombre"
                v-model="form.nombre"
                required
                placeholder="Tu nombre"
              />

            </div>

          </div>


          <!-- EMAIL -->
          <div class="form-group">

            <label for="email">
              Correo electrónico
            </label>

            <div class="input-container">

              <input
                type="email"
                id="email"
                v-model="form.email"
                required
                placeholder="tuemail@ejemplo.com"
              />

            </div>

          </div>


          <!-- CONTRASEÑA -->
          <div class="form-group">

            <label for="password">
              Contraseña
            </label>

            <div class="input-container">

              <input
                type="password"
                id="password"
                v-model="form.password"
                required
                placeholder="••••••••"
              />

            </div>

          </div>


          <!-- INFORMACIÓN -->
          <div class="registro-info">

            <span class="info-icon">
              i
            </span>

            <span>
              Tus datos serán utilizados únicamente
              para gestionar tu cuenta.
            </span>

          </div>


          <!-- BOTÓN -->
          <button
            type="submit"
            class="btn-registro"
            :disabled="cargando"
          >

            <span>
              {{ cargando ? 'Registrando...' : 'Crear cuenta' }}
            </span>

            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
            >

              <line
                x1="5"
                y1="12"
                x2="19"
                y2="12"
              />

              <polyline
                points="12 5 19 12 12 19"
              />

            </svg>

          </button>

        </form>


        <!-- MENSAJES -->
        <p
          v-if="mensajeError"
          class="mensaje error-msg"
        >

          <span>
            !
          </span>

          {{ mensajeError }}

        </p>


        <p
          v-if="mensajeExito"
          class="mensaje exito-msg"
        >

          <span>
            ✓
          </span>

          {{ mensajeExito }}

        </p>

      </div>


      <!-- FOOTER -->
      <div class="registro-footer">

        <span>
          FRONTERA LIVING
        </span>

        <small>
          Creá tu cuenta
        </small>

      </div>

    </section>


    <!-- DECORACIÓN LATERAL DERECHA -->
    <div class="decoracion">

      <div class="decoracion-linea"></div>

      <div class="decoracion-circulo"></div>

      <div class="decoracion-numero">
        02
      </div>

      <div class="decoracion-texto">
        FRONTERA<br>
        <strong>LIVING</strong>
      </div>

    </div>

  </main>
</template>


<script>
export default {

  name: 'RegistrarseView',

  data() {

    return {

      form: {
        nombre: '',
        email: '',
        password: ''
      },

      cargando: false,

      mensajeExito: '',

      mensajeError: ''

    };

  },


  methods: {

    async registrarUsuario() {

      this.cargando = true;

      this.mensajeExito = '';

      this.mensajeError = '';


      try {

        const response = await fetch(
          'http://localhost/conexion/registro.php',
          {
            method: 'POST',

            headers: {
              'Content-Type': 'application/json'
            },

            body: JSON.stringify(this.form)
          }
        );


        const data =
          await response.json();


        if (data.status === 'success') {

          this.mensajeExito =
            data.message ||
            '¡Registro completado con éxito! Redirigiendo al login...';


          this.form = {
            nombre: '',
            email: '',
            password: ''
          };


          setTimeout(() => {

            if (this.$router) {

              this.$router.push('/login');

            } else {

              window.location.href = '/login';

            }

          }, 1500);


        } else {

          this.mensajeError =
            data.message ||
            'Ocurrió un error al registrarse.';

        }


      } catch (error) {

        console.error(
          'Error detallado:',
          error
        );

        this.mensajeError =
          'Detalle del error: ' +
          error.message;

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

.registro-page {

  position: relative;

  width: 100%;

  min-height: calc(100vh - 80px);

  display: flex;

  align-items: center;

  background: #EDEDED;

  color: #4A4A4E;

  font-family: 'Poppins', sans-serif;

  overflow: hidden;

}


/* =========================================
   CONTENIDO IZQUIERDO
========================================= */

.registro-section {

  position: relative;

  z-index: 3;

  width: 520px;

  margin-left: 10%;

  padding: 55px 0;

}


/* =========================================
   MARCA
========================================= */

.marca {

  display: flex;

  align-items: center;

  gap: 12px;

  margin-bottom: 35px;

  color: #4A4A4E;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 3px;

}


.marca-linea {

  width: 28px;

  height: 3px;

  background: #EB3135;

}


/* =========================================
   HEADER
========================================= */

.registro-header {

  margin-bottom: 35px;

}


.registro-tag {

  display: block;

  margin-bottom: 14px;

  color: #EB3135;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 3px;

}


.registro-header h1 {

  margin: 0 0 16px;

  color: #4A4A4E;

  font-size: clamp(42px, 5vw, 62px);

  line-height: 0.98;

  font-weight: 300;

  letter-spacing: -2px;

}


.registro-header h1 strong {

  font-weight: 700;

}


.registro-header p {

  max-width: 430px;

  margin: 0;

  color: #777777;

  font-size: 14px;

  line-height: 1.7;

  font-weight: 300;

}


/* =========================================
   CARD
========================================= */

.registro-card {

  padding: 40px 42px;

  background: #ffffff;

  border-left: 4px solid #EB3135;

  box-shadow: 0 15px 45px rgba(74, 74, 78, 0.08);

}


/* =========================================
   CAMPOS
========================================= */

.form-group {

  margin-bottom: 25px;

}


.form-group label {

  display: block;

  margin-bottom: 9px;

  color: #4A4A4E;

  font-size: 11px;

  font-weight: 700;

  letter-spacing: 1px;

  text-transform: uppercase;

}


.input-container {

  display: flex;

  align-items: center;

  border-bottom: 1px solid #BDC0C3;

  transition: border-color 0.3s ease;

}


.input-container:focus-within {

  border-color: #EB3135;

}


.input-container input {

  width: 100%;

  padding: 13px 0;

  border: none;

  outline: none;

  background: transparent;

  color: #4A4A4E;

  font-family: 'Poppins', sans-serif;

  font-size: 14px;

}


.input-container input::placeholder {

  color: #BDC0C3;

  font-weight: 300;

}


/* =========================================
   INFORMACIÓN
========================================= */

.registro-info {

  display: flex;

  align-items: flex-start;

  gap: 10px;

  margin: 4px 0 25px;

  padding: 12px;

  background: #EDEDED;

  color: #777777;

  font-size: 10px;

  line-height: 1.5;

}


.info-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  min-width: 19px;

  width: 19px;

  height: 19px;

  background: #4A4A4E;

  color: #ffffff;

  border-radius: 50%;

  font-size: 10px;

  font-weight: 700;

}


/* =========================================
   BOTÓN
========================================= */

.btn-registro {

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


.btn-registro:hover:not(:disabled) {

  background: #4A4A4E;

}


.btn-registro:disabled {

  background: #BDC0C3;

  cursor: not-allowed;

}


.btn-registro svg {

  transition: transform 0.3s ease;

}


.btn-registro:hover:not(:disabled) svg {

  transform: translateX(5px);

}


/* =========================================
   MENSAJES
========================================= */

.mensaje {

  display: flex;

  align-items: center;

  gap: 10px;

  margin: 20px 0 0;

  padding: 13px 15px;

  font-size: 12px;

  line-height: 1.5;

}


.mensaje span {

  display: flex;

  align-items: center;

  justify-content: center;

  min-width: 22px;

  width: 22px;

  height: 22px;

  font-weight: 700;

}


.error-msg {

  background: #fff0f0;

  color: #c62828;

  border-left: 3px solid #EB3135;

}


.error-msg span {

  background: #EB3135;

  color: #ffffff;

  border-radius: 50%;

}


.exito-msg {

  background: #f2f2f2;

  color: #4A4A4E;

  border-left: 3px solid #EB3135;

}


.exito-msg span {

  color: #EB3135;

}


/* =========================================
   FOOTER
========================================= */

.registro-footer {

  display: flex;

  align-items: center;

  justify-content: space-between;

  margin-top: 25px;

  padding-top: 17px;

  border-top: 1px solid #BDC0C3;

}


.registro-footer span {

  color: #4A4A4E;

  font-size: 9px;

  font-weight: 700;

  letter-spacing: 2px;

}


.registro-footer small {

  color: #999999;

  font-size: 9px;

  font-weight: 400;

}


/* =========================================
   DECORACIÓN DERECHA
========================================= */

.decoracion {

  position: absolute;

  top: 0;

  right: 0;

  width: 38%;

  height: 100%;

  background: #4A4A4E;

  overflow: hidden;

}


.decoracion::after {

  content: "";

  position: absolute;

  top: 0;

  left: -120px;

  width: 260px;

  height: 100%;

  background: #444448;

  transform: skewX(-14deg);

}


.decoracion-linea {

  position: absolute;

  right: 12%;

  top: 18%;

  width: 5px;

  height: 150px;

  background: #EB3135;

  z-index: 2;

}


.decoracion-circulo {

  position: absolute;

  right: -130px;

  bottom: -130px;

  width: 360px;

  height: 360px;

  border: 1px solid rgba(235, 49, 53, 0.35);

  border-radius: 50%;

}


.decoracion-numero {

  position: absolute;

  right: 12%;

  bottom: 9%;

  color: rgba(255,255,255,0.12);

  font-size: 100px;

  line-height: 1;

  font-weight: 700;

}


.decoracion-texto {

  position: absolute;

  right: 12%;

  bottom: 21%;

  color: #ffffff;

  font-size: 11px;

  line-height: 1.5;

  letter-spacing: 3px;

  font-weight: 300;

  text-align: right;

  z-index: 2;

}


.decoracion-texto strong {

  color: #EB3135;

  font-weight: 700;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1100px) {

  .registro-section {

    margin-left: 7%;

    width: 50%;

  }

  .decoracion {

    width: 40%;

  }

}


@media (max-width: 850px) {

  .registro-section {

    margin-left: 5%;

    width: 55%;

  }

  .decoracion {

    width: 35%;

  }

  .decoracion-texto {

    display: none;

  }

}


@media (max-width: 700px) {

  .registro-page {

    min-height: 100vh;

    display: block;

    padding: 50px 0;

  }


  .decoracion {

    position: absolute;

    top: 0;

    left: 0;

    right: auto;

    width: 100%;

    height: 210px;

  }


  .decoracion::after {

    display: none;

  }


  .decoracion-linea {

    left: 7%;

    right: auto;

    top: 45px;

    height: 100px;

  }


  .decoracion-numero {

    right: 7%;

    bottom: 25px;

    font-size: 70px;

  }


  .decoracion-texto {

    display: block;

    left: 7%;

    right: auto;

    bottom: 30px;

    text-align: left;

  }


  .decoracion-circulo {

    display: none;

  }


  .registro-section {

    width: 90%;

    margin: 150px auto 0;

    padding: 0 0 40px;

  }


  .marca {

    margin-bottom: 35px;

  }


  .registro-header h1 {

    font-size: 48px;

  }


  .registro-card {

    padding: 30px 25px;

  }

}


@media (max-width: 450px) {

  .registro-page {

    padding-top: 35px;

  }


  .decoracion {

    height: 190px;

  }


  .registro-section {

    margin-top: 135px;

  }


  .registro-header h1 {

    font-size: 42px;

  }


  .registro-card {

    padding: 25px 20px;

  }

}

</style>
