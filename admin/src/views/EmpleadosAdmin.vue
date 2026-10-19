```vue
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

        <RouterLink
          to="/capacitacionesadmin"
          class="nav-link"
        >
          Capacitaciones
        </RouterLink>

        <RouterLink
          to="/Miperfiladmin"
          class="nav-link"
        >
          Mi perfil
        </RouterLink>

      </nav>

    </header>
  <div class="empleados-page">

    <main class="contenido">

      <h1>Administrar empleados</h1>

      <section class="formulario">

        <h2>Agregar empleado</h2>

        <input
          v-model="legajo"
          type="number"
          placeholder="Legajo"
        >

        <input
          v-model="nombre"
          type="text"
          placeholder="Nombre completo"
        >

        <input
          v-model="dni"
          type="text"
          placeholder="DNI"
        >

        <input
          v-model="contrasena"
          type="password"
          placeholder="Contraseña inicial"
        >

        <button @click="crearEmpleado">
          Agregar empleado
        </button>

      </section>


      <section class="lista">

        <h2>Empleados registrados</h2>

        <div
          v-if="empleados.length === 0"
          class="sin-empleados"
        >
          No hay empleados registrados.
        </div>


        <div
          v-for="empleado in empleados"
          :key="empleado.legajo"
          class="empleado"
        >

          <div class="datos">

            <strong>
              {{ empleado.nombre }}
            </strong>

            <span>
              Legajo: {{ empleado.legajo }}
            </span>

            <span>
              DNI: {{ empleado.dni }}
            </span>

            <span
              v-if="Number(empleado.debe_cambiar) === 1"
              class="estado"
            >
              Debe cambiar contraseña
            </span>

            <span
              v-else
              class="estado"
            >
              Contraseña actualizada
            </span>

          </div>


          <button
            class="eliminar"
            @click="eliminarEmpleado(empleado.legajo)"
          >
            Eliminar
          </button>

        </div>

      </section>

    </main>

  </div>

</template>


<script setup>

import { ref, onMounted } from "vue";

const empleados = ref([]);

const legajo = ref("");
const nombre = ref("");
const dni = ref("");
const contrasena = ref("");


const cargarEmpleados = async () => {

  try {

    const respuesta = await fetch(
      "http://localhost/backend/empleados_listar.php"
    );

    const datos = await respuesta.json();

    if (datos.ok) {
      empleados.value = datos.empleados;
    }

  } catch (error) {

    console.error(error);

    alert("No se pudieron cargar los empleados");

  }

};


const crearEmpleado = async () => {

  if (
    !legajo.value ||
    !nombre.value ||
    !dni.value ||
    !contrasena.value
  ) {

    alert("Completá todos los campos");

    return;

  }


  try {

    const respuesta = await fetch(
      "http://localhost/backend/empleado_crear.php",
      {
        method: "POST",

        headers: {
          "Content-Type": "application/json"
        },

        body: JSON.stringify({
          legajo: legajo.value,
          nombre: nombre.value,
          dni: dni.value,
          contrasena: contrasena.value
        })
      }
    );


    const datos = await respuesta.json();


    if (!datos.ok) {

      alert(datos.mensaje);

      return;

    }


    alert("Empleado creado correctamente");


    legajo.value = "";
    nombre.value = "";
    dni.value = "";
    contrasena.value = "";


    await cargarEmpleados();

  } catch (error) {

    console.error(error);

    alert("Error al conectar con el backend");

  }

};


const eliminarEmpleado = async (legajoEmpleado) => {

  const confirmar = confirm(
    "¿Seguro que querés eliminar este empleado?"
  );

  if (!confirmar) {
    return;
  }


  try {

    const respuesta = await fetch(
      "http://localhost/backend/empleado_eliminar.php",
      {
        method: "POST",

        headers: {
          "Content-Type": "application/json"
        },

        body: JSON.stringify({
          legajo: legajoEmpleado
        })
      }
    );


    const datos = await respuesta.json();


    if (!datos.ok) {

      alert(datos.mensaje);

      return;

    }


    alert("Empleado eliminado correctamente");

    await cargarEmpleados();

  } catch (error) {

    console.error(error);

    alert("Error al conectar con el backend");

  }

};


onMounted(() => {
  cargarEmpleados();
});

</script>


<style scoped>

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
.empleados-page {
  min-height: 100vh;
  background: #f3f3f3;
  font-family: Arial, sans-serif;
}


.contenido {
  width: 90%;
  max-width: 1100px;
  margin: 40px auto;
}


h1 {
  margin-bottom: 30px;
}


.formulario,
.lista {
  background: white;
  padding: 30px;
  border-radius: 15px;
  margin-bottom: 30px;
}


.formulario {
  display: flex;
  flex-direction: column;
  gap: 15px;
}


input {
  padding: 13px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
}


.formulario button {
  padding: 13px;
  border: none;
  border-radius: 8px;
  background: #eb3135;
  color: white;
  font-size: 16px;
  cursor: pointer;
}


.formulario button:hover {
  background: #d9282c;
}


.empleado {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 0;
  border-bottom: 1px solid #ddd;
}


.datos {
  display: flex;
  flex-direction: column;
  gap: 5px;
}


.estado {
  font-size: 13px;
  color: #666;
}


.eliminar {
  background: #333;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 10px 18px;
  cursor: pointer;
}


.eliminar:hover {
  background: #222;
}


.sin-empleados {
  color: #777;
}

</style>