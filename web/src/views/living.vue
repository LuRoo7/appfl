<template>
  <div class="colchones-page">
    <!-- Encabezado de la Sección -->
    <header class="header-section">
      <router-link to="/productos" class="back-link">
        <span class="arrow">←</span> Volver a Categorías
      </router-link>
      <h1 class="brand-title">LÍNEA COLCHONES</h1>
      <p class="section-subtitle">Frontera Living</p>
      <p class="description">
        Sistemas de descanso diseñados con tecnologías de soporte postural adaptadas a cada necesidad.
      </p>

      <!-- Filtro de Categorías -->
      <nav class="filter-nav">
        <button 
          v-for="cat in categorias" 
          :key="cat.id"
          :class="['filter-btn', { active: categoriaSeleccionada === cat.id }]"
          @click="categoriaSeleccionada = cat.id"
        >
          {{ cat.nombre }}
        </button>
      </nav>
    </header>

    <!-- Grilla de Tarjetas de Categorías de Colchones -->
    <main class="grid-container">
      <article 
        v-for="item in categoriasFiltradas" 
        :key="item.id" 
        class="colchon-card"
      >
        <!-- Badge de Tipo -->
        <div class="card-badge-container">
          <span class="tech-badge">{{ item.badge }}</span>
          <span class="firmness-tag">Firmeza: {{ item.firmeza }}</span>
        </div>

        <!-- Contenido Principal -->
        <div class="card-body">
          <span class="card-number">{{ item.numero }}</span>
          <h2 class="card-title">{{ item.nombre }}</h2>
          <p class="card-desc">{{ item.descripcion }}</p>

          <!-- Especificaciones Térmicas / Técnicas -->
          <div class="specs-box">
            <div class="spec-item" v-for="(spec, i) in item.especificaciones" :key="i">
              <span class="spec-bullet">•</span>
              <span>{{ spec }}</span>
            </div>
          </div>
        </div>

        <!-- Acciones / CTA -->
        <div class="card-footer">
          <button class="btn-3d" @click="abrirVisor3D(item.id)">
            <span>Ver Estructura 3D</span>
            <span class="icon-3d">🧊</span>
          </button>
          <button class="btn-cotizar" @click="cotizar(item.nombre)">
            Cotizar
          </button>
        </div>
      </article>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const categoriaSeleccionada = ref('todas');

const categorias = [
  { id: 'todas', nombre: 'Todas las Líneas' },
  { id: 'espuma', nombre: 'Espuma Alta Densidad' },
  { id: 'espuma-soft', nombre: 'Espuma Soft' },
  { id: 'resortes', nombre: 'Resortes Individuales' }
];

const productos = [
  {
    id: 'espuma',
    numero: '01',
    nombre: 'ESPUMA ALTA DENSIDAD',
    badge: 'Soporte Postural HR',
    firmeza: 'Firme / Alta',
    descripcion: 'Núcleo denso diseñado para brindar un soporte ortopédico óptimo, alineando la columna vertebral durante el descanso.',
    especificaciones: [
      'Densidad superior a 30 kg/m³',
      'Estructura de celda abierta auto-ventilable',
      'Tela de Tejer de Punto antiácaros',
      'Soporta hasta 130 kg por plaza'
    ]
  },
  {
    id: 'espuma-soft',
    numero: '02',
    nombre: 'ESPUMA SOFT',
    badge: 'Confort Progresivo',
    firmeza: 'Mullida / Media',
    descripcion: 'Capa anatómica de alta flexibilidad que elimina los puntos de presión articular, adaptándose al contorno corporal.',
    especificaciones: [
      'Tecnología Mousse de alta resiliencia',
      'Sensación de ingravidez en puntos de contacto',
      'Acolchado en mantas de fibra siliconada',
      'Hipoalergénico y termorregulable'
    ]
  },
  {
    id: 'resortes',
    numero: '03',
    nombre: 'RESORTES INDIVIDUALES',
    badge: 'Pocket System',
    firmeza: 'Media / Anatómica',
    descripcion: 'Resortes enfundados individualmente que absorben los movimientos de manera independiente sin transmitir vibración.',
    especificaciones: [
      'Estructura de resortes Pocket enfundados',
      'Independencia de movimiento total',
      'Marco perimetral reforzado en Foam',
      'Máxima circulación de aire interna'
    ]
  }
];

const categoriasFiltradas = computed(() => {
  if (categoriaSeleccionada.value === 'todas') {
    return productos;
  }
  return productos.filter(p => p.id === categoriaSeleccionada.value);
});

const abrirVisor3D = (id) => {
  console.log(`Cargando modelo 3D interactivo para: ${id}`);
};

const cotizar = (nombre) => {
  console.log(`Cotizando producto: ${nombre}`);
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

@font-face {
  font-family: 'NuberNext Black';
  src: local('NuberNext Black'), local('NuberNext-Black');
  font-weight: 900;
  font-style: normal;
}

/* PALETA CROMÁTICA INSTITUCIONAL MANUAL DE MARCA
   Rojo: #EB3135
   Gris Oscuro: #4A4A4E
   Gris Medio: #BDC0C3
   Gris Claro: #EDEDED
*/

.colchones-page {
  min-height: 100vh;
  background-color: #EDEDED;
  font-family: 'Poppins', sans-serif;
  color: #4A4A4E;
  padding: 40px 20px 80px;
  box-sizing: border-box;
}

/* ENCABEZADO */
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
  margin: 0 auto 30px;
  line-height: 1.6;
}

/* BOTONES DE FILTRO */
.filter-nav {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 10px;
}

.filter-btn {
  background: #ffffff;
  border: 1px solid #BDC0C3;
  color: #4A4A4E;
  padding: 8px 18px;
  border-radius: 20px;
  font-family: 'Poppins', sans-serif;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.25s ease;
}

.filter-btn:hover {
  border-color: #EB3135;
  color: #EB3135;
}

.filter-btn.active {
  background-color: #EB3135;
  border-color: #EB3135;
  color: #ffffff;
}

/* GRILLA Y TARJETAS */
.grid-container {
  max-width: 1100px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 30px;
}

.colchon-card {
  background-color: #ffffff;
  border: 2px solid #BDC0C3;
  border-radius: 12px;
  padding: 30px 25px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: all 0.3s ease;
}

.colchon-card:hover {
  border-color: #EB3135;
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(235, 49, 53, 0.12);
}

.card-badge-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.tech-badge {
  background-color: #EB3135;
  color: #ffffff;
  font-size: 0.75rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 4px;
  text-transform: uppercase;
}

.firmness-tag {
  font-size: 0.75rem;
  color: #4A4A4E;
  background-color: #EDEDED;
  padding: 4px 10px;
  border-radius: 4px;
  font-weight: 500;
}

.card-number {
  font-size: 2.2rem;
  font-weight: 800;
  color: #BDC0C3;
  line-height: 1;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #4A4A4E;
  margin: 8px 0;
  text-transform: uppercase;
}

.card-desc {
  font-size: 0.88rem;
  line-height: 1.5;
  color: #4A4A4E;
  margin-bottom: 20px;
}

/* ESPECIFICACIONES */
.specs-box {
  background-color: #f9f9f9;
  border-left: 3px solid #EB3135;
  padding: 12px 15px;
  border-radius: 0 6px 6px 0;
  margin-bottom: 25px;
}

.spec-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  font-size: 0.82rem;
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

/* FOOTER Y BOTONES */
.card-footer {
  display: flex;
  gap: 12px;
  border-top: 1px solid #EDEDED;
  padding-top: 20px;
}

.btn-3d {
  flex: 1;
  background-color: #EDEDED;
  border: 1px solid #BDC0C3;
  color: #4A4A4E;
  padding: 10px;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s;
}

.btn-3d:hover {
  background-color: #BDC0C3;
  color: #ffffff;
}

.btn-cotizar {
  background-color: #EB3135;
  border: none;
  color: #ffffff;
  padding: 10px 18px;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-cotizar:hover {
  background-color: #c92428;
}

@media (max-width: 640px) {
  .colchones-page {
    padding: 25px 15px;
  }
  
  .card-footer {
    flex-direction: column;
  }
}
</style>