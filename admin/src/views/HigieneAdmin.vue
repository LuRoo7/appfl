<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const API = 'http://localhost/backend/'

const imagenes = ref([])
const epps = ref([])
const puestos = ref([])
const relaciones = ref([])

const cargando = ref(false)
const mensaje = ref('')
const tipoMensaje = ref('')

const mostrarFormularioEpp = ref(false)
const editandoEpp = ref(false)
const eppId = ref(null)
const eppTitulo = ref('')
const eppTexto = ref('')
const eppImagen = ref(null)
const imagenPreview = ref('')

const tituloImagen = ref('')
const archivoImagen = ref(null)

const puestoSeleccionado = ref('')
const eppsSeleccionados = ref([])

const urlImagen = (ruta) => {
  if (!ruta) return ''

  if (
    ruta.startsWith('http://') ||
    ruta.startsWith('https://')
  ) {
    return ruta
  }

  return API + ruta
}

function mostrarMensaje(texto, tipo = 'success') {
  mensaje.value = texto
  tipoMensaje.value = tipo

  setTimeout(() => {
    mensaje.value = ''
    tipoMensaje.value = ''
  }, 3000)
}

async function cargarTodo() {
  cargando.value = true

  try {
    const [
      respuestaImagenes,
      respuestaEpps,
      respuestaPuestos,
      respuestaRelaciones
    ] = await Promise.all([
      axios.get(API + 'imagenesprev_listar.php'),
      axios.get(API + 'epp_listar.php'),
      axios.get(API + 'puestos_listar.php'),
      axios.get(API + 'puestos_epp_listar.php')
    ])

    imagenes.value =
      respuestaImagenes.data.imagenes || []

    epps.value =
      respuestaEpps.data.epps || []

    puestos.value =
      respuestaPuestos.data.puestos || []

    relaciones.value =
      respuestaRelaciones.data.relaciones || []

    if (puestoSeleccionado.value) {
      seleccionarPuesto()
    }

  } catch (error) {
    console.error(
      'Error cargando datos:',
      error
    )

    mostrarMensaje(
      'No se pudieron cargar los datos.',
      'error'
    )

  } finally {
    cargando.value = false
  }
}

/* =========================
   IMÁGENES
========================= */

function seleccionarArchivoImagen(event) {
  const archivo = event.target.files[0]

  if (!archivo) {
    archivoImagen.value = null
    return
  }

  archivoImagen.value = archivo
}

async function subirImagen() {
  if (!tituloImagen.value.trim()) {
    mostrarMensaje(
      'El título de la imagen es obligatorio.',
      'error'
    )
    return
  }

  if (!archivoImagen.value) {
    mostrarMensaje(
      'Seleccioná una imagen.',
      'error'
    )
    return
  }

  const formData = new FormData()

  formData.append(
    'titulo',
    tituloImagen.value.trim()
  )

  formData.append(
    'archivo',
    archivoImagen.value
  )

  try {
    const respuesta = await fetch(
      API + 'imagenesprev_subir.php',
      {
        method: 'POST',
        body: formData
      }
    )

    const data = await respuesta.json()

    console.log(
      'Respuesta imagen:',
      data
    )

    if (data.ok) {

      mostrarMensaje(
        'Imagen subida correctamente.'
      )

      tituloImagen.value = ''
      archivoImagen.value = null

      const input =
        document.getElementById(
          'archivoImagen'
        )

      if (input) {
        input.value = ''
      }

      await cargarTodo()

    } else {

      mostrarMensaje(
        data.mensaje ||
        'No se pudo subir la imagen.',
        'error'
      )
    }

  } catch (error) {

    console.error(error)

    mostrarMensaje(
      'No se pudo subir la imagen.',
      'error'
    )
  }
}

async function eliminarImagen(id) {
  if (
    !confirm(
      '¿Seguro que querés eliminar esta imagen?'
    )
  ) {
    return
  }

  try {
    const respuesta = await fetch(
      API + 'imagenesprev_eliminar.php',
      {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          id: id
        })
      }
    )

    const data =
      await respuesta.json()

    if (data.ok) {

      mostrarMensaje(
        'Imagen eliminada correctamente.'
      )

      await cargarTodo()

    } else {

      mostrarMensaje(
        data.mensaje ||
        'No se pudo eliminar la imagen.',
        'error'
      )
    }

  } catch (error) {

    console.error(error)

    mostrarMensaje(
      'No se pudo eliminar la imagen.',
      'error'
    )
  }
}

/* =========================
   EPP
========================= */

function abrirNuevoEpp() {
  editandoEpp.value = false
  eppId.value = null
  eppTitulo.value = ''
  eppTexto.value = ''
  eppImagen.value = null
  imagenPreview.value = ''
  mostrarFormularioEpp.value = true
}

function editarEpp(epp) {
  editandoEpp.value = true

  eppId.value = epp.id

  eppTitulo.value =
    epp.titulo || ''

  eppTexto.value =
    epp.texto || ''

  eppImagen.value = null

  if (epp.multimedia_url) {
    imagenPreview.value =
      urlImagen(
        epp.multimedia_url
      )
  } else {
    imagenPreview.value = ''
  }

  mostrarFormularioEpp.value = true
}

function cerrarFormularioEpp() {
  mostrarFormularioEpp.value = false
  editandoEpp.value = false
  eppId.value = null
  eppTitulo.value = ''
  eppTexto.value = ''
  eppImagen.value = null
  imagenPreview.value = ''
}

function seleccionarImagenEpp(event) {
  const archivo =
    event.target.files[0]

  if (!archivo) {
    eppImagen.value = null
    return
  }

  eppImagen.value = archivo

  imagenPreview.value =
    URL.createObjectURL(
      archivo
    )
}

async function guardarEpp() {
  if (!eppTitulo.value.trim()) {
    mostrarMensaje(
      'El nombre del EPP es obligatorio.',
      'error'
    )
    return
  }

  const formData =
    new FormData()

  formData.append(
    'titulo',
    eppTitulo.value.trim()
  )

  formData.append(
    'texto',
    eppTexto.value.trim()
  )

  if (eppImagen.value) {
    formData.append(
      'imagen',
      eppImagen.value,
      eppImagen.value.name
    )
  }

  if (editandoEpp.value) {
    formData.append(
      'id',
      String(eppId.value)
    )
  }

  try {

    const url =
      editandoEpp.value
        ? API + 'epp_modificar.php'
        : API + 'epp_crear.php'

    const respuesta =
      await fetch(
        url,
        {
          method: 'POST',
          body: formData
        }
      )

    const textoRespuesta =
      await respuesta.text()

    console.log(
      'Respuesta del servidor:',
      textoRespuesta
    )

    let data

    try {

      data =
        JSON.parse(
          textoRespuesta
        )

    } catch (error) {

      console.error(
        'El servidor no devolvió JSON válido:',
        textoRespuesta
      )

      mostrarMensaje(
        'El servidor devolvió una respuesta incorrecta.',
        'error'
      )

      return
    }

    if (data.ok) {

      mostrarMensaje(
        editandoEpp.value
          ? 'EPP modificado correctamente.'
          : 'EPP creado correctamente.'
      )

      cerrarFormularioEpp()

      await cargarTodo()

    } else {

      mostrarMensaje(
        data.mensaje ||
        'No se pudo guardar el EPP.',
        'error'
      )
    }

  } catch (error) {

    console.error(error)

    mostrarMensaje(
      'No se pudo guardar el EPP.',
      'error'
    )
  }
}

async function eliminarEpp(id) {
  if (
    !confirm(
      '¿Seguro que querés eliminar este EPP?'
    )
  ) {
    return
  }

  try {

    const respuesta =
      await fetch(
        API + 'epp_eliminar.php',
        {
          method: 'POST',
          headers: {
            'Content-Type':
              'application/json'
          },
          body: JSON.stringify({
            id: id
          })
        }
      )

    const data =
      await respuesta.json()

    if (data.ok) {

      mostrarMensaje(
        'EPP eliminado correctamente.'
      )

      await cargarTodo()

    } else {

      mostrarMensaje(
        data.mensaje ||
        'No se pudo eliminar el EPP.',
        'error'
      )
    }

  } catch (error) {

    console.error(error)

    mostrarMensaje(
      'No se pudo eliminar el EPP.',
      'error'
    )
  }
}

/* =========================
   EPP POR PUESTO
========================= */

function obtenerPuestoId() {
  return Number(
    puestoSeleccionado.value
  )
}

function obtenerRelacionPuestoId(relacion) {
  return Number(
    relacion.puesto_id ??
    relacion.id_puesto ??
    0
  )
}

function obtenerRelacionEppId(relacion) {
  return Number(
    relacion.epp_id ??
    relacion.id_epp ??
    0
  )
}

function seleccionarPuesto() {

  const puestoId =
    obtenerPuestoId()

  if (!puestoId) {
    eppsSeleccionados.value = []
    return
  }

  const relacionesPuesto =
    relaciones.value.filter(
      relacion =>
        obtenerRelacionPuestoId(
          relacion
        ) === puestoId
    )

  eppsSeleccionados.value =
    relacionesPuesto
      .map(
        relacion =>
          obtenerRelacionEppId(
            relacion
          )
      )
      .filter(
        id => id > 0
      )
}

function estaSeleccionado(eppId) {

  const id =
    Number(eppId)

  return eppsSeleccionados.value
    .map(
      item => Number(item)
    )
    .includes(id)
}

function cambiarEpp(eppId) {

  const id =
    Number(eppId)

  const seleccionados =
    eppsSeleccionados.value
      .map(
        item => Number(item)
      )

  if (
    seleccionados.includes(id)
  ) {

    eppsSeleccionados.value =
      seleccionados.filter(
        item => item !== id
      )

  } else {

    eppsSeleccionados.value = [
      ...seleccionados,
      id
    ]
  }
}

async function guardarEppPuesto() {

  const puestoId =
    obtenerPuestoId()

  if (!puestoId) {

    mostrarMensaje(
      'Seleccioná un puesto.',
      'error'
    )

    return
  }

  const idsEpp =
    eppsSeleccionados.value
      .map(
        id => Number(id)
      )
      .filter(
        id => id > 0
      )

  try {

    console.log(
      'Guardando puesto:',
      puestoId
    )

    console.log(
      'Guardando EPP:',
      idsEpp
    )

    const respuesta =
      await fetch(
        API + 'puesto_epp_guardar.php',
        {
          method: 'POST',
          headers: {
            'Content-Type':
              'application/json'
          },
          body: JSON.stringify({
            puesto_id: puestoId,
            epp_ids: idsEpp
          })
        }
      )

    const textoRespuesta =
      await respuesta.text()

    console.log(
      'Respuesta guardar EPP:',
      textoRespuesta
    )

    let data

    try {

      data =
        JSON.parse(
          textoRespuesta
        )

    } catch (error) {

      console.error(
        'Respuesta no válida:',
        textoRespuesta
      )

      mostrarMensaje(
        'El servidor devolvió una respuesta incorrecta.',
        'error'
      )

      return
    }

    if (!data.ok) {

      console.error(
        'Error guardando EPP:',
        data
      )

      mostrarMensaje(
        data.mensaje ||
        'No se pudieron guardar los EPP.',
        'error'
      )

      return
    }

    await cargarRelaciones()

    seleccionarPuesto()

    mostrarMensaje(
      'EPP del puesto actualizado correctamente.'
    )

  } catch (error) {

    console.error(
      'Error guardando EPP:',
      error
    )

    mostrarMensaje(
      'No se pudieron guardar los EPP del puesto.',
      'error'
    )
  }
}

async function cargarRelaciones() {

  try {

    const respuesta =
      await axios.get(
        API + 'puestos_epp_listar.php'
      )

    console.log(
      'Relaciones cargadas:',
      respuesta.data
    )

    relaciones.value =
      respuesta.data.relaciones || []

  } catch (error) {

    console.error(
      'Error cargando relaciones:',
      error
    )

    relaciones.value = []

  }
}

const puestoActual = computed(() => {

  return puestos.value.find(
    puesto =>
      Number(puesto.id) ===
      obtenerPuestoId()
  )

})

function eppsDelPuesto(puestoId) {

  const relacionesPuesto =
    relaciones.value.filter(
      relacion =>
        obtenerRelacionPuestoId(
          relacion
        ) ===
        Number(puestoId)
    )

  return relacionesPuesto
    .map(relacion => {

      const eppId =
        obtenerRelacionEppId(
          relacion
        )

      return epps.value.find(
        epp =>
          Number(epp.id) ===
          eppId
      )

    })
    .filter(
      epp => epp
    )
}

/* =========================
   INICIO
========================= */

onMounted(async () => {
  await cargarTodo()
})
</script>

<template>
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
  <div class="contenedor">

    <div
      v-if="mensaje"
      class="mensaje"
      :class="tipoMensaje"
    >
      {{ mensaje }}
    </div>

    <div class="encabezado">

      <div>

        <h1>
          Higiene y Seguridad
        </h1>

        <p>
          Administración de imágenes, EPP y puestos de trabajo.
        </p>

      </div>

    </div>

    <!-- =========================
         IMÁGENES
    ========================== -->

    <section class="seccion">

      <div class="titulo-seccion">

        <div>

          <h2>
            Imágenes
          </h2>

          <p>
            Agregá imágenes para la sección de Higiene y Seguridad.
          </p>

        </div>

      </div>

      <div class="formulario-imagen">

        <div class="campo">

          <label>
            Título
          </label>

          <input
            v-model="tituloImagen"
            type="text"
            placeholder="Título de la imagen"
          />

        </div>

        <div class="campo">

          <label>
            Imagen
          </label>

          <input
            id="archivoImagen"
            type="file"
            accept="image/png,image/jpeg,image/webp"
            @change="seleccionarArchivoImagen"
          />

        </div>

        <button
          class="boton principal"
          @click="subirImagen"
        >
          Subir imagen
        </button>

      </div>

      <div
        v-if="imagenes.length"
        class="galeria"
      >

        <div
          v-for="imagen in imagenes"
          :key="imagen.id"
          class="tarjeta-imagen"
        >

          <img
            :src="urlImagen(imagen.multimedia_url)"
            :alt="imagen.titulo"
          />

          <div class="contenido-imagen">

            <h3>
              {{ imagen.titulo }}
            </h3>

            <button
              class="boton eliminar"
              @click="eliminarImagen(imagen.id)"
            >
              Eliminar
            </button>

          </div>

        </div>

      </div>

      <div
        v-else
        class="sin-datos"
      >
        No hay imágenes cargadas.
      </div>

    </section>

    <!-- =========================
         EPP
    ========================== -->

    <section class="seccion">

      <div class="titulo-seccion">

        <div>

          <h2>
            EPP
          </h2>

          <p>
            Administrá los elementos de protección personal.
          </p>

        </div>

        <button
          class="boton principal"
          @click="abrirNuevoEpp"
        >
          + Nuevo EPP
        </button>

      </div>

      <div
        v-if="mostrarFormularioEpp"
        class="formulario-epp"
      >

        <h3>

          {{
            editandoEpp
              ? 'Editar EPP'
              : 'Nuevo EPP'
          }}

        </h3>

        <div class="campo">

          <label>
            Nombre del EPP
          </label>

          <input
            v-model="eppTitulo"
            type="text"
            placeholder="Ejemplo: Casco"
          />

        </div>

        <div class="campo">

          <label>
            Descripción
          </label>

          <textarea
            v-model="eppTexto"
            placeholder="Descripción del elemento"
            rows="5"
          ></textarea>

        </div>

        <div class="campo">

          <label>
            Imagen
          </label>

          <input
            type="file"
            accept="image/png,image/jpeg,image/webp"
            @change="seleccionarImagenEpp"
          />

        </div>

        <div
          v-if="imagenPreview"
          class="preview"
        >

          <img
            :src="imagenPreview"
            alt="Vista previa"
          />

        </div>

        <div class="botones">

          <button
            class="boton principal"
            @click="guardarEpp"
          >
            {{
              editandoEpp
                ? 'Guardar cambios'
                : 'Crear EPP'
            }}
          </button>

          <button
            class="boton cancelar"
            @click="cerrarFormularioEpp"
          >
            Cancelar
          </button>

        </div>

      </div>

      <div
        v-if="epps.length"
        class="lista-epp"
      >

        <div
          v-for="epp in epps"
          :key="epp.id"
          class="tarjeta-epp"
        >

          <div class="imagen-epp">

            <img
              v-if="epp.multimedia_url"
              :src="urlImagen(epp.multimedia_url)"
              :alt="epp.titulo"
            />

            <div
              v-else
              class="sin-imagen"
            >
              Sin imagen
            </div>

          </div>

          <div class="contenido-epp">

            <h3>
              {{ epp.titulo }}
            </h3>

            <p>
              {{ epp.texto }}
            </p>

            <div class="botones">

              <button
                class="boton editar"
                @click="editarEpp(epp)"
              >
                Editar
              </button>

              <button
                class="boton eliminar"
                @click="eliminarEpp(epp.id)"
              >
                Eliminar
              </button>

            </div>

          </div>

        </div>

      </div>

      <div
        v-else
        class="sin-datos"
      >
        No hay EPP cargados.
      </div>

    </section>

    <!-- =========================
         EPP POR PUESTO
    ========================== -->

    <section class="seccion">

      <div class="titulo-seccion">

        <div>

          <h2>
            EPP por puesto
          </h2>

          <p>
            Elegí un puesto y seleccioná los EPP que corresponden.
          </p>

        </div>

      </div>

      <div class="formulario-puesto">

        <div class="campo">

          <label>
            Puesto de trabajo
          </label>

          <select
            v-model="puestoSeleccionado"
            @change="seleccionarPuesto"
          >

            <option value="">
              Seleccioná un puesto
            </option>

            <option
              v-for="puesto in puestos"
              :key="puesto.id"
              :value="puesto.id"
            >
              {{ puesto.nombre }}
            </option>

          </select>

        </div>

        <div
          v-if="puestoActual"
          class="puesto-seleccionado"
        >

          Puesto seleccionado:

          <strong>
            {{ puestoActual.nombre }}
          </strong>

        </div>

        <div
          v-if="puestoSeleccionado"
          class="lista-checkbox"
        >

          <label
            v-for="epp in epps"
            :key="epp.id"
            class="checkbox-epp"
          >

            <input
              type="checkbox"
              :checked="estaSeleccionado(epp.id)"
              @change="cambiarEpp(epp.id)"
            />

            <span>
              {{ epp.titulo }}
            </span>

          </label>

        </div>

        <div
          v-if="puestoSeleccionado"
          class="botones"
        >

          <button
            class="boton principal"
            @click="guardarEppPuesto"
          >
            Guardar EPP del puesto
          </button>

        </div>

      </div>

      <div
        v-if="!puestos.length"
        class="sin-datos"
      >
        No hay puestos cargados.
      </div>

    </section>

    <!-- =========================
         VISTA FINAL
    ========================== -->

    <section class="seccion">

      <div class="titulo-seccion">

        <div>

          <h2>
            Vista de EPP por puesto
          </h2>

          <p>
            Acá podés ver los EPP que tiene asignado cada puesto.
          </p>

        </div>

      </div>

      <div
        v-if="puestos.length"
        class="vista-puestos"
      >

        <div
          v-for="puesto in puestos"
          :key="puesto.id"
          class="tarjeta-puesto"
        >

          <div class="cabecera-puesto">

            <h3>
              {{ puesto.nombre }}
            </h3>

          </div>

          <div
            v-if="eppsDelPuesto(puesto.id).length"
            class="epps-puesto"
          >

            <div
              v-for="epp in eppsDelPuesto(puesto.id)"
              :key="epp.id"
              class="tarjeta-epp-puesto"
            >

              <div class="imagen-epp-puesto">

                <img
                  v-if="epp.multimedia_url"
                  :src="urlImagen(epp.multimedia_url)"
                  :alt="epp.titulo"
                />

                <div
                  v-else
                  class="sin-imagen-puesto"
                >
                  Sin imagen
                </div>

              </div>

              <div class="contenido-epp-puesto">

                <h4>
                  {{ epp.titulo }}
                </h4>

                <p>
                  {{ epp.texto || 'Sin descripción.' }}
                </p>

              </div>

            </div>

          </div>

          <div
            v-else
            class="sin-epp-puesto"
          >
            Este puesto no tiene EPP asignados.
          </div>

        </div>

      </div>

      <div
        v-else
        class="sin-datos"
      >
        No hay puestos cargados.
      </div>

    </section>

  </div>

</template>

<style scoped>


@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

* {
  box-sizing: border-box;
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
  flex-wrap: wrap;
  background-color: #FFFFFF;
}

.nav-link {
  position: relative;
  min-height: 65px;
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

.contenedor {
  width: 100%;
  min-height: 100vh;
  padding: 40px;
  background: #EDEDED;
  color: #4A4A4E;
  font-family: 'Poppins', sans-serif;
}

.contenedor > .encabezado {
  margin-bottom: 30px;
  background: transparent;
  box-shadow: none;
}

.encabezado h1 {
  margin: 0 0 8px;
  font-size: 32px;
  font-weight: 800;
  color: #4A4A4E;
}

.encabezado p {
  margin: 0;
  font-size: 16px;
  color: #777;
}

.mensaje {
  position: fixed;
  top: 25px;
  right: 25px;
  z-index: 1000;
  padding: 15px 22px;
  border-radius: 12px;
  font-weight: 600;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.mensaje.success {
  background: #FFFFFF;
  color: #238636;
  border: 2px solid #238636;
}

.mensaje.error {
  background: #FFFFFF;
  color: #EB3135;
  border: 2px solid #EB3135;
}

.seccion {
  background: #FFFFFF;
  border-radius: 20px;
  padding: 30px;
  margin-bottom: 30px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.titulo-seccion {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-bottom: 25px;
}

.titulo-seccion h2 {
  margin: 0 0 6px;
  font-size: 25px;
}

.titulo-seccion p {
  margin: 0;
  color: #777;
}

.formulario-imagen,
.formulario-epp,
.formulario-puesto {
  background: #F7F7F7;
  border-radius: 15px;
  padding: 25px;
  margin-bottom: 25px;
}

.formulario-epp h3 {
  margin-top: 0;
  font-size: 22px;
}

.campo {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 18px;
}

.campo label {
  font-weight: 700;
}

.campo input,
.campo textarea,
.campo select {
  width: 100%;
  padding: 13px 15px;
  border: 1px solid #D0D0D0;
  border-radius: 10px;
  background: #FFFFFF;
  color: #4A4A4E;
  font-family: inherit;
  font-size: 15px;
}

.campo textarea {
  resize: vertical;
}

.campo input:focus,
.campo textarea:focus,
.campo select:focus {
  outline: none;
  border-color: #EB3135;
}

.boton {
  border: none;
  border-radius: 10px;
  padding: 11px 18px;
  cursor: pointer;
  font-weight: 700;
  font-size: 14px;
  font-family: inherit;
  transition: 0.2s;
}

.boton:hover {
  transform: translateY(-1px);
}

.boton.principal {
  background: #EB3135;
  color: #FFFFFF;
}

.boton.editar {
  background: #4A4A4E;
  color: #FFFFFF;
}

.boton.eliminar {
  background: #EB3135;
  color: #FFFFFF;
}

.boton.cancelar {
  background: #BDC0C3;
  color: #4A4A4E;
}

.botones {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.galeria {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 20px;
}

.tarjeta-imagen {
  background: #F7F7F7;
  border-radius: 15px;
  overflow: hidden;
  border: 1px solid #E0E0E0;
}

.tarjeta-imagen img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

.contenido-imagen {
  padding: 15px;
}

.contenido-imagen h3 {
  margin: 0 0 12px;
  font-size: 17px;
}

.lista-epp {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.tarjeta-epp {
  display: flex;
  flex-direction: column;
  background: #F7F7F7;
  border: 1px solid #E0E0E0;
  border-radius: 15px;
  overflow: hidden;
}

.imagen-epp {
  width: 100%;
  height: 200px;
  background: #EDEDED;
}

.imagen-epp img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.sin-imagen {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #888;
}

.contenido-epp {
  padding: 20px;
}

.contenido-epp h3 {
  margin: 0 0 10px;
  font-size: 20px;
}

.contenido-epp p {
  margin: 0 0 18px;
  color: #666;
  line-height: 1.5;
}

.preview {
  margin-bottom: 20px;
}

.preview img {
  width: 180px;
  height: 180px;
  object-fit: cover;
  border-radius: 12px;
  border: 1px solid #DDD;
}

.puesto-seleccionado {
  background: #FFFFFF;
  border-radius: 10px;
  padding: 15px;
  margin-bottom: 20px;
}

.lista-checkbox {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 12px;
  margin-bottom: 20px;
}

.checkbox-epp {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #FFFFFF;
  border: 1px solid #DDD;
  border-radius: 10px;
  padding: 14px;
  cursor: pointer;
}

.checkbox-epp input {
  width: 18px;
  height: 18px;
  accent-color: #EB3135;
}

.sin-datos {
  text-align: center;
  padding: 30px;
  color: #888;
  background: #F7F7F7;
  border-radius: 12px;
}

.vista-puestos {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.tarjeta-puesto {
  background: #F7F7F7;
  border: 1px solid #E0E0E0;
  border-radius: 15px;
  padding: 18px;
}

.cabecera-puesto {
  margin-bottom: 15px;
  padding-bottom: 12px;
  border-bottom: 1px solid #DDD;
}

.cabecera-puesto h3 {
  margin: 0;
  font-size: 20px;
  color: #4A4A4E;
}

.epps-puesto {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
}

.tarjeta-epp-puesto {
  display: flex;
  flex-direction: column;
  background: #FFFFFF;
  border: 1px solid #E0E0E0;
  border-radius: 10px;
  overflow: hidden;
}

.imagen-epp-puesto {
  width: 100%;
  height: 110px;
  background: #EDEDED;
}

.imagen-epp-puesto img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.sin-imagen-puesto {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #888;
  font-size: 12px;
}

.contenido-epp-puesto {
  padding: 10px;
}

.contenido-epp-puesto h4 {
  margin: 0 0 5px;
  font-size: 15px;
  color: #4A4A4E;
}

.contenido-epp-puesto p {
  margin: 0;
  color: #666;
  line-height: 1.3;
  font-size: 12px;
}

.sin-epp-puesto {
  padding: 15px;
  background: #FFFFFF;
  border-radius: 10px;
  color: #888;
  font-size: 14px;
  text-align: center;
}

@media (max-width: 900px) {
  .epps-puesto {
    grid-template-columns: repeat(2, 1fr);
  }

  .nav-link {
    padding: 0 15px;
  }
}

@media (max-width: 600px) {
  nav {
    justify-content: flex-start;
    padding: 0 10px;
  }

  .nav-link {
    min-height: 55px;
    padding: 0 10px;
    font-size: 12px;
  }

  .contenedor {
    padding: 20px;
  }

  .seccion {
    padding: 20px;
  }

  .titulo-seccion {
    align-items: flex-start;
    flex-direction: column;
  }

  .epps-puesto {
    grid-template-columns: 1fr;
  }
}


</style>