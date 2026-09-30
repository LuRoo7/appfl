<template>
  <div class="categoria-page">
    <!-- Encabezado de la Categoría -->
    <header class="header-section">
      <router-link to="/colchones" class="back-link">
        <span class="arrow">←</span> Volver a Categorías
      </router-link>
      <h1 class="brand-title">LÍNEA ESPUMA SOFT</h1>
      <p class="section-subtitle">Frontera Living</p>
      <p class="description">
        Espumas de alta resiliencia y textura mullida, diseñadas para adaptarse anatómicamente al cuerpo y eliminar puntos de presión.
      </p>
    </header>

    <!-- Grilla de Tarjetas de Productos de Espuma Soft -->
    <main class="grid-container">
      
      <!-- Producto 1 -->
      <article class="producto-card">
        <div class="card-header">
          <span class="tech-badge">Confort Adaptativo</span>
          <span class="medida-tag">140 x 190 cm</span>
        </div>

        <div class="card-body">
          <h2 class="producto-title">COLCHÓN SOFT COMFORT 2 PLAZAS</h2>
          <p class="producto-desc">
            Brinda una acogida suave y envolvente. Su núcleo flexible distribuye el peso sin ejercer presión en hombros y caderas.
          </p>

          <div class="specs-box">
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Espuma Soft de alta resiliencia (HR)</span>
            </div>
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Sensación de relajación muscular inmediata</span>
            </div>
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Acolchado en mantas siliconadas termorregulables</span>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <button class="btn-3d" @click="abrirVisor3D('soft-comfort-2p')">
            <span class="icon-3d">🧊</span>
            <span>Ver Estructura 3D</span>
          </button>
        </div>
      </article>

      <!-- Producto 2 -->
      <article class="producto-card">
        <div class="card-header">
          <span class="tech-badge">Efecto Visco-Soft</span>
          <span class="medida-tag">160 x 200 cm</span>
        </div>

        <div class="card-body">
          <h2 class="producto-title">COLCHÓN SOFT ANATÓMICO QUEEN</h2>
          <p class="producto-desc">
            Diseñado con capas de densidad progresiva que garantizan una postura correcta con un tacto superior ultrasuave.
          </p>

          <div class="specs-box">
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Combinación de base firme y capa superior Soft</span>
            </div>
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Alineación natural de la columna vertebral</span>
            </div>
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Funda en Tela de Punto matelaseada de lujo</span>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <button class="btn-3d" @click="abrirVisor3D('soft-anatomico-queen')">
            <span class="icon-3d">🧊</span>
            <span>Ver Estructura 3D</span>
          </button>
        </div>
      </article>

      <!-- Producto 3 -->
      <article class="producto-card">
        <div class="card-header">
          <span class="tech-badge">Doble Pillow Soft</span>
          <span class="medida-tag">200 x 200 cm</span>
        </div>

        <div class="card-body">
          <h2 class="producto-title">COLCHÓN SOFT LUXURY KING</h2>
          <p class="producto-desc">
            Máxima expresión de confort. Incorpora una manta Euro Pillow de espuma mullida para una experiencia de descanso de alta gama.
          </p>

          <div class="specs-box">
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Euro Pillow acolchado en espuma soft de gran espesor</span>
            </div>
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Absorción de movimientos entre personas</span>
            </div>
            <div class="spec-item">
              <span class="spec-bullet">•</span>
              <span>Tratamiento hipoalergénico y antiácaros integral</span>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <button class="btn-3d" @click="abrirVisor3D('soft-luxury-king')">
            <span class="icon-3d">🧊</span>
            <span>Ver Estructura 3D</span>
          </button>
        </div>
      </article>

    </main>
  </div>
</template>

<script setup>
const abrirVisor3D = (id) => {
  console.log(`Cargando modelo 3D para: ${id}`)
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

.grid-container {
  max-width: 1150px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 30px;
}

.producto-card {
  background-color: #ffffff;
  border: 2px solid #BDC0C3;
  border-radius: 12px;
  padding: 25px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: all 0.3s ease;
}

.producto-card:hover {
  border-color: #EB3135;
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(235, 49, 53, 0.12);
}

.card-header {
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

.medida-tag {
  font-size: 0.75rem;
  color: #4A4A4E;
  background-color: #EDEDED;
  padding: 4px 10px;
  border-radius: 4px;
  font-weight: 600;
}

.producto-title {
  font-size: 1.15rem;
  font-weight: 700;
  color: #4A4A4E;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.producto-desc {
  font-size: 0.88rem;
  line-height: 1.5;
  color: #4A4A4E;
  margin-bottom: 15px;
}

.specs-box {
  background-color: #f9f9f9;
  border-left: 3px solid #EB3135;
  padding: 10px 12px;
  border-radius: 0 6px 6px 0;
  margin-bottom: 20px;
}

.spec-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  font-size: 0.8rem;
  color: #4A4A4E;
  margin-bottom: 4px;
}

.spec-item:last-child {
  margin-bottom: 0;
}

.spec-bullet {
  color: #EB3135;
  font-weight: bold;
}

.card-footer {
  border-top: 1px solid #EDEDED;
  padding-top: 15px;
}

.btn-3d {
  width: 100%;
  background-color: #EDEDED;
  border: 1px solid #BDC0C3;
  color: #4A4A4E;
  padding: 10px;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif;
  font-size: 0.82rem;
  font-weight: 700;
  text-transform: uppercase;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.25s ease;
}

.btn-3d:hover {
  background-color: #EB3135;
  border-color: #EB3135;
  color: #ffffff;
}

@media (max-width: 640px) {
  .categoria-page {
    padding: 25px 15px;
  }
}
</style>