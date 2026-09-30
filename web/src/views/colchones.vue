<template>
  <div class="colchones-page">

    <header class="header-section">
      <router-link to="/productos" class="back-link">
        <span class="arrow">←</span> Volver a Productos
      </router-link>
      <h1 class="brand-title">LÍNEA COLCHONES</h1>
      <p class="section-subtitle">Frontera Living</p>
      <p class="description">
        Seleccioná una tecnología de descanso para explorar sus modelos y visualizar su estructura en 3D.
      </p>
    </header>
    <main class="grid-container">
      
      <router-link to="/espuma" class="cat-card card-espuma">
        <div class="card-header">
          <span class="card-number">01</span>
          <span class="tech-badge">Soporte Firme</span>
        </div>

        <div class="card-body">
          <h2 class="card-title">ESPUMA</h2>
          <div class="firmness-tag">Firmeza: Alta / Ortopédica</div>
          <p class="card-desc">
            Núcleo denso diseñado para brindar estabilidad estructural y mantener la postura corporal alineada.
          </p>
          <ul class="clean-list">
            <li><span>•</span> Densidad superior a 30 kg/m³</li>
            <li><span>•</span> Estructura de celda abierta</li>
            <li><span>•</span> Tela de punto antiácaros</li>
          </ul>
        </div>

        <div class="card-footer">
          <span class="btn-text">Explorar Línea Espuma</span>
          <span class="arrow-icon">→</span>
        </div>
      </router-link>

      <router-link to="/espumasoft" class="cat-card card-espuma-soft">
        <div class="card-header">
          <span class="card-number">02</span>
          <span class="tech-badge badge-soft">Confort Adaptativo</span>
        </div>

        <div class="card-body">
          <h2 class="card-title">ESPUMA SOFT</h2>
          <div class="highlight-box">
            <span class="highlight-label">Sensación al descansar</span>
            <p class="highlight-text">Mullida & Anatómica sin puntos de presión</p>
          </div>
          <p class="card-desc">
            Capa flexible que se amolda suavemente al contorno del cuerpo eliminando tensiones musculares.
          </p>
          <div class="pills-container">
            <span class="spec-pill">Alta Resiliencia</span>
            <span class="spec-pill">Termorregulable</span>
          </div>
        </div>

        <div class="card-footer">
          <span class="btn-text">Explorar Línea Soft</span>
          <span class="arrow-icon">→</span>
        </div>
      </router-link>

      <router-link to="/resortes" class="cat-card card-resortes">
        <div class="card-header">
          <span class="card-number">03</span>
          <span class="tech-badge badge-resortes">Sustentación Activa</span>
        </div>

        <div class="card-body">
          <h2 class="card-title">RESORTES</h2>
          <p class="card-desc">
            Sistema de suspensión diseñado para la distribución óptima del peso y absorción del movimiento.
          </p>
          <div class="tech-table">
            <div class="table-row">
              <span class="row-label">Estructura</span>
              <span class="row-val">Metálica Reforzada</span>
            </div>
            <div class="table-row">
              <span class="row-label">Firmeza</span>
              <span class="row-val">Media / Anatómica</span>
            </div>
            <div class="table-row">
              <span class="row-label">Ventilación</span>
              <span class="row-val">Circulación Activa</span>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <span class="btn-text">Explorar Línea Resortes</span>
          <span class="arrow-icon">→</span>
        </div>
      </router-link>

    </main>
  </div>
</template>

<script setup>
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

@font-face {
  font-family: 'NuberNext Black';
  src: local('NuberNext Black'), local('NuberNext-Black');
  font-weight: 900;
  font-style: normal;
}

.colchones-page {
  min-height: 100vh;
  background-color: #EDEDED;
  font-family: 'Poppins', sans-serif;
  color: #4A4A4E;
  padding: 40px 20px 80px;
  box-sizing: border-box;
}

.header-section {
  max-width: 1100px;
  margin: 0 auto 50px;
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

.cat-card {
  background-color: #ffffff;
  border: 2px solid #BDC0C3;
  border-radius: 14px;
  padding: 30px 25px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  text-decoration: none;
  color: #4A4A4E;
  transition: all 0.3s ease;
}

.cat-card:hover {
  border-color: #EB3135;
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(235, 49, 53, 0.12);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.card-number {
  font-size: 2.2rem;
  font-weight: 800;
  color: #BDC0C3;
  line-height: 1;
}

.tech-badge {
  background-color: #EB3135;
  color: #ffffff;
  font-size: 0.75rem;
  font-weight: 700;
  padding: 5px 12px;
  border-radius: 4px;
  text-transform: uppercase;
}

.card-title {
  font-size: 1.35rem;
  font-weight: 700;
  color: #4A4A4E;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.card-desc {
  font-size: 0.88rem;
  line-height: 1.6;
  color: #4A4A4E;
  margin-bottom: 20px;
}

/* Tarjeta 1 */
.firmness-tag {
  font-size: 0.8rem;
  background-color: #EDEDED;
  color: #EB3135;
  font-weight: 700;
  padding: 6px 10px;
  border-radius: 4px;
  display: inline-block;
  margin-bottom: 12px;
}

.clean-list {
  list-style: none;
  padding: 0;
  margin: 0 0 20px 0;
}

.clean-list li {
  font-size: 0.82rem;
  margin-bottom: 6px;
}

.clean-list li span {
  color: #EB3135;
  font-weight: bold;
}

.highlight-box {
  background-color: rgba(235, 49, 53, 0.06);
  border-left: 3px solid #EB3135;
  padding: 10px 14px;
  border-radius: 0 8px 8px 0;
  margin-bottom: 15px;
}

.highlight-label {
  display: block;
  font-size: 0.72rem;
  text-transform: uppercase;
  color: #EB3135;
  font-weight: 700;
}

.highlight-text {
  font-size: 0.85rem;
  font-weight: 600;
  margin: 2px 0 0 0;
}

.pills-container {
  display: flex;
  gap: 6px;
  margin-bottom: 20px;
}

.spec-pill {
  font-size: 0.75rem;
  background-color: #EDEDED;
  padding: 5px 10px;
  border-radius: 12px;
}

.tech-table {
  background-color: #f9f9f9;
  border: 1px solid #EDEDED;
  border-radius: 8px;
  padding: 10px 14px;
  margin-bottom: 20px;
}

.table-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.8rem;
  padding: 5px 0;
  border-bottom: 1px dashed #BDC0C3;
}

.table-row:last-child {
  border-bottom: none;
}

.row-val {
  color: #EB3135;
  font-weight: 600;
}

.card-footer {
  border-top: 1px solid #EDEDED;
  padding-top: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.btn-text {
  font-weight: 700;
  font-size: 0.9rem;
  text-transform: uppercase;
  color: #4A4A4E;
  transition: color 0.2s;
}

.cat-card:hover .btn-text {
  color: #EB3135;
}

.arrow-icon {
  font-size: 1.2rem;
  color: #EB3135;
  transition: transform 0.3s ease;
}

.cat-card:hover .arrow-icon {
  transform: translateX(6px);
}
</style>