```vue
<template>
  <header class="navbar">
    <div class="navbar-container">

      <!-- LOGO -->
      <router-link to="/" class="logo-container">
        <img
          src="@/assets/logo.png"
          alt="Frontera Living"
          class="logo-img"
        />
      </router-link>

      <!-- NAVEGACIÓN -->
      <nav class="nav-links">
        <router-link to="/">Inicio</router-link>
        <router-link to="/Empresa">Empresa</router-link>
        <router-link to="/productos">Productos</router-link>
        <router-link to="/curriculum">Currículum</router-link>
        <router-link to="/contacto">Contacto</router-link>

        <!-- BOTONES DE ACCESO -->
        <div class="auth-buttons">
          <router-link to="/login" class="btn-login-nav">
            Iniciar Sesión
          </router-link>

          <router-link to="/registrarse" class="btn-register-nav">
            Registrarse
          </router-link>
        </div>
      </nav>

    </div>
  </header>

  <main>
    <router-view />
  </main>
</template>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

/* ============================= */
/* NAVBAR */
/* ============================= */

.navbar {
  width: 100%;
  height: 80px;
  background: #fff;
  border-bottom: 1px solid #EDEDED;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  font-family: 'Poppins', sans-serif;
}

/* ============================= */
/* CONTENEDOR */
/* ============================= */

.navbar-container {
  max-width: 1200px;
  height: 100%;
  margin: 0 auto;
  padding: 0 30px;

  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* ============================= */
/* LOGO */
/* ============================= */

.logo-container {
  display: flex;
  align-items: center;
  text-decoration: none;
  transition: transform 0.2s ease;
}

.logo-container:hover {
  transform: scale(1.02);
}

.logo-img {
  height: 50px;
  width: auto;
  max-width: 200px;
  object-fit: contain;
  display: block;
}

/* ============================= */
/* LINKS */
/* ============================= */

.nav-links {
  display: flex;
  align-items: center;
  gap: 32px;
}

.nav-links a {
  position: relative;
  color: #4A4A4E;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none;
  padding: 8px 0;
  transition: color 0.3s ease;
}

.nav-links a::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 50%;

  transform: translateX(-50%);

  width: 0;
  height: 3px;

  background: #EB3135;
  border-radius: 2px;

  transition: width 0.3s ease;
}

.nav-links a:hover {
  color: #EB3135;
}

.nav-links a:hover::after,
.nav-links a.router-link-active::after {
  width: 100%;
}

.nav-links a.router-link-active {
  color: #EB3135;
  font-weight: 600;
}

/* ============================= */
/* BOTONES LOGIN / REGISTRO */
/* ============================= */

.auth-buttons {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-left: 5px;
}

/* Quitamos el estilo de los links normales */

.auth-buttons a {
  position: static !important;

  padding: 10px 18px !important;

  border-radius: 2px;

  font-size: 12px !important;
  font-weight: 600 !important;

  letter-spacing: 0.5px;

  text-decoration: none;

  transition: all 0.3s ease;
}

/* Quitamos la línea roja inferior */

.auth-buttons a::after {
  display: none !important;
}

/* ============================= */
/* INICIAR SESIÓN */
/* ============================= */

.btn-login-nav {
  color: #4A4A4E !important;

  background: transparent;

  border: 1px solid #4A4A4E;
}

.btn-login-nav:hover {
  color: #fff !important;

  background: #4A4A4E;

  border-color: #4A4A4E;
}

/* ============================= */
/* REGISTRARSE */
/* ============================= */

.btn-register-nav {
  color: #fff !important;

  background: #EB3135;

  border: 1px solid #EB3135;
}

.btn-register-nav:hover {
  color: #fff !important;

  background: #4A4A4E;

  border-color: #4A4A4E;

  transform: translateY(-2px);

  box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
}

/* ============================= */
/* MAIN */
/* ============================= */

main {
  width: 100%;
  padding-top: 80px;
  min-height: calc(100vh - 80px);
}

/* ============================= */
/* TABLET */
/* ============================= */

@media (max-width: 1100px) {

  .navbar-container {
    padding: 0 20px;
  }

  .nav-links {
    gap: 18px;
  }

  .nav-links a {
    font-size: 13px;
  }

  .auth-buttons {
    gap: 6px;
  }

  .auth-buttons a {
    padding: 9px 12px !important;
  }
}

/* ============================= */
/* MOBILE */
/* ============================= */

@media (max-width: 680px) {

  .navbar {
    height: auto;
    position: relative;
  }

  .navbar-container {
    padding: 15px 20px;

    flex-direction: column;

    gap: 15px;
  }

  .nav-links {
    flex-wrap: wrap;

    justify-content: center;

    gap: 10px 15px;
  }

  .nav-links a {
    font-size: 13px;
  }

  .auth-buttons {
    width: 100%;

    justify-content: center;

    margin-left: 0;

    margin-top: 5px;
  }

  .auth-buttons a {
    padding: 9px 15px !important;
  }

  main {
    padding-top: 0;
  }
}

</style>
```
