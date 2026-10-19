```vue
<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="app">

    <header class="encabezado">

      <!-- LOGO -->
      <div class="logo-container">
        <img
          src="@/assets/Logoo.png"
          alt="Frontera Living"
          class="logo"
        />
      </div>

      <!-- BARRA -->
      <div class="barra-navegacion">
        <nav>

          <RouterLink to="/PagE" class="nav-link">
            Página de Empleados
          </RouterLink>

          <RouterLink to="/PagW" class="nav-link">
            Página Web
          </RouterLink>

        </nav>
      </div>

    </header>

    <!-- ACÁ SE CARGAN LAS PÁGINAS -->
    <main class="contenido">
      <RouterView />
    </main>

  </div>
</template>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');


:global(*) {
  box-sizing: border-box;
}


:global(html),
:global(body),
:global(#app) {
  margin: 0;
  padding: 0;
  width: 100%;
  min-height: 100%;
}


:global(body) {
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}


/* APP */

.app {
  width: 100%;
  min-height: 100vh;
  margin: 0;
  padding: 0;
  background-color: #EDEDED;
}


/* =========================
   ENCABEZADO
========================= */

.encabezado {
  width: 100%;
  margin: 0;
  padding: 0;
  background-color: #FFFFFF;
  box-shadow: 0 3px 15px rgba(74, 74, 78, 0.15);
}


/* =========================
   LOGO
========================= */

.logo-container {
  width: 100%;
  height: 105px;

  margin: 0;
  padding: 0;

  display: flex;
  justify-content: center;
  align-items: center;

  background-color: #FFFFFF;
}


.logo {
  width: 170px;
  max-height: 85px;

  margin: 0;
  padding: 0;

  object-fit: contain;
  display: block;
}


/* =========================
   BARRA
========================= */

.barra-navegacion {
  width: 100%;
  height: 60px;

  margin: 0;
  padding: 0;

  display: flex;
  justify-content: center;
  align-items: center;

  background-color: #4A4A4E;
}


nav {
  width: 100%;
  height: 100%;

  margin: 0;
  padding: 0;

  display: flex;
  justify-content: center;
  align-items: center;
}


/* =========================
   BOTONES
========================= */

.nav-link {
  position: relative;

  height: 100%;

  margin: 0;
  padding: 0 35px;

  display: flex;
  align-items: center;
  justify-content: center;

  color: #EDEDED;
  text-decoration: none;

  font-size: 15px;
  font-weight: 500;

  transition: 0.3s ease;
}


/* HOVER */

.nav-link:hover {
  color: #FFFFFF;
  background-color: rgba(255, 255, 255, 0.08);
}


/* LÍNEA ROJA */

.nav-link::after {
  content: '';

  position: absolute;

  bottom: 0;
  left: 50%;

  width: 0;
  height: 4px;

  background-color: #EB3135;

  border-radius: 5px 5px 0 0;

  transform: translateX(-50%);

  transition: 0.3s ease;
}


.nav-link:hover::after {
  width: 65%;
}


/* PÁGINA ACTIVA */

.nav-link.router-link-exact-active {
  color: #FFFFFF;
  font-weight: 700;
}


.nav-link.router-link-exact-active::after {
  width: 65%;
}


/* =========================
   CONTENIDO
========================= */

.contenido {
  width: 100%;
  min-height: calc(100vh - 165px);

  margin: 0;
  padding: 0;

  background-color: #EDEDED;
}


/* =========================
   CELULAR
========================= */

@media (max-width: 600px) {

  .logo-container {
    height: 80px;
  }


  .logo {
    width: 140px;
    max-height: 65px;
  }


  .barra-navegacion {
    height: 55px;
  }


  .nav-link {
    padding: 0 15px;
    font-size: 12px;
  }


  .contenido {
    min-height: calc(100vh - 135px);
  }

}

</style>
```
