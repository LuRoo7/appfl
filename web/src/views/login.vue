
<template>
  <main class="login-page">

    <!-- DECORACIÓN LATERAL -->
    <div class="decoracion">
      <div class="decoracion-linea"></div>
      <div class="decoracion-circulo"></div>
      <div class="decoracion-numero"></div>
    </div>


    <!-- CONTENIDO -->
    <section class="login-section">

      <!-- MARCA -->
      <div class="marca">
        <span class="marca-linea"></span>
        <span>FRONTERA LIVING</span>
      </div>


      <!-- ENCABEZADO -->
      <div class="login-header">

        <span class="login-tag">
          ACCESO
        </span>

        <h1>
          Bienvenido<br>
          <strong>nuevamente.</strong>
        </h1>

        <p>
          Ingresá a tu cuenta para continuar.
        </p>

      </div>


      <!-- FORMULARIO -->
      <div class="login-card">

        <form @submit.prevent="iniciarSesion">

          <!-- EMAIL -->
          <div class="form-group">

            <label for="email">
              Correo electrónico
            </label>

            <div class="input-container">

              <span class="input-number">
            
              </span>

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

              <span class="input-number">
              
              </span>

              <input
                type="password"
                id="password"
                v-model="form.password"
                required
                placeholder="••••••••"
              />

            </div>

          </div>


          <!-- BOTÓN -->
          <button
            type="submit"
            class="btn-login"
            :disabled="cargando"
          >

            <span>
              {{ cargando ? 'Ingresando...' : 'Iniciar sesión' }}
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
          <span>!</span>
          {{ mensajeError }}
        </p>

        <p
          v-if="mensajeExito"
          class="mensaje exito-msg"
        >
          <span>✓</span>
          {{ mensajeExito }}
        </p>

      </div>


      <!-- PIE -->
      <div class="login-footer">

        <span>
          FRONTERA LIVING
        </span>

        <small>
          Acceso seguro
        </small>

      </div>

    </section>

  </main>
</template>


<script>
export default {
  name: 'LoginView',

  data() {
    return {
      form: {
        email: '',
        password: ''
      },

      cargando: false,
      mensajeExito: '',
      mensajeError: ''
    };
  },

  methods: {

    async iniciarSesion() {

      this.cargando = true;

      this.mensajeExito = '';
      this.mensajeError = '';

      try {

        const response = await fetch(
          'http://localhost/conexion/login.php',
          {
            method: 'POST',

            headers: {
              'Content-Type': 'application/json'
            },

            body: JSON.stringify(this.form)
          }
        );

        const data = await response.json();

        if (data.status === 'success') {

          this.mensajeExito = data.message;

          localStorage.setItem(
            'usuario',
            JSON.stringify(data.usuario)
          );

          setTimeout(() => {

            if (this.$router) {

              this.$router.push('/');

            } else {

              window.location.href = '/';

            }

          }, 1500);

        } else {

          this.mensajeError =
            data.message ||
            'Error al iniciar sesión.';

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

.login-page {

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
   DECORACIÓN
========================================= */

.decoracion {

  position: absolute;

  top: 0;
  left: 0;

  width: 38%;
  height: 100%;

  background: #4A4A4E;

  overflow: hidden;

}


.decoracion::after {

  content: "";

  position: absolute;

  top: 0;
  right: -120px;

  width: 260px;
  height: 100%;

  background: #444448;

  transform: skewX(-14deg);

}


.decoracion-linea {

  position: absolute;

  left: 12%;

  top: 18%;

  width: 5px;
  height: 150px;

  background: #EB3135;

  z-index: 2;

}


.decoracion-circulo {

  position: absolute;

  left: -130px;
  bottom: -130px;

  width: 360px;
  height: 360px;

  border: 1px solid rgba(235, 49, 53, 0.35);

  border-radius: 50%;

}


.decoracion-numero {

  position: absolute;

  left: 12%;
  bottom: 10%;

  color: rgba(255,255,255,0.15);

  font-size: 100px;

  line-height: 1;

  font-weight: 700;

}


/* =========================================
   SECCIÓN LOGIN
========================================= */

.login-section {

  position: relative;

  z-index: 3;

  width: min(520px, 90%);

  margin-left: 46%;

  padding: 60px 0;

}


/* =========================================
   MARCA
========================================= */

.marca {

  display: flex;

  align-items: center;

  gap: 12px;

  margin-bottom: 45px;

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

.login-header {

  margin-bottom: 40px;

}


.login-tag {

  display: block;

  margin-bottom: 15px;

  color: #EB3135;

  font-size: 10px;

  font-weight: 700;

  letter-spacing: 3px;

}


.login-header h1 {

  margin: 0 0 18px;

  color: #4A4A4E;

  font-size: clamp(42px, 5vw, 62px);

  line-height: 0.98;

  font-weight: 300;

  letter-spacing: -2px;

}


.login-header h1 strong {

  font-weight: 700;

}


.login-header p {

  margin: 0;

  color: #777777;

  font-size: 14px;

  font-weight: 300;

}


/* =========================================
   CARD
========================================= */

.login-card {

  padding: 42px;

  background: #ffffff;

  border-left: 4px solid #EB3135;

  box-shadow: 0 15px 45px rgba(74, 74, 78, 0.08);

}


/* =========================================
   FORMULARIO
========================================= */

.form-group {

  margin-bottom: 28px;

}


.form-group label {

  display: block;

  margin-bottom: 10px;

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


.input-number {

  width: 40px;

  color: #EB3135;

  font-size: 10px;

  font-weight: 700;

}


.input-container input {

  width: 100%;

  padding: 14px 0;

  border: none;

  outline: none;

  background: transparent;

  color: #4A4A4E;

  font-family: 'Poppins', sans-serif;

  font-size: 14px;

  font-weight: 400;

}


.input-container input::placeholder {

  color: #BDC0C3;

  font-weight: 300;

}


/* =========================================
   BOTÓN
========================================= */

.btn-login {

  display: flex;

  align-items: center;
  justify-content: center;

  gap: 15px;

  width: 100%;

  margin-top: 12px;

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


.btn-login:hover:not(:disabled) {

  background: #4A4A4E;

}


.btn-login:disabled {

  background: #BDC0C3;

  cursor: not-allowed;

}


.btn-login svg {

  transition: transform 0.3s ease;

}


.btn-login:hover:not(:disabled) svg {

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

.login-footer {

  display: flex;

  justify-content: space-between;

  align-items: center;

  margin-top: 28px;

  padding-top: 18px;

  border-top: 1px solid #BDC0C3;

}


.login-footer span {

  color: #4A4A4E;

  font-size: 9px;

  font-weight: 700;

  letter-spacing: 2px;

}


.login-footer small {

  color: #999999;

  font-size: 9px;

  font-weight: 400;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 900px) {

  .decoracion {

    width: 28%;

  }

  .login-section {

    margin-left: 34%;

    width: 60%;

  }

}


@media (max-width: 700px) {

  .login-page {

    min-height: 100vh;

    display: block;

    padding: 50px 0;

  }


  .decoracion {

    width: 100%;

    height: 240px;

  }


  .decoracion::after {

    display: none;

  }


  .decoracion-linea {

    left: 7%;

    top: 45px;

    height: 100px;

  }


  .decoracion-numero {

    right: 7%;

    left: auto;

    bottom: 25px;

    font-size: 70px;

  }


  .decoracion-circulo {

    display: none;

  }


  .login-section {

    width: 90%;

    margin: 170px auto 0;

    padding: 0 0 40px;

  }


  .marca {

    margin-bottom: 35px;

  }


  .login-header h1 {

    font-size: 48px;

  }


  .login-card {

    padding: 30px 25px;

  }

}


@media (max-width: 450px) {

  .login-page {

    padding-top: 35px;

  }


  .decoracion {

    height: 210px;

  }


  .login-section {

    margin-top: 150px;

  }


  .login-header h1 {

    font-size: 42px;

  }


  .login-card {

    padding: 25px 20px;

  }

}

</style>

