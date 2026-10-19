
<script setup>

import { ref, onMounted } from 'vue'
import axios from 'axios'

const novedades = ref([])
const preguntas = ref([])

const cargando = ref(false)
const mensaje = ref('')
const tipoMensaje = ref('')

const mostrarFormulario = ref(false)
const editando = ref(false)

const idNovedad = ref(null)
const titulo = ref('')
const mensajeNovedad = ref('')

const respuestas = ref({})


const cargarNovedades = async () => {

  try {

    const respuesta = await axios.get(
      'http://localhost/backend/novedades_listar.php'
    )

    if (respuesta.data.success) {
      novedades.value = respuesta.data.novedades
    }

  } catch (error) {

    console.error('Error al cargar novedades:', error)

  }

}


const cargarPreguntas = async () => {

  try {

    const respuesta = await axios.get(
      'http://localhost/backend/preguntas_listar.php'
    )

    if (respuesta.data.success) {
      preguntas.value = respuesta.data.preguntas
    }

  } catch (error) {

    console.error('Error al cargar preguntas:', error)

  }

}


const limpiarFormulario = () => {

  idNovedad.value = null
  titulo.value = ''
  mensajeNovedad.value = ''
  editando.value = false
  mostrarFormulario.value = false

}


const abrirCrear = () => {

  limpiarFormulario()
  mostrarFormulario.value = true

}


const editarNovedad = (novedad) => {

  idNovedad.value = novedad.id
  titulo.value = novedad.titulo
  mensajeNovedad.value = novedad.mensaje

  editando.value = true
  mostrarFormulario.value = true

}


const guardarNovedad = async () => {

  if (!titulo.value.trim() || !mensajeNovedad.value.trim()) {

    mensaje.value = 'Completá todos los campos.'
    tipoMensaje.value = 'error'

    return

  }

  try {

    let respuesta

    if (editando.value) {

      respuesta = await axios.post(
        'http://localhost/backend/novedades_modificar.php',
        {
          id: idNovedad.value,
          titulo: titulo.value.trim(),
          mensaje: mensajeNovedad.value.trim()
        }
      )

    } else {

      respuesta = await axios.post(
        'http://localhost/backend/novedades_crear.php',
        {
          titulo: titulo.value.trim(),
          mensaje: mensajeNovedad.value.trim()
        }
      )

    }


    if (respuesta.data.success) {

      mensaje.value = respuesta.data.message
      tipoMensaje.value = 'exito'

      limpiarFormulario()

      await cargarNovedades()

    } else {

      mensaje.value = respuesta.data.message
      tipoMensaje.value = 'error'

    }

  } catch (error) {

    console.error(error)

    mensaje.value = 'Error al conectar con el servidor.'
    tipoMensaje.value = 'error'

  }

}


const eliminarNovedad = async (id) => {

  const confirmar = confirm(
    '¿Estás seguro de que querés eliminar esta novedad?'
  )

  if (!confirmar) {
    return
  }


  try {

    const respuesta = await axios.post(
      'http://localhost/backend/novedades_eliminar.php',
      {
        id: id
      }
    )


    if (respuesta.data.success) {

      mensaje.value = 'Novedad eliminada correctamente.'
      tipoMensaje.value = 'exito'

      await cargarNovedades()

    } else {

      mensaje.value = respuesta.data.message
      tipoMensaje.value = 'error'

    }

  } catch (error) {

    console.error(error)

    mensaje.value = 'Error al conectar con el servidor.'
    tipoMensaje.value = 'error'

  }

}


const responderPregunta = async (pregunta) => {

  const respuestaTexto = respuestas.value[pregunta.id]?.trim()

  if (!respuestaTexto) {
    return
  }


  try {

    const respuesta = await axios.post(
      'http://localhost/backend/preguntas_responder.php',
      {
        id: pregunta.id,
        respuesta: respuestaTexto
      }
    )


    if (respuesta.data.success) {

      mensaje.value = 'Respuesta enviada correctamente.'
      tipoMensaje.value = 'exito'

      respuestas.value[pregunta.id] = ''

      await cargarPreguntas()

    } else {

      mensaje.value = respuesta.data.message
      tipoMensaje.value = 'error'

    }

  } catch (error) {

    console.error(error)

    mensaje.value = 'Error al conectar con el servidor.'
    tipoMensaje.value = 'error'

  }

}


const formatearFecha = (fecha) => {

  if (!fecha) {
    return ''
  }

  const partes = fecha.substring(0, 10).split('-')

  return `${partes[2]}/${partes[1]}/${partes[0]}`

}


onMounted(() => {

  cargarNovedades()
  cargarPreguntas()

})

</script>


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
  <div class="admin-page">

    <main class="contenido">

      <p
        v-if="mensaje"
        :class="['mensaje', tipoMensaje]"
      >
        {{ mensaje }}
      </p>


      <!-- NOVEDADES -->

      <section class="seccion">

        <div class="seccion-header">

          <div>

            <span class="etiqueta">
              FRONTERA LIVING
            </span>

            <h2>Novedades</h2>

            <p>
              Administrá las novedades que aparecen en la aplicación de empleados.
            </p>

          </div>


          <button
            class="boton-crear"
            @click="abrirCrear"
          >
            + Nueva novedad
          </button>

        </div>


        <!-- FORMULARIO -->

        <div
          v-if="mostrarFormulario"
          class="formulario"
        >

          <h3>
            {{ editando ? 'Modificar novedad' : 'Crear nueva novedad' }}
          </h3>


          <label>
            Título
          </label>


          <input
            v-model="titulo"
            type="text"
            placeholder="Título de la novedad"
          >


          <label>
            Mensaje
          </label>


          <textarea
            v-model="mensajeNovedad"
            rows="5"
            placeholder="Escribí el mensaje de la novedad..."
          ></textarea>


          <div class="acciones-formulario">

            <button
              class="guardar"
              @click="guardarNovedad"
            >
              {{ editando ? 'Guardar cambios' : 'Crear novedad' }}
            </button>


            <button
              class="cancelar"
              @click="limpiarFormulario"
            >
              Cancelar
            </button>

          </div>

        </div>


        <!-- LISTADO -->

        <div class="lista">

          <article
            v-for="novedad in novedades"
            :key="novedad.id"
            class="tarjeta"
          >

            <div class="fecha">
              {{ formatearFecha(novedad.fecha_publicacion) }}
            </div>


            <div class="tarjeta-contenido">

              <h3>
                {{ novedad.titulo }}
              </h3>


              <p>
                {{ novedad.mensaje }}
              </p>


              <div class="acciones">

                <button
                  class="modificar"
                  @click="editarNovedad(novedad)"
                >
                  Modificar
                </button>


                <button
                  class="eliminar"
                  @click="eliminarNovedad(novedad.id)"
                >
                  Eliminar
                </button>

              </div>

            </div>

          </article>

        </div>

      </section>


      <!-- PREGUNTAS -->

      <section class="seccion">

        <div class="seccion-header">

          <div>

            <span class="etiqueta">
              CONSULTAS
            </span>


            <h2>
              Preguntas de empleados
            </h2>


            <p>
              Consultá las preguntas enviadas por los empleados y respondelas.
            </p>

          </div>

        </div>


        <div class="lista-preguntas">

          <article
            v-for="pregunta in preguntas"
            :key="pregunta.id"
            class="pregunta"
          >

            <div class="pregunta-cabecera">

              <strong>
                Legajo: {{ pregunta.legajo }}
              </strong>


              <span>
                {{ formatearFecha(pregunta.fecha_envio) }}
              </span>

            </div>


            <div class="pregunta-texto">

              <strong>
                Pregunta:
              </strong>


              <p>
                {{ pregunta.comentario }}
              </p>

            </div>


            <div
              v-if="pregunta.respuesta"
              class="respuesta-existente"
            >

              <strong>
                Respuesta:
              </strong>


              <p>
                {{ pregunta.respuesta }}
              </p>


              <span>
                Respondida
              </span>

            </div>


            <div
              v-else
              class="respuesta-form"
            >

              <label>
                Responder
              </label>


              <textarea
                v-model="respuestas[pregunta.id]"
                rows="4"
                placeholder="Escribí la respuesta..."
              ></textarea>


              <button
                class="responder"
                @click="responderPregunta(pregunta)"
              >
                Responder
              </button>

            </div>

          </article>


          <p
            v-if="preguntas.length === 0"
            class="sin-datos"
          >
            No hay preguntas de empleados.
          </p>

        </div>

      </section>

    </main>

  </div>

</template>


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
.admin-page {
  min-height: 100vh;
  background-color: #EDEDED;
  color: #4A4A4E;
  font-family: Arial, Helvetica, sans-serif;
}


.contenido {
  max-width: 1200px;
  margin: 0 auto;
  padding: 50px 40px 80px;
}


.seccion {
  background-color: white;
  border-radius: 18px;
  padding: 35px;
  margin-bottom: 40px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}


.seccion-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-bottom: 30px;
}


.etiqueta {
  color: #EB3135;
  font-size: 11px;
  font-weight: bold;
  letter-spacing: 3px;
}


.seccion-header h2 {
  margin: 8px 0;
  font-size: 32px;
}


.seccion-header p {
  color: #77777C;
}


.boton-crear {
  background-color: #EB3135;
  color: white;
  border: none;
  padding: 13px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
}


.formulario {
  background-color: #F5F5F5;
  border-radius: 12px;
  padding: 25px;
  margin-bottom: 30px;
}


.formulario h3 {
  margin-top: 0;
}


.formulario label {
  display: block;
  margin: 15px 0 7px;
  font-weight: bold;
}


.formulario input,
.formulario textarea,
.respuesta-form textarea {
  width: 100%;
  box-sizing: border-box;
  border: 1px solid #D5D5D5;
  border-radius: 8px;
  padding: 12px;
  font-family: Arial, Helvetica, sans-serif;
}


.acciones-formulario {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}


.guardar,
.cancelar,
.modificar,
.eliminar,
.responder {
  border: none;
  padding: 10px 16px;
  border-radius: 7px;
  cursor: pointer;
  font-weight: bold;
}


.guardar,
.responder,
.modificar {
  background-color: #EB3135;
  color: white;
}


.cancelar {
  background-color: #77777C;
  color: white;
}


.eliminar {
  background-color: #4A4A4E;
  color: white;
}


.lista {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}


.tarjeta {
  border: 1px solid #E0E0E0;
  border-radius: 12px;
  overflow: hidden;
}


.fecha {
  background-color: #EB3135;
  color: white;
  padding: 10px 15px;
  font-weight: bold;
}


.tarjeta-contenido {
  padding: 20px;
}


.tarjeta-contenido h3 {
  margin-top: 0;
}


.tarjeta-contenido p {
  color: #707074;
  line-height: 1.6;
}


.acciones {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}


.lista-preguntas {
  display: flex;
  flex-direction: column;
  gap: 20px;
}


.pregunta {
  border: 1px solid #E0E0E0;
  border-radius: 12px;
  padding: 22px;
}


.pregunta-cabecera {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #E5E5E5;
  padding-bottom: 12px;
}


.pregunta-cabecera span {
  color: #77777C;
}


.pregunta-texto {
  margin-top: 18px;
}


.pregunta-texto p {
  color: #555;
  line-height: 1.6;
}


.respuesta-existente {
  background-color: #F1F1F1;
  padding: 15px;
  border-radius: 8px;
  margin-top: 15px;
}


.respuesta-existente p {
  line-height: 1.6;
}


.respuesta-existente span {
  color: #2e8b57;
  font-weight: bold;
}


.respuesta-form {
  margin-top: 20px;
}


.respuesta-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 8px;
}


.respuesta-form button {
  margin-top: 10px;
}


.mensaje {
  padding: 12px;
  border-radius: 8px;
  text-align: center;
  margin-bottom: 20px;
  font-weight: bold;
}


.exito {
  color: #2e8b57;
  background-color: #E8F5E9;
}


.error {
  color: #EB3135;
  background-color: #FDECEC;
}


.sin-datos {
  text-align: center;
  color: #77777C;
  padding: 30px;
}


@media (max-width: 800px) {

  .seccion-header {
    flex-direction: column;
    align-items: flex-start;
  }


  .lista {
    grid-template-columns: 1fr;
  }

}

</style>