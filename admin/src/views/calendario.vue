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
  <div class="calendario-admin">

    <h1>Administrar calendario</h1>

    <div class="formulario">

      <h2>{{ editando ? "Editar evento" : "Agregar evento" }}</h2>

      <label>Fecha</label>
      <input
        type="date"
        v-model="formulario.fecha"
      />

      <label>Título</label>
      <input
        type="text"
        v-model="formulario.titulo"
        placeholder="Título del evento"
      />

      <label>Descripción</label>
      <textarea
        v-model="formulario.descripcion"
        placeholder="Descripción del evento"
      ></textarea>

      <label>Imágenes</label>

      <input
        type="file"
        multiple
        accept="image/*"
        @change="seleccionarImagenes"
      />

      <div
        v-if="imagenesSeleccionadas.length"
        class="imagenes-seleccionadas"
      >
        <img
          v-for="(imagen, index) in imagenesSeleccionadas"
          :key="index"
          :src="imagen.preview"
        />
      </div>

      <div class="botones">

        <button
          class="guardar"
          @click="guardarEvento"
        >
          {{ editando ? "Guardar cambios" : "Agregar evento" }}
        </button>

        <button
          v-if="editando"
          class="cancelar"
          @click="cancelarEdicion"
        >
          Cancelar
        </button>

      </div>

    </div>

    <div class="lista">

      <h2>Eventos registrados</h2>

      <div
        v-if="eventos.length === 0"
        class="sin-eventos"
      >
        No hay eventos registrados.
      </div>

      <div
        v-for="evento in eventos"
        :key="evento.id"
        class="evento"
      >

        <div class="informacion">

          <h3>{{ formatearFecha(evento.fecha) }}</h3>

          <h4>{{ evento.titulo }}</h4>

          <p>{{ evento.descripcion }}</p>

          <div class="miniaturas">

            <img
              v-for="(imagen, index) in evento.imagenes"
              :key="index"
              :src="obtenerImagen(imagen)"
            />

          </div>

        </div>

        <div class="acciones">

          <button
            class="editar"
            @click="editarEvento(evento)"
          >
            Editar
          </button>

          <button
            class="eliminar"
            @click="eliminarEvento(evento.id)"
          >
            Eliminar
          </button>

        </div>

      </div>

    </div>

  </div>
</template>

<script setup>

import { ref, onMounted } from "vue"

const API = "http://localhost/backend"

const eventos = ref([])

const editando = ref(false)

const idEditando = ref(null)

const imagenesSeleccionadas = ref([])

const formulario = ref({
  fecha: "",
  titulo: "",
  descripcion: ""
})

async function cargarEventos() {

  try {

    const respuesta = await fetch(
      `${API}/calendario_obtener.php`
    )

    const datos = await respuesta.json()

    eventos.value = datos

  } catch (error) {

    console.error("Error al cargar eventos:", error)

  }

}

function seleccionarImagenes(evento) {

  const archivos = Array.from(evento.target.files)

  imagenesSeleccionadas.value = archivos.map(archivo => ({
    archivo: archivo,
    preview: URL.createObjectURL(archivo)
  }))

}

async function guardarEvento() {

  if (!formulario.value.fecha) {
    alert("Seleccioná una fecha")
    return
  }

  if (!formulario.value.titulo) {
    alert("Escribí un título")
    return
  }

  const datos = new FormData()

  datos.append("fecha", formulario.value.fecha)
  datos.append("titulo", formulario.value.titulo)
  datos.append("descripcion", formulario.value.descripcion)

  imagenesSeleccionadas.value.forEach(imagen => {
    datos.append("imagenes[]", imagen.archivo)
  })

  try {

    let url = `${API}/calendario_agregar.php`

    if (editando.value) {
      url = `${API}/calendario_editar.php`
      datos.append("id", idEditando.value)
    }

    const respuesta = await fetch(url, {
      method: "POST",
      body: datos
    })

    const resultado = await respuesta.json()

    if (!resultado.success) {
      alert(resultado.mensaje)
      return
    }

    alert(resultado.mensaje)

    cancelarEdicion()

    await cargarEventos()

  } catch (error) {

    console.error(error)

    alert("Ocurrió un error al guardar el evento")

  }

}

function editarEvento(evento) {

  editando.value = true

  idEditando.value = evento.id

  formulario.value = {
    fecha: evento.fecha,
    titulo: evento.titulo,
    descripcion: evento.descripcion || ""
  }

  imagenesSeleccionadas.value = []

  window.scrollTo({
    top: 0,
    behavior: "smooth"
  })

}

function cancelarEdicion() {

  editando.value = false

  idEditando.value = null

  formulario.value = {
    fecha: "",
    titulo: "",
    descripcion: ""
  }

  imagenesSeleccionadas.value = []

}

async function eliminarEvento(id) {

  const confirmar = confirm(
    "¿Seguro que querés eliminar este evento?"
  )

  if (!confirmar) {
    return
  }

  const datos = new FormData()

  datos.append("id", id)

  try {

    const respuesta = await fetch(
      `${API}/calendario_eliminar.php`,
      {
        method: "POST",
        body: datos
      }
    )

    const resultado = await respuesta.json()

    if (!resultado.success) {
      alert(resultado.mensaje)
      return
    }

    alert(resultado.mensaje)

    await cargarEventos()

  } catch (error) {

    console.error(error)

    alert("No se pudo eliminar el evento")

  }

}

function formatearFecha(fecha) {

  const partes = fecha.split("-")

  const anio = partes[0]
  const mes = Number(partes[1])
  const dia = Number(partes[2])

  const nombres = [
    "",
    "ENERO",
    "FEBRERO",
    "MARZO",
    "ABRIL",
    "MAYO",
    "JUNIO",
    "JULIO",
    "AGOSTO",
    "SEPTIEMBRE",
    "OCTUBRE",
    "NOVIEMBRE",
    "DICIEMBRE"
  ]

  return `${dia} de ${nombres[mes]} de ${anio}`

}

function obtenerImagen(imagen) {

  return `${API}/${imagen}`

}

onMounted(() => {
  cargarEventos()
})

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
.calendario-admin {
  max-width: 1100px;
  margin: 40px auto;
  padding: 30px;
  font-family: Arial, sans-serif;
}

.calendario-admin h1 {
  margin-bottom: 30px;
}

.formulario {
  background: #f1f1f1;
  padding: 25px;
  border-radius: 15px;
  margin-bottom: 40px;
}

.formulario h2 {
  margin-bottom: 20px;
}

.formulario label {
  display: block;
  margin-top: 15px;
  margin-bottom: 6px;
  font-weight: bold;
}

.formulario input[type="date"],
.formulario input[type="text"],
.formulario textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
}

.formulario textarea {
  min-height: 100px;
  resize: vertical;
}

.formulario input[type="file"] {
  margin-top: 8px;
}

.imagenes-seleccionadas {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-top: 20px;
}

.imagenes-seleccionadas img {
  width: 120px;
  height: 90px;
  object-fit: cover;
  border-radius: 8px;
}

.botones {
  display: flex;
  gap: 10px;
  margin-top: 25px;
}

.botones button,
.acciones button {
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
}

.guardar {
  background: #eb3135;
  color: white;
}

.cancelar {
  background: #777;
  color: white;
}

.lista h2 {
  margin-bottom: 20px;
}

.evento {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 12px;
  margin-bottom: 15px;
}

.informacion {
  flex: 1;
}

.informacion h3 {
  margin: 0 0 8px;
}

.informacion h4 {
  margin: 0 0 8px;
}

.informacion p {
  margin-bottom: 15px;
}

.miniaturas {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.miniaturas img {
  width: 90px;
  height: 70px;
  object-fit: cover;
  border-radius: 6px;
}

.acciones {
  display: flex;
  gap: 8px;
  align-items: center;
}

.editar {
  background: #4a4a4e;
  color: white;
}

.eliminar {
  background: #eb3135;
  color: white;
}

.sin-eventos {
  padding: 20px;
  background: #f1f1f1;
  border-radius: 10px;
}

@media (max-width: 700px) {

  .evento {
    flex-direction: column;
  }

  .acciones {
    justify-content: flex-start;
  }

}

</style>