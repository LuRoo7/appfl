
<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'
import { RouterLink } from 'vue-router'
import axios from 'axios'
import JsBarcode from 'jsbarcode'

const API = 'http://localhost/backend/'

const empleados = ref([])
const legajoSeleccionado = ref('')
const empleadoSeleccionado = ref(null)
const recibos = ref([])
const arts = ref([])
const vacaciones = ref([])
const certificados = ref([])
const codigoBarras = ref(null)

const periodo = ref('')
const archivoRecibo = ref(null)
const tituloART = ref('ART')
const textoART = ref('')
const archivoART = ref(null)

const vacacionesForm = ref({
  id: null,
  fecha_inicio: '',
  fecha_fin: '',
  mensaje: ''
})

const cargando = ref(false)
const mensaje = ref('')
const error = ref('')

const normalizarLista = (data, clave) => {
  if (Array.isArray(data)) return data
  if (Array.isArray(data?.[clave])) return data[clave]
  if (Array.isArray(data?.datos)) return data.datos
  return []
}

const mostrarMensaje = (texto) => {
  mensaje.value = texto
  error.value = ''
}

const mostrarError = (e) => {
  const detalle = e.response?.data
  error.value = typeof detalle === 'string'
    ? detalle
    : detalle?.mensaje || detalle?.error || e.message || 'Ocurrió un error.'
  mensaje.value = ''
}

const mostrarDiagnostico = (titulo, e) => {
  const detalle = e.response?.data ?? e.message ?? e
  const contenido = typeof detalle === 'string'
    ? detalle
    : JSON.stringify(detalle, null, 2)

  window.alert(
    titulo + '\n\n' +
    'Código HTTP: ' + (e.response?.status ?? 'Sin respuesta HTTP') +
    '\n\nRespuesta del servidor:\n' + contenido
  )
  mostrarError(e)
}

const cargarEmpleados = async () => {
  try {
    const respuesta = await axios.get(API + 'empleados_listar.php')
    empleados.value = normalizarLista(respuesta.data, 'empleados')
  } catch (e) {
    mostrarError(e)
  }
}

const generarCodigoBarras = async () => {
  await nextTick()
  if (!codigoBarras.value || !legajoSeleccionado.value) return

  try {
    JsBarcode(codigoBarras.value, String(legajoSeleccionado.value), {
      format: 'CODE128',
      displayValue: true,
      fontSize: 16,
      height: 65,
      margin: 10,
      background: '#ffffff',
      lineColor: '#222222'
    })
  } catch {
    error.value = 'No se pudo generar el código de barras.'
  }
}

const cargarDatosEmpleado = async () => {
  if (!legajoSeleccionado.value) {
    empleadoSeleccionado.value = null
    recibos.value = []
    arts.value = []
    vacaciones.value = []
    certificados.value = []
    return
  }

  const legajo = legajoSeleccionado.value
  empleadoSeleccionado.value = empleados.value.find(
    e => String(e.legajo) === String(legajo)
  ) || null

  cargando.value = true
  mensaje.value = ''
  error.value = ''

  try {
    const resultados = await Promise.all([
      axios.get(API + 'sueldo_listar.php', { params: { legajo } }),
      axios.get(API + 'art_listar.php', { params: { legajo } }),
      axios.get(API + 'vacaciones_listar.php', { params: { legajo } }),
      axios.get(API + 'certificados_listar.php', { params: { legajo } })
    ])

    recibos.value = normalizarLista(resultados[0].data, 'recibos')
    arts.value = normalizarLista(resultados[1].data, 'arts')
    vacaciones.value = normalizarLista(resultados[2].data, 'vacaciones')
    certificados.value = normalizarLista(resultados[3].data, 'certificados')

    const ultimaVacacion = vacaciones.value[0]

    vacacionesForm.value = ultimaVacacion
      ? {
          id: ultimaVacacion.id ?? null,
          fecha_inicio: ultimaVacacion.fecha_inicio ?? '',
          fecha_fin: ultimaVacacion.fecha_fin ?? '',
          mensaje: ultimaVacacion.mensaje ?? ''
        }
      : {
          id: null,
          fecha_inicio: '',
          fecha_fin: '',
          mensaje: ''
        }

    await generarCodigoBarras()
  } catch (e) {
    mostrarError(e)
  } finally {
    cargando.value = false
  }
}

watch(legajoSeleccionado, cargarDatosEmpleado)

const seleccionarRecibo = (evento) => {
  archivoRecibo.value = evento.target.files?.[0] || null
}

const subirRecibo = async () => {
  if (!legajoSeleccionado.value || !periodo.value.trim() || !archivoRecibo.value) {
    error.value = 'Seleccioná un empleado, completá el período y elegí el PDF.'
    return
  }

  if (archivoRecibo.value.type !== 'application/pdf') {
    error.value = 'El recibo debe estar en formato PDF.'
    return
  }

  const datos = new FormData()
  datos.append('legajo', String(legajoSeleccionado.value))
  datos.append('periodo', periodo.value.trim())
  datos.append('archivo', archivoRecibo.value)

  try {
    cargando.value = true
    mensaje.value = ''
    error.value = ''

    await axios.post(API + 'sueldo_subir.php', datos)

    periodo.value = ''
    archivoRecibo.value = null
    mostrarMensaje('Recibo de sueldo cargado correctamente.')
    await cargarDatosEmpleado()
  } catch (e) {
    mostrarDiagnostico('ERROR AL SUBIR EL RECIBO', e)
  } finally {
    cargando.value = false
  }
}

const seleccionarART = (evento) => {
  archivoART.value = evento.target.files?.[0] || null
}

const subirART = async () => {
  if (!legajoSeleccionado.value || !tituloART.value.trim() || !archivoART.value) {
    error.value = 'Completá el título y seleccioná el PDF de ART.'
    return
  }

  if (archivoART.value.type !== 'application/pdf') {
    error.value = 'El documento de ART debe estar en formato PDF.'
    return
  }

  const datos = new FormData()
  datos.append('legajo', String(legajoSeleccionado.value))
  datos.append('titulo', tituloART.value.trim())
  datos.append('texto', textoART.value)
  datos.append('archivo', archivoART.value)

  try {
    cargando.value = true
    mensaje.value = ''
    error.value = ''

    await axios.post(API + 'art_subir.php', datos)

    tituloART.value = 'ART'
    textoART.value = ''
    archivoART.value = null
    mostrarMensaje('Documento de ART cargado correctamente.')
    await cargarDatosEmpleado()
  } catch (e) {
    mostrarDiagnostico('ERROR AL SUBIR ART', e)
  } finally {
    cargando.value = false
  }
}

const guardarVacaciones = async () => {
  const v = vacacionesForm.value

  if (
    !legajoSeleccionado.value ||
    !v.fecha_inicio ||
    !v.fecha_fin ||
    !v.mensaje.trim()
  ) {
    error.value = 'Completá las fechas y el mensaje de vacaciones.'
    return
  }

  if (v.fecha_fin < v.fecha_inicio) {
    error.value = 'La fecha de fin no puede ser anterior al inicio.'
    return
  }

  try {
    cargando.value = true

    await axios.post(API + 'vacaciones_guardar.php', {
      id: v.id,
      legajo: Number(legajoSeleccionado.value),
      fecha_inicio: v.fecha_inicio,
      fecha_fin: v.fecha_fin,
      mensaje: v.mensaje
    })

    mostrarMensaje('Información de vacaciones guardada.')
    await cargarDatosEmpleado()
  } catch (e) {
    mostrarError(e)
  } finally {
    cargando.value = false
  }
}

const urlArchivo = (ruta) => {
  if (!ruta) return '#'
  if (/^https?:\/\//i.test(ruta)) return ruta
  return API + ruta.replace(/^\/+/, '')
}

onMounted(cargarEmpleados)
</script>

<template>
  <div class="pagina-admin">
    <header class="barra-navegacion">
      <nav>
        <RouterLink to="/EmpleadosAdmin" class="nav-link">Empleados</RouterLink>
        <RouterLink to="/calendario" class="nav-link">Calendario</RouterLink>
        <RouterLink to="/NovedadesAdmin" class="nav-link">Novedades y Preguntas</RouterLink>
        <RouterLink to="/HigieneAdmin" class="nav-link">Higiene Administración</RouterLink>
        <RouterLink to="/capacitacionesadmin" class="nav-link">Capacitaciones</RouterLink>
        <RouterLink to="/Miperfiladmin" class="nav-link">Mi perfil</RouterLink>
      </nav>
    </header>

    <main class="admin-perfil">
      <header class="titulo-pagina">
        <span>FRONTERA LIVING</span>
        <h1>Administración de perfiles</h1>
        <p>Gestioná la documentación y la información laboral de cada empleado.</p>
      </header>

      <section class="panel seleccion">
        <label for="empleado">Seleccionar empleado</label>
        <select id="empleado" v-model="legajoSeleccionado">
          <option value="">Elegí un empleado</option>
          <option
            v-for="empleado in empleados"
            :key="empleado.legajo"
            :value="String(empleado.legajo)"
          >
            {{ empleado.nombre }} — Legajo {{ empleado.legajo }}
          </option>
        </select>

        <p v-if="!empleados.length">
          Si no aparecen empleados, verificá empleados_listar.php.
        </p>

        <div v-if="empleadoSeleccionado" class="datos-empleado">
          <strong>{{ empleadoSeleccionado.nombre }}</strong>
          <span>Legajo: {{ empleadoSeleccionado.legajo }}</span>
        </div>
      </section>

      <p v-if="mensaje" class="aviso">{{ mensaje }}</p>
      <p v-if="error" class="error">{{ error }}</p>
      <p v-if="cargando" class="estado">Procesando...</p>

      <template v-if="legajoSeleccionado">
        <section class="panel">
          <h2>Código de barras</h2>
          <p>Se genera automáticamente a partir del legajo seleccionado.</p>
          <div class="barcode"><svg ref="codigoBarras"></svg></div>
          <button class="secundario" type="button" @click="generarCodigoBarras">
            Generar código
          </button>
        </section>

        <section class="panel">
          <h2>Recibos de sueldo</h2>
          <form @submit.prevent="subirRecibo">
            <label>Período del recibo</label>
            <input v-model="periodo" type="text" placeholder="Ej.: Septiembre 2026" required />
            <label>Archivo PDF</label>
            <input type="file" accept=".pdf,application/pdf" required @change="seleccionarRecibo" />
            <button class="principal" type="submit">Subir recibo</button>
          </form>

          <h3>Recibos cargados</h3>
          <p v-if="!recibos.length">No hay recibos registrados.</p>
          <ul v-else class="archivos">
            <li v-for="recibo in recibos" :key="recibo.id">
              <span>{{ recibo.periodo }}</span>
              <a :href="urlArchivo(recibo.archivo_pdf_url)" target="_blank" rel="noopener noreferrer">Ver PDF</a>
            </li>
          </ul>
        </section>

        <section class="panel">
          <h2>ART individual</h2>
          <form @submit.prevent="subirART">
            <label>Título</label>
            <input v-model="tituloART" type="text" required />
            <label>Descripción (opcional)</label>
            <textarea v-model="textoART" rows="3"></textarea>
            <label>Documento PDF</label>
            <input type="file" accept=".pdf,application/pdf" required @change="seleccionarART" />
            <button class="principal" type="submit">Subir documento ART</button>
          </form>

          <h3>Documentos ART</h3>
          <p v-if="!arts.length">No hay documentos ART registrados.</p>
          <ul v-else class="archivos">
            <li v-for="art in arts" :key="art.id">
              <span>{{ art.titulo }}</span>
              <a :href="urlArchivo(art.archivo_pdf_url)" target="_blank" rel="noopener noreferrer">Ver PDF</a>
            </li>
          </ul>
        </section>

        <section class="panel">
          <h2>Vacaciones</h2>
          <form @submit.prevent="guardarVacaciones">
            <label>Fecha de inicio</label>
            <input v-model="vacacionesForm.fecha_inicio" type="date" required />
            <label>Fecha de fin</label>
            <input v-model="vacacionesForm.fecha_fin" type="date" required />
            <label>Mensaje para el empleado</label>
            <textarea v-model="vacacionesForm.mensaje" rows="4" placeholder="Escribí la información que verá el empleado" required></textarea>
            <button class="principal" type="submit">Guardar vacaciones</button>
          </form>

          <h3>Registros de vacaciones</h3>
          <p v-if="!vacaciones.length">No hay vacaciones registradas.</p>
          <ul v-else class="archivos">
            <li v-for="vacacion in vacaciones" :key="vacacion.id" class="vacacion-item">
              <div>
                <strong>{{ vacacion.fecha_inicio }} al {{ vacacion.fecha_fin }}</strong>
                <p>{{ vacacion.mensaje }}</p>
              </div>
              <button
                class="secundario"
                type="button"
                @click="vacacionesForm = {
                  id: vacacion.id,
                  fecha_inicio: vacacion.fecha_inicio,
                  fecha_fin: vacacion.fecha_fin,
                  mensaje: vacacion.mensaje
                }"
              >
                Editar
              </button>
            </li>
          </ul>
        </section>

        <section class="panel">
          <h2>Certificados médicos</h2>
          <p>Documentos que el empleado ya haya cargado.</p>
          <p v-if="!certificados.length">No hay certificados médicos registrados.</p>
          <ul v-else class="archivos">
            <li v-for="certificado in certificados" :key="certificado.id">
              <span>Certificado — {{ certificado.fecha_subida || 'Sin fecha' }}</span>
              <a :href="urlArchivo(certificado.archivo_url)" target="_blank" rel="noopener noreferrer">Ver archivo</a>
            </li>
          </ul>
        </section>
      </template>
    </main>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

* { box-sizing: border-box; }

.pagina-admin {
  min-height: 100vh;
  background: #EDEDED;
  color: #4A4A4E;
  font-family: 'Poppins', sans-serif;
}

.barra-navegacion {
  width: 100%;
  background: #FFFFFF;
  box-shadow: 0 3px 12px rgba(74, 74, 78, 0.10);
}

.barra-navegacion nav {
  width: 100%;
  min-height: 65px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 5px;
  flex-wrap: wrap;
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
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.nav-link:hover,
.nav-link.router-link-exact-active {
  color: #EB3135;
}

.nav-link:hover { background: #EDEDED; }
.nav-link.router-link-exact-active { font-weight: 700; }

.nav-link::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: 0;
  width: 0;
  height: 4px;
  background: #EB3135;
  border-radius: 5px 5px 0 0;
  transform: translateX(-50%);
  transition: width 0.3s ease;
}

.nav-link:hover::after,
.nav-link.router-link-exact-active::after { width: 65%; }

.admin-perfil {
  min-height: calc(100vh - 65px);
  padding: 35px 20px 60px;
  background: #EDEDED;
  color: #4A4A4E;
}

.titulo-pagina {
  max-width: 950px;
  margin: 0 auto 30px;
  text-align: center;
}

.titulo-pagina span {
  color: #EB3135;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 3px;
}

.titulo-pagina h1 {
  margin: 12px 0;
  font-size: clamp(26px, 4vw, 38px);
  font-weight: 800;
}

.titulo-pagina p,
.panel p { line-height: 1.5; }

.panel {
  max-width: 950px;
  margin: 0 auto 22px;
  padding: 25px;
  border-radius: 16px;
  background: #FFFFFF;
  box-shadow: 0 5px 18px rgba(74, 74, 78, 0.08);
}

.panel h2 { margin: 0 0 18px; font-size: 22px; }
.panel h3 { margin-top: 25px; font-size: 16px; }

label {
  display: block;
  margin: 15px 0 7px;
  font-size: 14px;
  font-weight: 700;
}

input,
select,
textarea {
  width: 100%;
  min-height: 43px;
  padding: 11px;
  border: 1px solid #BDC0C3;
  border-radius: 8px;
  background: #FFFFFF;
  color: #4A4A4E;
  font: inherit;
}

textarea { resize: vertical; }

input:focus,
select:focus,
textarea:focus {
  outline: none;
  border-color: #EB3135;
}

button {
  padding: 12px 17px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-family: inherit;
  font-weight: 700;
  transition: 0.2s;
}

button:hover { transform: translateY(-1px); }

.principal {
  width: 100%;
  margin-top: 18px;
  background: #EB3135;
  color: #FFFFFF;
}

.principal:hover { background: #C92429; }
.secundario { background: #4A4A4E; color: #FFFFFF; }

.datos-empleado {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-top: 18px;
}

.barcode {
  display: flex;
  justify-content: center;
  overflow-x: auto;
  margin: 20px 0;
  padding: 15px;
  border: 1px solid #EDEDED;
  border-radius: 10px;
}

.aviso,
.error,
.estado {
  max-width: 950px;
  margin: 15px auto;
  padding: 13px;
  border-radius: 8px;
  background: #FFFFFF;
}

.aviso { border-left: 4px solid #27834B; }

.error {
  border-left: 4px solid #EB3135;
  color: #B21F24;
  white-space: pre-wrap;
}

.archivos { padding: 0; list-style: none; }

.archivos li {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 13px 0;
  border-bottom: 1px solid #EDEDED;
}

.archivos a { color: #EB3135; font-weight: 700; }
.vacacion-item p { margin-bottom: 0; }

@media (max-width: 900px) {
  .nav-link { padding: 0 15px; }
}

@media (max-width: 600px) {
  .barra-navegacion nav {
    justify-content: flex-start;
    padding: 0 10px;
  }

  .nav-link {
    min-height: 55px;
    padding: 0 10px;
    font-size: 12px;
  }

  .admin-perfil { padding: 25px 12px 40px; }
  .panel { padding: 18px; }

  .archivos li {
    align-items: flex-start;
    flex-direction: column;
  }
}
</style>
