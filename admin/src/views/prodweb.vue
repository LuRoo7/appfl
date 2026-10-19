
<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const API = 'http://localhost/backend/'

const productos = ref([])
const cargando = ref(false)
const guardando = ref(false)
const mensaje = ref('')
const tipoMensaje = ref('')

const formulario = ref({
  id: null,
  nombre: '',
  categoria: '',
  descripcion: '',
  imagen_url: '',
  modelo_3d_url: '',
  visible: true
})

const archivoImagen = ref(null)
const modoEdicion = ref(false)

const categorias = [
  'Colchones',
  'Bases',
  'Sommier',
  'Almohadas',
  'Accesorios',
  'Otros'
]

function mostrarMensaje(texto, tipo = 'exito') {
  mensaje.value = texto
  tipoMensaje.value = tipo

  setTimeout(() => {
    mensaje.value = ''
  }, 4000)
}

function limpiarFormulario() {
  formulario.value = {
    id: null,
    nombre: '',
    categoria: '',
    descripcion: '',
    imagen_url: '',
    modelo_3d_url: '',
    visible: true
  }

  archivoImagen.value = null
  modoEdicion.value = false

  const inputArchivo = document.getElementById('imagen-producto')
  if (inputArchivo) inputArchivo.value = ''
}

async function listarProductos() {
  cargando.value = true

  try {
    const respuesta = await axios.get(
      `${API}productos_web_listar.php`
    )

    if (Array.isArray(respuesta.data)) {
      productos.value = respuesta.data
    } else if (Array.isArray(respuesta.data.productos)) {
      productos.value = respuesta.data.productos
    } else {
      productos.value = []
      mostrarMensaje('La respuesta del servidor no tiene el formato esperado.', 'error')
    }
  } catch (error) {
    console.error(error)
    mostrarMensaje('No se pudieron cargar los productos. Revisá el backend.', 'error')
  } finally {
    cargando.value = false
  }
}

function seleccionarImagen(evento) {
  const archivo = evento.target.files?.[0] || null

  if (!archivo) {
    archivoImagen.value = null
    return
  }

  if (!archivo.type.startsWith('image/')) {
    mostrarMensaje('Seleccioná un archivo de imagen válido.', 'error')
    evento.target.value = ''
    archivoImagen.value = null
    return
  }

  if (archivo.size > 5 * 1024 * 1024) {
    mostrarMensaje('La imagen no puede superar los 5 MB.', 'error')
    evento.target.value = ''
    archivoImagen.value = null
    return
  }

  archivoImagen.value = archivo
}

function editarProducto(producto) {
  formulario.value = {
    id: producto.id,
    nombre: producto.nombre || '',
    categoria: producto.categoria || '',
    descripcion: producto.descripcion || '',
    imagen_url: producto.imagen_url || '',
    modelo_3d_url: producto.modelo_3d_url || '',
    visible: producto.visible === true ||
      producto.visible === 1 ||
      producto.visible === '1'
  }

  archivoImagen.value = null
  modoEdicion.value = true

  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}

async function guardarProducto() {
  if (
    !formulario.value.nombre.trim() ||
    !formulario.value.categoria ||
    !formulario.value.descripcion.trim()
  ) {
    mostrarMensaje('Completá el nombre, la categoría y la descripción.', 'error')
    return
  }

  if (!modoEdicion.value && !archivoImagen.value) {
    mostrarMensaje('Seleccioná una imagen para el producto.', 'error')
    return
  }

  guardando.value = true

  try {
    const datos = new FormData()

    datos.append('nombre', formulario.value.nombre.trim())
    datos.append('categoria', formulario.value.categoria)
    datos.append('descripcion', formulario.value.descripcion.trim())
    datos.append('modelo_3d_url', formulario.value.modelo_3d_url.trim())
    datos.append('visible', formulario.value.visible ? '1' : '0')

    if (formulario.value.id !== null) {
      datos.append('id', String(formulario.value.id))
    }

    if (archivoImagen.value) {
      datos.append('imagen', archivoImagen.value)
    }

    const endpoint = modoEdicion.value
      ? 'productos_web_modificar.php'
      : 'productos_web_crear.php'

    const respuesta = await axios.post(
      `${API}${endpoint}`,
      datos
    )

    if (
      respuesta.data?.success === false ||
      respuesta.data?.status === 'error'
    ) {
      throw new Error(
        respuesta.data?.mensaje ||
        respuesta.data?.message ||
        'El servidor no pudo guardar el producto.'
      )
    }

    mostrarMensaje(
      modoEdicion.value
        ? 'Producto actualizado correctamente.'
        : 'Producto agregado correctamente.'
    )

    limpiarFormulario()
    await listarProductos()
  } catch (error) {
    console.error(error)

    mostrarMensaje(
      error.response?.data?.mensaje ||
      error.response?.data?.message ||
      error.message ||
      'No se pudo guardar el producto.',
      'error'
    )
  } finally {
    guardando.value = false
  }
}

async function eliminarProducto(producto) {
  const confirmar = window.confirm(
    `¿Querés eliminar el producto "${producto.nombre}"?`
  )

  if (!confirmar) return

  try {
    const respuesta = await axios.post(
      `${API}productos_web_eliminar.php`,
      { id: producto.id }
    )

    if (
      respuesta.data?.success === false ||
      respuesta.data?.status === 'error'
    ) {
      throw new Error(
        respuesta.data?.mensaje ||
        respuesta.data?.message ||
        'No se pudo eliminar el producto.'
      )
    }

    mostrarMensaje('Producto eliminado correctamente.')

    if (formulario.value.id === producto.id) {
      limpiarFormulario()
    }

    await listarProductos()
  } catch (error) {
    console.error(error)

    mostrarMensaje(
      error.response?.data?.mensaje ||
      error.response?.data?.message ||
      'No se pudo eliminar el producto.',
      'error'
    )
  }
}

onMounted(() => {
  listarProductos()
})
</script>

<template>
  <main class="prodweb">
    <header class="encabezado">
      <div>
        <span class="subtitulo">FRONTERA LIVING / ADMINISTRACIÓN</span>
        <h1>Productos de la web</h1>
        <p>Administrá los productos que se muestran en el catálogo para clientes.</p>
      </div>

      <button class="btn-actualizar" @click="listarProductos">
        ↻ Actualizar
      </button>
    </header>

    <div
      v-if="mensaje"
      class="mensaje"
      :class="tipoMensaje"
      role="status"
    >
      {{ mensaje }}
    </div>

    <section class="panel">
      <div class="panel-titulo">
        <div>
          <h2>{{ modoEdicion ? 'Editar producto' : 'Agregar producto' }}</h2>
          <p>Completá los datos del producto para el catálogo web.</p>
        </div>

        <span class="etiqueta">
          {{ modoEdicion ? 'Edición' : 'Nuevo producto' }}
        </span>
      </div>

      <form class="formulario" @submit.prevent="guardarProducto">
        <div class="campo">
          <label for="nombre">Nombre del producto *</label>
          <input
            id="nombre"
            v-model="formulario.nombre"
            type="text"
            maxlength="150"
            placeholder="Ej.: Colchón Frontera"
            required
          />
        </div>

        <div class="campo">
          <label for="categoria">Categoría *</label>
          <select
            id="categoria"
            v-model="formulario.categoria"
            required
          >
            <option value="" disabled>Seleccioná una categoría</option>
            <option
              v-for="categoria in categorias"
              :key="categoria"
              :value="categoria"
            >
              {{ categoria }}
            </option>
          </select>
        </div>

        <div class="campo campo-completo">
          <label for="descripcion">Descripción *</label>
          <textarea
            id="descripcion"
            v-model="formulario.descripcion"
            rows="4"
            placeholder="Escribí las características del producto..."
            required
          ></textarea>
        </div>

        <div class="campo campo-completo">
          <label for="imagen-producto">Imagen del producto *</label>
          <input
            id="imagen-producto"
            type="file"
            accept="image/*"
            @change="seleccionarImagen"
            :required="!modoEdicion"
          />
          <small>
            Formatos de imagen admitidos por el navegador. Máximo 5 MB.
            {{ modoEdicion ? 'Dejá el campo vacío para conservar la imagen actual.' : '' }}
          </small>

          <img
            v-if="archivoImagen"
            :src="URL.createObjectURL(archivoImagen)"
            class="vista-previa"
            alt="Vista previa de la nueva imagen"
          />

          <img
            v-else-if="formulario.imagen_url"
            :src="formulario.imagen_url.startsWith('http')
              ? formulario.imagen_url
              : API + formulario.imagen_url.replace(/^\/+/, '')"
            class="vista-previa"
            alt="Imagen actual del producto"
          />
        </div>

        <div class="campo campo-completo">
          <label for="modelo-3d">Enlace del modelo 3D (opcional)</label>
          <input
            id="modelo-3d"
            v-model="formulario.modelo_3d_url"
            type="url"
            placeholder="https://..."
          />
          <small>
            Si el producto tiene un modelo 3D alojado en una plataforma compatible,
            ingresá su enlace.
          </small>
        </div>

        <div class="campo campo-completo">
          <label class="opcion-visible">
            <input
              v-model="formulario.visible"
              type="checkbox"
            />
            Mostrar este producto en la página web
          </label>
        </div>

        <div class="acciones-formulario">
          <button
            class="btn-guardar"
            type="submit"
            :disabled="guardando"
          >
            {{ guardando
              ? 'Guardando...'
              : modoEdicion
                ? 'Guardar cambios'
                : 'Agregar producto' }}
          </button>

          <button
            v-if="modoEdicion"
            class="btn-cancelar"
            type="button"
            @click="limpiarFormulario"
          >
            Cancelar edición
          </button>
        </div>
      </form>
    </section>

    <section class="listado">
      <div class="listado-encabezado">
        <div>
          <h2>Catálogo de productos</h2>
          <p>Productos registrados para la página web.</p>
        </div>

        <span class="contador">{{ productos.length }} productos</span>
      </div>

      <div v-if="cargando" class="estado">
        Cargando productos...
      </div>

      <div v-else-if="productos.length === 0" class="estado">
        Todavía no hay productos registrados.
      </div>

      <div v-else class="productos-grid">
        <article
          v-for="producto in productos"
          :key="producto.id"
          class="producto-card"
        >
          <div class="producto-imagen">
            <img
              v-if="producto.imagen_url"
              :src="producto.imagen_url.startsWith('http')
                ? producto.imagen_url
                : API + producto.imagen_url.replace(/^\/+/, '')"
              :alt="producto.nombre"
            />

            <span v-else class="sin-imagen">Sin imagen</span>

            <span
              class="estado-producto"
              :class="producto.visible === true ||
                producto.visible === 1 ||
                producto.visible === '1'
                ? 'publicado'
                : 'oculto'"
            >
              {{
                producto.visible === true ||
                producto.visible === 1 ||
                producto.visible === '1'
                  ? 'Visible en web'
                  : 'Oculto'
              }}
            </span>
          </div>

          <div class="producto-contenido">
            <span class="producto-categoria">
              {{ producto.categoria || 'Sin categoría' }}
            </span>

            <h3>{{ producto.nombre }}</h3>

            <p class="producto-descripcion">
              {{ producto.descripcion }}
            </p>

            <span
              v-if="producto.modelo_3d_url"
              class="modelo-disponible"
            >
              Modelo 3D configurado
            </span>

            <div class="acciones-producto">
              <button
                class="btn-editar"
                type="button"
                @click="editarProducto(producto)"
              >
                Editar
              </button>

              <button
                class="btn-eliminar"
                type="button"
                @click="eliminarProducto(producto)"
              >
                Eliminar
              </button>
            </div>
          </div>
        </article>
      </div>
    </section>
  </main>
</template>

<style scoped>
* {
  box-sizing: border-box;
}

.prodweb {
  min-height: 100vh;
  padding: 36px;
  background: #ededed;
  color: #4a4a4e;
  font-family: Poppins, Arial, sans-serif;
}

.encabezado {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-bottom: 28px;
}

.subtitulo {
  color: #eb3135;
  font-size: 12px;
  font-weight: 800;
  letter-spacing: 1.5px;
}

.encabezado h1 {
  margin: 8px 0;
  color: #29292c;
  font-size: clamp(26px, 4vw, 36px);
}

.encabezado p,
.panel-titulo p,
.listado-encabezado p {
  margin: 0;
  color: #77777c;
  font-size: 14px;
}

button {
  font: inherit;
  cursor: pointer;
  transition: 0.2s ease;
}

.btn-actualizar,
.btn-guardar {
  padding: 12px 18px;
  border: none;
  border-radius: 8px;
  background: #eb3135;
  color: white;
  font-weight: 700;
}

.btn-actualizar:hover,
.btn-guardar:hover:not(:disabled) {
  background: #c92126;
}

button:disabled {
  cursor: not-allowed;
  opacity: 0.65;
}

.mensaje {
  margin-bottom: 20px;
  padding: 14px 16px;
  border-radius: 8px;
  font-size: 14px;
}

.mensaje.exito {
  background: #e2f4e7;
  color: #216738;
}

.mensaje.error {
  background: #fde7e7;
  color: #a91f25;
}

.panel,
.listado {
  margin-bottom: 28px;
  padding: 26px;
  border: 1px solid #e0e0e2;
  border-radius: 14px;
  background: white;
  box-shadow: 0 5px 18px #29292c0a;
}

.panel-titulo,
.listado-encabezado {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  margin-bottom: 24px;
}

.panel-titulo h2,
.listado-encabezado h2 {
  margin: 0 0 6px;
  color: #333337;
  font-size: 21px;
}

.etiqueta,
.contador {
  padding: 8px 12px;
  border-radius: 20px;
  background: #fce9e9;
  color: #c92329;
  font-size: 12px;
  font-weight: 700;
  white-space: nowrap;
}

.formulario {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;
}

.campo {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 0;
}

.campo-completo {
  grid-column: 1 / -1;
}

.campo label {
  color: #414146;
  font-size: 13px;
  font-weight: 700;
}

.campo input:not([type="checkbox"]),
.campo select,
.campo textarea {
  width: 100%;
  padding: 12px 13px;
  border: 1px solid #d9d9dd;
  border-radius: 8px;
  outline: none;
  background: white;
  color: #333337;
  font: inherit;
  font-size: 14px;
}

.campo input:focus,
.campo select:focus,
.campo textarea:focus {
  border-color: #eb3135;
  box-shadow: 0 0 0 3px #eb31351a;
}

.campo textarea {
  resize: vertical;
}

.campo small {
  color: #77777c;
  font-size: 12px;
  line-height: 1.5;
}

.vista-previa {
  display: block;
  width: 180px;
  max-width: 100%;
  max-height: 180px;
  margin-top: 8px;
  border-radius: 8px;
  object-fit: contain;
  background: #f5f5f5;
}

.opcion-visible {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
}

.opcion-visible input {
  accent-color: #eb3135;
}

.acciones-formulario {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  grid-column: 1 / -1;
  padding-top: 6px;
}

.btn-cancelar,
.btn-editar,
.btn-eliminar {
  padding: 10px 15px;
  border-radius: 7px;
  font-size: 13px;
  font-weight: 700;
}

.btn-cancelar {
  border: 1px solid #d4d4d8;
  background: white;
  color: #55555a;
}

.estado {
  padding: 35px 10px;
  color: #77777c;
  text-align: center;
}

.productos-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 20px;
}

.producto-card {
  overflow: hidden;
  border: 1px solid #e6e6e8;
  border-radius: 12px;
  background: white;
}

.producto-imagen {
  position: relative;
  display: flex;
  height: 210px;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f5f5f5;
}

.producto-imagen img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.sin-imagen {
  color: #88888d;
  font-size: 13px;
}

.estado-producto {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 6px 9px;
  border-radius: 20px;
  background: white;
  font-size: 10px;
  font-weight: 800;
}

.publicado {
  color: #23753c;
}

.oculto {
  color: #8a5a13;
}

.producto-contenido {
  padding: 17px;
}

.producto-categoria {
  color: #eb3135;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
}

.producto-contenido h3 {
  margin: 8px 0;
  color: #303034;
  font-size: 18px;
}

.producto-descripcion {
  display: -webkit-box;
  overflow: hidden;
  min-height: 42px;
  margin: 0 0 12px;
  color: #737378;
  font-size: 13px;
  line-height: 1.6;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
}

.modelo-disponible {
  display: inline-block;
  margin-bottom: 12px;
  color: #55555a;
  font-size: 11px;
}

.acciones-producto {
  display: flex;
  gap: 8px;
  margin-top: 15px;
}

.btn-editar {
  flex: 1;
  border: none;
  background: #4a4a4e;
  color: white;
}

.btn-editar:hover {
  background: #303034;
}

.btn-eliminar {
  flex: 1;
  border: 1px solid #f0c9cb;
  background: white;
  color: #d52b30;
}

.btn-eliminar:hover {
  background: #fff0f0;
}

@media (max-width: 1000px) {
  .productos-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 650px) {
  .prodweb {
    padding: 18px;
  }

  .encabezado {
    align-items: flex-start;
    flex-direction: column;
  }

  .panel,
  .listado {
    padding: 18px;
  }

  .formulario,
  .productos-grid {
    grid-template-columns: 1fr;
  }

  .panel-titulo,
  .listado-encabezado {
    align-items: flex-start;
    flex-direction: column;
  }
}
</style>
