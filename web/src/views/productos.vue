<template>
  <div class="productos-page">
    <!-- Encabezado con identidad de marca -->
    <header class="header-section">
      <h1 class="brand-title">FRONTERA LIVING</h1>
      <p class="section-subtitle">Catálogo de Productos</p>
      <p class="description">
        Seleccioná una línea para explorar nuestros productos y experimentar los modelos 3D interactivos.
      </p>
    </header>

    <!-- Grilla / Selector de Líneas de Productos -->
    <section class="split-container">
      <!-- 1. SECCIÓN COLCHONES (DISPONIBLE) -->
      <router-link to="/colchones" class="card-linea card-colchones">
        <div class="card-header">
          <span class="badge badge-activo">Disponible</span>
          <span class="badge-3d">Visor 3D 360°</span>
        </div>

        <div class="card-body">
          <span class="numero-linea">01</span>
          <h2 class="titulo-linea">LÍNEA COLCHONES</h2>
          <p class="texto-linea">
            Tecnología en Espuma de Alta Densidad, Espuma Soft y Resortes Individuales para un descanso superior.
          </p>
        </div>

        <div class="card-footer">
          <span class="btn-linea">Ver Colchones</span>
          <span class="flecha">→</span>
        </div>
      </router-link>

      <!-- 2. SECCIÓN LIVING (PRÓXIMAMENTE) -->
      <router-link to="/living" class="card-linea card-living disabled-card">
        <div class="card-header">
          <span class="badge badge-proximamente">Próximamente</span>
        </div>

        <div class="card-body">
          <span class="numero-linea">02</span>
          <h2 class="titulo-linea">LÍNEA LIVING</h2>
          <p class="texto-linea">
            Sillones, esquineros y amoblameintos vanguardistas diseñados para transformar tu espacio.
          </p>
        </div>

        <div class="card-footer">
          <span class="btn-linea muted">En Desarrollo</span>
          <span class="candado">🔒</span>
        </div>
      </router-link>
    </section>
  </div>
</template>

<script setup>
// Enrutamiento nativo con Vue Router
</script>

<style scoped>
/* IMPORTACIÓN DE FUENTE AUXILIAR POPOSTERIOR AL MANUAL DE MARCA */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

/* TIPOGRAFÍA PRIMARIA - MANUAL DE MARCA */
@font-face {
  font-family: 'NuberNext Black';
  src: local('NuberNext Black'), local('NuberNext-Black');
  font-weight: 900;
  font-style: normal;
}

/* PALETA CROMÁTICA INSTITUCIONAL:
   #EB3135 -> Rojo Institucional
   #4A4A4E -> Gris Oscuro
   #BDC0C3 -> Gris Medio
   #EDEDED -> Gris Claro (Fondo)
*/

.productos-page {
  min-height: 100vh;
  background-color: #EDEDED; /* Gris Claro Institucional */
  font-family: 'Poppins', sans-serif; /* Tipografía Auxiliar */
  color: #4A4A4E;
  padding: 50px 20px 80px;
  box-sizing: border-box;
}

/* ENCABEZADO */
.header-section {
  max-width: 800px;
  margin: 0 auto 40px;
  text-align: center;
}

.brand-title {
  font-family: 'NuberNext Black', 'Poppins', sans-serif;
  font-size: clamp(2rem, 4vw, 3rem);
  color: #EB3135; /* Rojo Institucional */
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 5px;
}

.section-subtitle {
  font-family: 'Arial', sans-serif; /* Tipografía Secundaria */
  font-size: 1.1rem;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #4A4A4E;
  font-weight: 400;
  margin-bottom: 15px;
}

.description {
  font-size: 0.95rem;
  color: #4A4A4E;
  line-height: 1.6;
}

/* GRID PRINCIPAL */
.split-container {
  max-width: 1100px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 30px;
}

/* TARJETAS DE LÍNEAS DE PRODUCTOS */
.card-linea {
  background-color: #ffffff;
  border-radius: 12px;
  border: 2px solid #BDC0C3; /* Gris Medio Institucional */
  padding: 35px 30px;
  text-decoration: none;
  color: #4A4A4E;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 380px;
  box-sizing: border-box;
  transition: all 0.3s ease;
  position: relative;
}

/* HOVER Y ESTADOS DE TARJETA */
.card-colchones:hover {
  border-color: #EB3135; /* Cambio a Rojo en Hover */
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(235, 49, 53, 0.15);
}

.disabled-card {
  opacity: 0.7;
  background-color: #f9f9f9;
  cursor: not-allowed;
}

/* BADGES E INSIGNIAS */
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.badge {
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  padding: 6px 12px;
  border-radius: 4px;
  letter-spacing: 0.5px;
}

.badge-activo {
  background-color: #EB3135;
  color: #ffffff;
}

.badge-proximamente {
  background-color: #BDC0C3;
  color: #4A4A4E;
}

.badge-3d {
  font-size: 0.75rem;
  font-weight: 600;
  color: #4A4A4E;
  background-color: #EDEDED;
  padding: 6px 10px;
  border-radius: 4px;
}

/* CUERPO DE LA TARJETA */
.numero-linea {
  font-family: 'Poppins', sans-serif;
  font-size: 2.5rem;
  font-weight: 800;
  color: #BDC0C3;
  display: block;
  margin-top: 15px;
  line-height: 1;
}

.titulo-linea {
  font-family: 'Poppins', sans-serif;
  font-size: 1.5rem;
  font-weight: 700;
  color: #4A4A4E;
  margin: 10px 0;
  text-transform: uppercase;
}

.texto-linea {
  font-size: 0.9rem;
  color: #4A4A4E;
  line-height: 1.5;
  margin-bottom: 20px;
}

/* FOOTER Y BOTONES */
.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 1px solid #EDEDED;
  padding-top: 20px;
}

.btn-linea {
  font-weight: 700;
  font-size: 0.95rem;
  color: #4A4A4E;
  text-transform: uppercase;
  transition: color 0.3s;
}

.card-colchones:hover .btn-linea {
  color: #EB3135;
}

.btn-linea.muted {
  color: #BDC0C3;
}

.flecha {
  font-size: 1.2rem;
  font-weight: 700;
  color: #EB3135;
  transition: transform 0.3s ease;
}

.card-colchones:hover .flecha {
  transform: translateX(6px);
}

.candado {
  font-size: 1rem;
}

/* RESPONSIVE */
@media (max-width: 640px) {
  .productos-page {
    padding: 30px 15px;
  }
  
  .card-linea {
    min-height: 320px;
    padding: 25px 20px;
  }
}
</style>