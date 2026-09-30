<template>
  <div class="categoria-page">
    <!-- Encabezado de la Categoría -->
    <header class="header-section">
      <router-link to="/colchones" class="back-link">
        <span class="arrow">←</span> Volver a Categorías
      </router-link>
      <h1 class="brand-title">LÍNEA ESPUMA</h1>
      <p class="section-subtitle">Frontera Living</p>
      <p class="description">
        Colchones de soporte ortopédico y alta densidad para una postura corporal perfectamente alineada durante el descanso.
      </p>
    </header>

    <!-- Grilla de Tarjetas de Productos -->
    <main class="grid-container">
      <article 
        v-for="producto in productos" 
        :key="producto.id" 
        class="producto-card"
        :class="{ 'card-proximamente': !producto.disponible }"
      >
        <!-- LÍNEA DE ACENTO SUPERIOR -->
        <div class="card-accent-line"></div>

        <div class="card-content">
          <div class="card-header">
            <span class="tech-badge">{{ producto.densidad }}</span>
            <span class="medida-tag">{{ producto.medidas }}</span>
          </div>

          <div class="card-body">
            <h2 class="producto-title">{{ producto.nombre }}</h2>
            <p class="producto-desc">{{ producto.descripcion }}</p>

            <div class="specs-box">
              <div 
                v-for="(spec, index) in producto.especificaciones" 
                :key="index" 
                class="spec-item"
              >
                <span class="spec-bullet">•</span>
                <span>{{ spec }}</span>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button 
              class="btn-3d" 
              :disabled="!producto.disponible || !producto.modelo3d"
              @click="abrirVisor3D(producto)"
            >
              <span class="icon-3d">🧊</span>
              <span>{{ producto.disponible ? 'Ver Estructura 3D' : 'Próximamente' }}</span>
            </button>
          </div>
        </div>
      </article>
    </main>

    <!-- Ventana Modal para el Visor 3D -->
    <Teleport to="body">
      <div v-if="modalAbierto" class="modal-overlay" @click.self="cerrarVisor3D">
        <div class="modal-container">
          <header class="modal-header">
            <div>
              <h3>{{ productoSeleccionado?.nombre }}</h3>
              <p>{{ productoSeleccionado?.densidad }} - {{ productoSeleccionado?.medidas }}</p>
            </div>
            <button class="btn-cerrar" @click="cerrarVisor3D">&times;</button>
          </header>

          <div class="modal-body-3d">
            <!-- Componente oficial <model-viewer> -->
            <model-viewer
              ref="visor3d"
              v-if="productoSeleccionado?.modelo3d"
              :src="productoSeleccionado.modelo3d"
              :alt="'Modelo 3D de ' + productoSeleccionado.nombre"
              auto-rotate
              camera-controls
              ar
              shadow-intensity="1"
              class="visor-3d-element"
            >
              <template #poster>
                <div class="cargando-3d">Cargando modelo 3D...</div>
              </template>
            </model-viewer>

            <!-- Controles flotantes en pantalla (Flechas y Zoom) -->
            <div class="controles-3d-overlay">
              <div class="grupo-controles">
                <button class="btn-ctrl" title="Rotar Arriba" @click="rotar('arriba')">▲</button>
                <div class="fila-horizontal">
                  <button class="btn-ctrl" title="Rotar Izquierda" @click="rotar('izquierda')">◀</button>
                  <button class="btn-ctrl" title="Restablecer vista" @click="resetVista()">↺</button>
                  <button class="btn-ctrl" title="Rotar Derecha" @click="rotar('derecha')">▶</button>
                </div>
                <button class="btn-ctrl" title="Rotar Abajo" @click="rotar('abajo')">▼</button>
              </div>

              <div class="grupo-zoom">
                <button class="btn-ctrl btn-zoom" title="Acercar (Zoom +)" @click="zoom('in')">+</button>
                <button class="btn-ctrl btn-zoom" title="Alejar (Zoom -)" @click="zoom('out')">−</button>
              </div>
            </div>
          </div>

          <footer class="modal-footer">
            <p class="instrucciones-3d">💡 Mové con el mouse/dedo o usá los botones para controlar la cámara</p>
          </footer>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

onMounted(() => {
  if (!customElements.get('model-viewer')) {
    const script = document.createElement('script')
    script.type = 'module'
    script.src = 'https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js'
    document.head.appendChild(script)
  }
})

const modalAbierto = ref(false)
const productoSeleccionado = ref(null)
const visor3d = ref(null)

const rotar = (direccion) => {
  if (!visor3d.value) return
  const orbit = visor3d.value.getCameraOrbit()
  let { theta, phi, radius } = orbit
  const pasodeRotacion = 0.4

  if (direccion === 'izquierda') theta -= pasodeRotacion
  if (direccion === 'derecha') theta += pasodeRotacion
  if (direccion === 'arriba') phi = Math.max(0.1, phi - pasodeRotacion)
  if (direccion === 'abajo') phi = Math.min(Math.PI - 0.1, phi + pasodeRotacion)

  visor3d.value.cameraOrbit = `${theta}rad ${phi}rad ${radius}m`
}

const zoom = (tipo) => {
  if (!visor3d.value) return
  const orbit = visor3d.value.getCameraOrbit()
  let { theta, phi, radius } = orbit
  const pasoZoom = 0.85

  if (tipo === 'in') radius = Math.max(0.5, radius * (2 - pasoZoom - 0.3))
  if (tipo === 'out') radius = radius * pasoZoom

  visor3d.value.cameraOrbit = `${theta}rad ${phi}rad ${radius}m`
}

const resetVista = () => {
  if (!visor3d.value) return
  visor3d.value.cameraOrbit = '0deg 75deg 105%'
}

const productos = ref([
  {
    id: 'comfort',
    nombre: 'COLCHÓN COMFORT',
    densidad: 'Densidad 30 kg/m³',
    medidas: '140 x 190 cm',
    descripcion: 'Diseñado con espuma de densidad media-alta para un descanso equilibrado y confort duradero.',
    especificaciones: [
      'Estructura monolítica de Espuma de Poliuretano',
      'Soporta hasta 100 kg por plaza',
      'Funda en Tela Sábana respirable'
    ],
    modelo3d: '/modelo/Colchones/espuma/COMFORT.glb',
    disponible: true
  },
  {
    id: 'mark',
    nombre: 'COLCHÓN MARK',
    densidad: 'Densidad 35 kg/m³',
    medidas: '140 x 190 cm',
    descripcion: 'Soporte firme e indeformable ideal para el cuidado de la postura lumbar y uso intensivo.',
    especificaciones: [
      'Poliuretano de celda abierta de alta resiliencia',
      'Soporta hasta 120 kg por plaza',
      'Matelasseado doble en Tela de Punto'
    ],
    modelo3d: '/modelo/Colchones/espuma/MARK.glb',
    disponible: true
  },
  {
    id: 'relax',
    nombre: 'COLCHÓN RELAX',
    densidad: 'Densidad 30 kg/m³ + Pillow',
    medidas: '160 x 200 cm',
    descripcion: 'Combinación óptima entre firmeza y una capa superior extra mullida para un descanso reparador.',
    especificaciones: [
      'Euro Pillow acolchado con espuma soft',
      'Soporta hasta 110 kg por plaza',
      'Tratamiento Hipoalergénico y Antiácaros'
    ],
    modelo3d: '/modelo/Colchones/espuma/RELAX.glb',
    disponible: true
  },
  {
    id: 'select',
    nombre: 'COLCHÓN SELECT',
    densidad: 'Densidad Extra Firme',
    medidas: '160 x 200 cm',
    descripcion: 'Selección premium de espumas ortopédicas pensadas para corregir la alineación de la columna.',
    especificaciones: [
      'Núcleo indeformable de máxima densidad',
      'Soporta hasta 130 kg por plaza',
      'Tejido con tratamiento suave al tacto'
    ],
    modelo3d: '/modelo/Colchones/espuma/SELECT.glb',
    disponible: true
  },
  {
    id: 'siena',
    nombre: 'COLCHÓN SIENA',
    densidad: 'Densidad 28 kg/m³',
    medidas: '80 x 190 cm',
    descripcion: 'Equilibrio ideal de comodidad y firmeza adaptado a uso diario continuo de 1 plaza.',
    especificaciones: [
      'Estructura de alta durabilidad',
      'Soporta hasta 90 kg por plaza',
      'Diseño ergonómico y adaptable'
    ],
    modelo3d: '/modelo/Colchones/espuma/SIENA.glb',
    disponible: true
  },
  {
    id: 'tropical',
    nombre: 'COLCHÓN TROPICAL',
    densidad: 'Densidad 25 kg/m³',
    medidas: '80 x 190 cm',
    descripcion: 'Liviano, fresco y versátil. Una excelente alternativa para dormitorios juveniles o de visitas.',
    especificaciones: [
      'Estructura de espuma liviana de alta rotación',
      'Soporta hasta 80 kg por plaza',
      'Funda en tela de algodón fresca'
    ],
    modelo3d: '/modelo/Colchones/espuma/TROPICAL.glb',
    disponible: true
  },
  {
    id: 'virtus',
    nombre: 'COLCHÓN VIRTUS',
    densidad: 'Densidad 35 kg/m³ + D. Pillow',
    medidas: '180 x 200 cm',
    descripcion: 'Modelo insignia de espumas de alta densidad con doble manta de confort superior King Size.',
    especificaciones: [
      'Doble Euro Pillow Top con espumas viscoelásticas',
      'Soporta hasta 140 kg por plaza',
      'Tela Jacquard de alta gama'
    ],
    modelo3d: '/modelo/Colchones/espuma/VIRTUS.glb',
    disponible: true
  },
  {
    id: 'modelo-8',
    nombre: 'PRÓXIMO MODELO',
    densidad: 'LÍNEA PREMIUM',
    medidas: 'A definir',
    descripcion: 'Estamos diseñando un nuevo producto de la Línea Espuma para sumar a nuestro catálogo.',
    especificaciones: [
      'Nuevas tecnologías en espumas',
      'Alineación postural avanzada',
      'Próximamente disponible'
    ],
    modelo3d: null,
    disponible: false
  }
])

const abrirVisor3D = (producto) => {
  if (!producto.disponible || !producto.modelo3d) return
  productoSeleccionado.value = producto
  modalAbierto.value = true
}

const cerrarVisor3D = () => {
  modalAbierto.value = false
  productoSeleccionado.value = null
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

@font-face {
  font-family: 'NuberNext Black';
  src: local('NuberNext Black'), local('NuberNext-Black');
  font-weight: 900;
  font-style: normal;
}

.categoria-page {
  min-height: 100vh;
  background-color: #EDEDED;
  font-family: 'Poppins', sans-serif;
  color: #4A4A4E;
  padding: 40px 20px 80px;
  box-sizing: border-box;
}

.header-section {
  max-width: 1100px;
  margin: 0 auto 40px;
  text-align: center;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #4A4A4E;
  text-decoration: none;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 20px;
  transition: color 0.2s;
}

.back-link:hover {
  color: #EB3135;
}

.brand-title {
  font-family: 'NuberNext Black', 'Poppins', sans-serif;
  font-size: clamp(2.2rem, 4.5vw, 3.2rem);
  color: #EB3135;
  text-transform: uppercase;
  margin-bottom: 4px;
}

.section-subtitle {
  font-family: 'Arial', sans-serif;
  font-size: 1rem;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #4A4A4E;
  margin-bottom: 12px;
}

.description {
  font-size: 0.95rem;
  color: #4A4A4E;
  max-width: 650px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Grilla */
.grid-container {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
}

/* TARJETA MEJORADA */
.producto-card {
  background-color: #ffffff;
  border-radius: 16px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  display: flex;
  flex-direction: column;
}

.card-accent-line {
  height: 4px;
  width: 100%;
  background-color: #EDEDED;
  transition: background-color 0.3s ease;
}

.producto-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 16px 32px rgba(235, 49, 53, 0.12);
}

.producto-card:hover .card-accent-line {
  background-color: #EB3135;
}

.card-content {
  padding: 24px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.card-proximamente {
  opacity: 0.75;
  background-color: #fafafa;
}

.card-proximamente:hover {
  transform: none;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
}

.card-proximamente:hover .card-accent-line {
  background-color: #EDEDED;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.tech-badge {
  background-color: #EB3135;
  color: #ffffff;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 6px 12px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.medida-tag {
  font-size: 0.75rem;
  color: #4A4A4E;
  background-color: #f0f0f0;
  padding: 5px 10px;
  border-radius: 6px;
  font-weight: 600;
}

.producto-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #4A4A4E;
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: -0.2px;
}

.producto-desc {
  font-size: 0.88rem;
  line-height: 1.5;
  color: #66666a;
  margin-bottom: 18px;
}

.specs-box {
  background-color: #f8f9fa;
  border-left: 3px solid #EB3135;
  padding: 12px 14px;
  border-radius: 0 8px 8px 0;
  margin-bottom: 22px;
}

.spec-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  font-size: 0.8rem;
  color: #4A4A4E;
  margin-bottom: 6px;
}

.spec-item:last-child {
  margin-bottom: 0;
}

.spec-bullet {
  color: #EB3135;
  font-weight: bold;
}

.card-footer {
  border-top: 1px solid #f0f0f0;
  padding-top: 16px;
}

/* BOTÓN DESTACADO */
.btn-3d {
  width: 100%;
  background-color: #4A4A4E;
  border: none;
  color: #ffffff;
  padding: 12px;
  border-radius: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 0.85rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.25s ease;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

.btn-3d:hover:not(:disabled) {
  background-color: #EB3135;
  box-shadow: 0 6px 16px rgba(235, 49, 53, 0.3);
  transform: translateY(-1px);
}

.btn-3d:disabled {
  background-color: #e0e0e0;
  color: #9e9e9e;
  cursor: not-allowed;
  box-shadow: none;
}

/* Modal del Visor 3D */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.65);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  padding: 20px;
  box-sizing: border-box;
}

.modal-container {
  background-color: #ffffff;
  width: 100%;
  max-width: 800px;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
}

.modal-header {
  padding: 20px 25px;
  background-color: #f8f8f8;
  border-bottom: 1px solid #EDEDED;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.2rem;
  color: #4A4A4E;
  text-transform: uppercase;
}

.modal-header p {
  margin: 4px 0 0;
  font-size: 0.85rem;
  color: #EB3135;
  font-weight: 600;
}

.btn-cerrar {
  background: none;
  border: none;
  font-size: 2rem;
  color: #4A4A4E;
  cursor: pointer;
  line-height: 1;
  transition: color 0.2s;
}

.btn-cerrar:hover {
  color: #EB3135;
}

.modal-body-3d {
  width: 100%;
  height: 450px;
  background-color: #f3f3f3;
  position: relative;
}

.visor-3d-element {
  width: 100%;
  height: 100%;
}

.controles-3d-overlay {
  position: absolute;
  bottom: 15px;
  right: 15px;
  display: flex;
  gap: 15px;
  align-items: flex-end;
  pointer-events: none;
}

.grupo-controles,
.grupo-zoom {
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(6px);
  padding: 6px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  pointer-events: auto;
}

.fila-horizontal {
  display: flex;
  gap: 2px;
}

.btn-ctrl {
  background-color: #ffffff;
  border: 1px solid #BDC0C3;
  color: #4A4A4E;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: bold;
  cursor: pointer;
  margin: 2px;
  transition: all 0.2s ease;
  user-select: none;
}

.btn-ctrl:hover {
  background-color: #EB3135;
  color: #ffffff;
  border-color: #EB3135;
}

.btn-zoom {
  font-size: 1.2rem;
  width: 36px;
  height: 36px;
}

.cargando-3d {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  font-weight: 600;
  color: #888;
}

.modal-footer {
  padding: 12px 20px;
  background-color: #fafafa;
  border-top: 1px solid #EDEDED;
  text-align: center;
}

.instrucciones-3d {
  font-size: 0.8rem;
  color: #777;
  margin: 0;
}

@media (max-width: 640px) {
  .categoria-page {
    padding: 25px 15px;
  }
  .modal-body-3d {
    height: 320px;
  }
  .controles-3d-overlay {
    bottom: 10px;
    right: 10px;
    gap: 8px;
  }
}
</style>