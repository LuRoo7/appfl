<template>
  <header class="encabezado">

      <nav>

        <RouterLink
          to="/EmpleadosAdmin"
          class="nav-link"
        >
          Empleados
        </RouterLink>

        <RouterLink
          to="/calendario"
          class="nav-link"
        >
          Calendario
        </RouterLink>


        <RouterLink
          to="/NovedadesAdmin"
          class="nav-link"
        >
          Novedades y Preguntas
        </RouterLink>

        <RouterLink
          to="/HigieneAdmin"
          class="nav-link"
        >
          Higiene Administracion
        </RouterLink>

      </nav>

    </header>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}

.encabezado {
  width: 100%;
  background-color: #FFFFFF;
  box-shadow: 0 3px 12px rgba(74, 74, 78, 0.10);
}


nav {
  width: 100%;
  min-height: 65px;

  display: flex;
  justify-content: center;
  align-items: center;

  gap: 5px;
}


.nav-link {
  position: relative;

  height: 65px;

  display: flex;
  align-items: center;
  justify-content: center;

  padding: 0 25px;

  color: #4A4A4E;
  text-decoration: none;

  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;

  transition: all 0.3s ease;
}


.nav-link:hover {
  color: #EB3135;
  background-color: #EDEDED;
}


.nav-link::after {
  content: '';

  position: absolute;

  left: 50%;
  bottom: 0;

  width: 0;
  height: 4px;

  background-color: #EB3135;

  border-radius: 5px 5px 0 0;

  transform: translateX(-50%);

  transition: width 0.3s ease;
}


.nav-link:hover::after {
  width: 65%;
}


.nav-link.router-link-exact-active {
  color: #EB3135;
  font-weight: 700;
}


.nav-link.router-link-exact-active::after {
  width: 65%;
}
</style>
