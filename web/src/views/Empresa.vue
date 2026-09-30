<template>
  <main class="empresa">
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-decoration"></div>

      <div class="hero-content">
        <span>FRONTERA LIVING</span>
        <h1>Empresa</h1>
        <p>Productos para disfrutar la vida.</p>
      </div>
     
    </section>

    <!-- Intro Section -->j
    <section class="intro">
      <div class="intro-top">
        <span>QUIÉNES SOMOS</span>
        <div></div>        
      </div>

      <div class="intro-content">
        <h2>
          Diseñamos productos para
          <em>disfrutar</em> cada momento.
        </h2>

        <p>
          Creamos productos pensados para formar parte de los hogares,
          acompañando los momentos cotidianos y convirtiendo cada espacio
          en un lugar para disfrutar.
        </p>
      </div>
    </section>

    <!-- Historia Section -->
    <section class="historia">
      <div class="historia-header">
        <div>
          <h2>Historia</h2>
        </div>

        <p>
          Más de cuatro décadas creando productos para el hogar.
        </p>
      </div>

      <div class="historia-body">
        <div class="historia-text">
          <p class="destacado">
            Contamos con más de <strong>45 años</strong> de experiencia
            y trayectoria en el mercado.
          </p>

          <p>
            Desde el comienzo de nuestras actividades, nos especializamos
            en producir juegos de living de alta calidad.
          </p>

          <p>
            A partir del año 2010 incorporamos nuevas líneas de productos,
            como colchones y sommiers, bajo las marcas Natural Soft y Piuma.
          </p>

          <p>
            Actualmente contamos con una planta industrial equipada con
            maquinarias de última tecnología, centros de mecanizados para
            cortes de tela y madera y producción de poliéster.
          </p>

          <p>
            Nuestra fábrica está ubicada en el Parque Industrial de
            San Francisco, dentro de un predio de 27.300 m² con más de
            8.000 m² cubiertos.
          </p>

          <p>
            Estamos en constante búsqueda de las mejores materias primas
            y prácticas para mejorar nuestras actividades y ofrecer
            productos de calidad, confort y diseño.
          </p>
        </div>

        <div class="historia-visual">
          <div class="visual-circle"></div>

          <div class="years">
            <strong>45</strong>
            <span>AÑOS</span>
            <p>de experiencia</p>
          </div>

          <div class="visual-small">1980s — 2026</div>
        </div>
      </div>
    </section>

    <!-- Misión / Visión Section -->
    <section class="mision">
      <div class="mision-content">
        <h2>Misión</h2>
        <p>
          Creamos bienestar y espacios confortables a través de una
          organización comprometida. Fabricamos productos de diseño
          y calidad priorizando las necesidades y expectativas de
          nuestros usuarios.
        </p>
      </div>

      <div class="vision-content">
        <h2>Visión</h2>
        <p>
          Estar presentes en cada hogar de nuestro país. Buscamos ser
          líderes en el mercado nacional por nuestra calidad e innovación,
          siendo reconocidos por nuestra trayectoria y el diseño de
          nuestros productos.
        </p>
      </div>
    </section>

    <!-- Valores Section -->
    <section class="valores">
      <div class="valores-header">
        <div>
          <p>NUESTROS PRINCIPIOS</p>
          <h2>Valores</h2>
        </div>
      </div>

      <div class="valores-list">
        <div class="valor">
          <h3>Compromiso</h3>
        </div>

        <div class="valor">
          <h3>Responsabilidad</h3>
        </div>

        <div class="valor">
          <h3>Respeto</h3>
        </div>

        <div class="valor">
          <h3>Honestidad</h3>
        </div>

        <div class="valor">
          <h3>Confianza</h3>
        </div>

        <div class="valor">
          <h3>Trabajo en equipo</h3>
        </div>
      </div>
    </section>

    <!-- Grupo Humano Section -->
    <section class="grupo">
      <div class="grupo-shape"></div>

      <div class="grupo-content">
        <h2>Grupo<br><em>humano</em></h2>

        <p>
          Contamos con un excelente grupo humano, al que capacitamos
          permanentemente para brindar un trato cálido y personalizado.
        </p>

        <p>
          Personas comprometidas en satisfacer al cliente y hacer de
          cada producto una experiencia de calidad.
        </p>
      </div>
    </section>

    <!-- Cartera de Productos Section -->
    <section class="productos">
      <div class="productos-header">
        <div>
          <h2>Cartera de productos</h2>
        </div>

        <p>
          Una amplia cartera de productos desarrollados con diferentes
          tecnologías y marcas.
        </p>
      </div>

      <div class="productos-list">
        <article>
          <div class="producto-number"></div>
          <h3>Diseño</h3>
          <p>
            Modelos pensados para combinar estética, funcionalidad
            y estilo.
          </p>
        </article>

        <article>
          <div class="producto-number"></div>
          <h3>Calidad</h3>
          <p>
            Materiales y procesos seleccionados para crear productos
            duraderos y confortables.
          </p>
        </article>

        <article>
          <div class="producto-number"></div>
          <h3>Innovación</h3>
          <p>
            Incorporamos nuevas tecnologías para mejorar constantemente
            nuestros productos.
          </p>
        </article>

        <article>
          <div class="producto-number"></div>
          <h3>Detalle</h3>
          <p>
            Cuidamos cada elemento para lograr piezas únicas que
            acompañen la vida cotidiana.
          </p>
        </article>
      </div>

      <!-- Carrusel de fotos -->
      <div class="carrusel-container" style="position: relative; margin: 60px auto 0; max-width: 900px; width: 100%; border-radius: 24px; overflow: hidden; background: transparent; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <div class="carrusel-wrapper" style="width: 100%; overflow: hidden;">
          <div 
            class="carrusel-track" 
            :style="{ transform: `translateX(-${slideActual * 100}%)`, display: 'flex', transition: 'transform 0.5s ease-in-out', width: '100%' }"
          >
            <div 
              v-for="(foto, index) in fotos" 
              :key="index" 
              class="carrusel-slide"
              style="min-width: 100%; height: 500px; display: flex; align-items: center; justify-content: center; background: transparent;"
            >
              <img 
                :src="foto.url" 
                :alt="foto.alt || 'Foto producto'" 
                style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain !important; margin: auto; display: block;"
              />
            </div>
          </div>
        </div>

        <!-- Botones de navegación -->
        <button class="carrusel-btn prev" @click="slideAnterior" aria-label="Anterior">&#10094;</button>
        <button class="carrusel-btn next" @click="siguienteSlide" aria-label="Siguiente">&#10095;</button>

        <!-- Indicadores / Puntos -->
        <div class="carrusel-puntos">
          <span 
            v-for="(foto, index) in fotos" 
            :key="index" 
            :class="['punto', { activo: index === slideActual }]"
            @click="irASlide(index)"
          ></span>
        </div>
      </div>
    </section>

    <!-- Final Section -->
    <section class="final">
      <div class="final-circle"></div>

      <div class="final-content">
        <span>FRONTERA LIVING</span>
        <h2>
          Productos para
          <em>disfrutar</em>
          la vida.
        </h2>
      </div>
    </section>
  </main>
</template>

<script>
export default {
  name: 'EmpresaView',
  data() {
    return {
      slideActual: 0,
      intervalo: null,
      // Reemplazá estas URLs por tus imágenes locales o enlaces
      fotos: [
        { url: new URL('@/assets/carrusel/1carru.png', import.meta.url).href, alt: 'Producto 1' },
        { url: new URL('@/assets/carrusel/2carru.png', import.meta.url).href, alt: 'Producto 2' },
        { url: new URL('@/assets/carrusel/3carru.png', import.meta.url).href, alt: 'Producto 3' },
        { url: new URL('@/assets/carrusel/4carru.png', import.meta.url).href, alt: 'Producto 4' },
        { url: new URL('@/assets/carrusel/5carru.png', import.meta.url).href, alt: 'Producto 5' },
        { url: new URL('@/assets/carrusel/6carru.png', import.meta.url).href, alt: 'Producto 1' },
        { url: new URL('@/assets/carrusel/7carru.png', import.meta.url).href, alt: 'Producto 2' },
        { url: new URL('@/assets/carrusel/8carru.png', import.meta.url).href, alt: 'Producto 3' },
        { url: new URL('@/assets/carrusel/9carru.png', import.meta.url).href, alt: 'Producto 4' },
        { url: new URL('@/assets/carrusel/10carru.png', import.meta.url).href, alt: 'Producto 5' },
        { url: new URL('@/assets/carrusel/11carru.png', import.meta.url).href, alt: 'Producto 1' },
        { url: new URL('@/assets/carrusel/12carru.png', import.meta.url).href, alt: 'Producto 2' },
        { url: new URL('@/assets/carrusel/13carru.png', import.meta.url).href, alt: 'Producto 3' },
        { url: new URL('@/assets/carrusel/14carru.png', import.meta.url).href, alt: 'Producto 4' },
        { url: new URL('@/assets/carrusel/15carru.png', import.meta.url).href, alt: 'Producto 5' },
        { url: new URL('@/assets/carrusel/16carru.png', import.meta.url).href, alt: 'Producto 1' },
        { url: new URL('@/assets/carrusel/17carru.png', import.meta.url).href, alt: 'Producto 2' },
      ]
    };
  },
  mounted() {
    this.iniciarAutoPlay();
  },
  beforeUnmount() {
    this.detenerAutoPlay();
  },
  methods: {
    siguienteSlide() {
      this.slideActual = (this.slideActual + 1) % this.fotos.length;
    },
    slideAnterior() {
      this.slideActual = (this.slideActual - 1 + this.fotos.length) % this.fotos.length;
    },
    irASlide(index) {
      this.slideActual = index;
    },
    iniciarAutoPlay() {
      this.intervalo = setInterval(() => {
        this.siguienteSlide();
      }, 4000);
    },
    detenerAutoPlay() {
      if (this.intervalo) clearInterval(this.intervalo);
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

.empresa {
  width: 100%;
  overflow: hidden;
  background: #EDEDED;
  color: #4A4A4E;
  font-family: 'Poppins', sans-serif;
}

/* Hero Section */
.hero {
  min-height: calc(100vh - 80px);
  position: relative;
  display: flex;
  align-items: center;
  padding: 100px 9%;
  overflow: hidden;
  background: #f8f8f8;
}

.hero-content {
  position: relative;
  z-index: 2;
}

.hero-content span {
  color: #EB3135;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 4px;
}

.hero h1 {
  margin: 20px 0 15px;
  font-size: clamp(70px, 13vw, 170px);
  line-height: 0.85;
  font-weight: 800;
  letter-spacing: -4px;
  text-transform: uppercase;
  color: #4A4A4E;
}

.hero p {
  margin-left: 5px;
  font-size: clamp(18px, 2.2vw, 30px);
  font-weight: 300;
  color: #666;
}

.hero-decoration {
  position: absolute;
  right: -140px;
  top: 50%;
  width: 620px;
  height: 620px;
  transform: translateY(-50%);
  border-radius: 50%;
  background: #EB3135;
}

.hero-decoration::before {
  content: "";
  position: absolute;
  inset: 70px;
  border-radius: 50%;
  background: #f8f8f8;
}

.hero-decoration::after {
  content: "";
  position: absolute;
  width: 180px;
  height: 180px;
  left: 40px;
  bottom: 80px;
  border-radius: 50%;
  background: #BDC0C3;
}

.hero-number {
  position: absolute;
  right: 9%;
  bottom: 50px;
  z-index: 3;
  color: #4A4A4E;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 4px;
}

/* Intro Section */
.intro {
  padding: 130px 9%;
  background: #ffffff;
}

.intro-top {
  display: flex;
  align-items: center;
  gap: 30px;
  color: #EB3135;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 4px;
}

.intro-top div {
  width: 100px;
  height: 2px;
  background: #BDC0C3;
}

.intro-content {
  display: grid;
  grid-template-columns: 1.5fr 0.7fr;
  gap: 80px;
  align-items: end;
  margin-top: 50px;
}

.intro h2 {
  margin: 0;
  font-size: clamp(40px, 5.5vw, 75px);
  line-height: 1.05;
  letter-spacing: -2px;
  font-weight: 700;
  color: #4A4A4E;
}

.intro h2 em {
  color: #EB3135;
  font-style: normal;
}

.intro p {
  margin: 0;
  font-size: 16px;
  line-height: 1.8;
  font-weight: 300;
  color: #666;
}

/* Historia Section */
.historia {
  padding: 130px 9%;
  background: #EDEDED;
}

.historia-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  gap: 50px;
  margin-bottom: 80px;
}

.historia-header span,
.mision span,
.vision-content span,
.valores-header > span,
.grupo-content > span,
.productos-header span,
.final-content span {
  color: #EB3135;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 4px;
}

.historia-header h2 {
  margin: 15px 0 0;
  font-size: clamp(50px, 7.5vw, 100px);
  line-height: 0.9;
  letter-spacing: -3px;
  text-transform: uppercase;
  font-weight: 800;
  color: #4A4A4E;
}

.historia-header > p {
  max-width: 330px;
  margin: 0;
  font-size: 17px;
  line-height: 1.6;
  color: #666;
}

.historia-body {
  display: grid;
  grid-template-columns: 1fr 0.8fr;
  gap: 80px;
  align-items: center;
}

.historia-text p {
  max-width: 700px;
  margin: 0 0 20px;
  font-size: 16px;
  line-height: 1.75;
  font-weight: 300;
}

.historia-text .destacado {
  margin-bottom: 35px;
  font-size: 24px;
  line-height: 1.4;
  font-weight: 400;
  color: #4A4A4E;
}

.historia-text strong {
  color: #EB3135;
  font-weight: 700;
}

.historia-visual {
  min-height: 480px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #BDC0C3;
  border-radius: 48% 52% 55% 45% / 50% 45% 55% 50%;
}

.visual-circle {
  position: absolute;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: #EB3135;
}

.years {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #ffffff;
}

.years strong {
  font-size: clamp(110px, 13vw, 170px);
  line-height: 0.8;
  letter-spacing: -6px;
  font-weight: 800;
}

.years span {
  margin-top: 20px;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 5px;
}

.years p {
  margin-top: 10px;
  font-size: 14px;
  font-weight: 300;
}

.visual-small {
  position: absolute;
  right: 35px;
  bottom: 35px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2px;
  color: #4A4A4E;
}

/* Misión & Visión */
.mision {
  display: grid;
  grid-template-columns: 1fr 1fr;
}

.mision-content,
.vision-content {
  min-height: 550px;
  padding: 100px 10%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.mision-content {
  background: #EB3135;
  color: #ffffff;
  border-radius: 0 100px 0 0;
}

.vision-content {
  background: #4A4A4E;
  color: #ffffff;
  border-radius: 100px 0 0 0;
}

.mision-content span,
.vision-content span {
  color: #ffffff;
}

.mision h2,
.vision-content h2 {
  margin: 20px 0;
  font-size: clamp(50px, 6.5vw, 90px);
  line-height: 0.9;
  letter-spacing: -3px;
  text-transform: uppercase;
  font-weight: 800;
  color: #ffffff;
}

.mision p,
.vision-content p {
  max-width: 520px;
  margin: 0;
  font-size: 17px;
  line-height: 1.8;
  font-weight: 300;
  color: #EDEDED;
}

/* Valores Section */
.valores {
  padding: 130px 9%;
  background: #f8f8f8;
}

.valores-header {
  display: flex;
  gap: 50px;
  align-items: flex-start;
  margin-bottom: 70px;
}

.valores-header p {
  margin: 0 0 10px;
  color: #EB3135;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 4px;
}

.valores-header h2 {
  margin: 0;
  font-size: clamp(50px, 7vw, 100px);
  line-height: 0.85;
  letter-spacing: -3px;
  text-transform: uppercase;
  font-weight: 800;
}

.valores-list {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.valor {
  min-height: 160px;
  padding: 30px 35px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid #BDC0C3;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.valor:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}

.valor > span {
  color: #BDC0C3;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 3px;
}

.valor h3 {
  margin: 0;
  font-size: 24px;
  font-weight: 700;
  text-transform: uppercase;
  color: #4A4A4E;
}

.valor:nth-child(2),
.valor:nth-child(5) {
  background: #EB3135;
  border-color: #EB3135;
  color: #ffffff;
}

.valor:nth-child(2) h3,
.valor:nth-child(5) h3 {
  color: #ffffff;
}

.valor:nth-child(2) > span,
.valor:nth-child(5) > span {
  color: rgba(255,255,255,0.7);
}

/* Grupo Section */
.grupo {
  min-height: 650px;
  position: relative;
  display: flex;
  align-items: center;
  padding: 100px 9%;
  overflow: hidden;
  background: #4A4A4E;
  color: #ffffff;
}

.grupo-shape {
  position: absolute;
  right: -180px;
  width: 600px;
  height: 600px;
  border-radius: 50%;
  background: #BDC0C3;
}

.grupo-shape::before {
  content: "";
  position: absolute;
  inset: 100px;
  border-radius: 50%;
  background: #EB3135;
}

.grupo-content {
  position: relative;
  z-index: 2;
  max-width: 750px;
}

.grupo-content h2 {
  margin: 25px 0;
  font-size: clamp(60px, 9vw, 130px);
  line-height: 0.8;
  letter-spacing: -4px;
  text-transform: uppercase;
  font-weight: 800;
  color: #ffffff;
}

.grupo-content h2 em {
  color: #EB3135;
  font-style: normal;
}

.grupo-content p {
  max-width: 550px;
  margin: 0 0 15px;
  font-size: 17px;
  line-height: 1.8;
  font-weight: 300;
  color: #EDEDED;
}

/* Productos Section */
.productos {
  padding: 130px 9%;
  background: #ffffff;
}

.productos-header {
  display: grid;
  grid-template-columns: 1.3fr 0.7fr;
  gap: 80px;
  align-items: flex-end;
  margin-bottom: 70px;
}

.productos-header h2 {
  margin: 20px 0 0;
  max-width: 800px;
  font-size: clamp(45px, 6vw, 90px);
  line-height: 0.9;
  letter-spacing: -3px;
  text-transform: uppercase;
  font-weight: 800;
  color: #4A4A4E;
}

.productos-header > p {
  margin: 0;
  font-size: 17px;
  line-height: 1.7;
  color: #666;
  font-weight: 300;
}

.productos-list {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.productos-list article {
  min-height: 320px;
  padding: 40px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  overflow: hidden;
  border-radius: 24px;
  background: #f8f8f8;
  border: 1px solid #EDEDED;
}

.productos-list article:nth-child(2) {
  background: #BDC0C3;
  border-color: #BDC0C3;
}

.productos-list article:nth-child(3) {
  background: #4A4A4E;
  color: #ffffff;
  border-color: #4A4A4E;
}

.productos-list article:nth-child(4) {
  background: #EB3135;
  color: #ffffff;
  border-color: #EB3135;
}

.producto-number {
  position: absolute;
  top: 35px;
  right: 40px;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 3px;
  opacity: 0.6;
}

.productos-list h3 {
  margin: 0 0 10px;
  font-size: 32px;
  font-weight: 700;
  text-transform: uppercase;
}

.productos-list p {
  max-width: 450px;
  margin: 0;
  font-size: 15px;
  line-height: 1.7;
  font-weight: 300;
}

/* Carrusel de Productos */
.carrusel-container {
  position: relative;
  margin-top: 60px;
  width: 100%;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.carrusel-wrapper {
  width: 100%;
  overflow: hidden;
}

.carrusel-track {
  display: flex;
  transition: transform 0.5s ease-in-out;
  width: 100%;
}

.carrusel-slide {
  min-width: 100%;
  height: 480px;
}

.carrusel-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.carrusel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.85);
  color: #4A4A4E;
  border: none;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.3s ease, color 0.3s ease;
  z-index: 10;
}

.carrusel-btn:hover {
  background: #EB3135;
  color: #ffffff;
}

.carrusel-btn.prev {
  left: 20px;
}

.carrusel-btn.next {
  right: 20px;
}

.carrusel-puntos {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
  z-index: 10;
}

.punto {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.6);
  cursor: pointer;
  transition: background 0.3s ease, transform 0.3s ease;
}

.punto.activo {
  background: #EB3135;
  transform: scale(1.2);
}

/* Final Section */
.final {
  min-height: 550px;
  position: relative;
  display: flex;
  align-items: center;
  padding: 100px 9%;
  overflow: hidden;
  background: #EB3135;
  color: #ffffff;
}

.final-circle {
  position: absolute;
  width: 600px;
  height: 600px;
  right: -200px;
  top: -100px;
  border-radius: 50%;
  background: #f8f8f8;
}

.final-circle::after {
  content: "";
  position: absolute;
  inset: 100px;
  border-radius: 50%;
  background: #4A4A4E;
}

.final-content {
  position: relative;
  z-index: 2;
}

.final-content span {
  color: #ffffff;
}

.final h2 {
  max-width: 1000px;
  margin: 25px 0 0;
  font-size: clamp(50px, 7.5vw, 115px);
  line-height: 0.9;
  letter-spacing: -4px;
  text-transform: uppercase;
  font-weight: 800;
  color: #ffffff;
}

.final h2 em {
  font-style: normal;
  color: #4A4A4E;
}

/* Responsive */
@media (max-width: 900px) {
  .intro-content,
  .historia-body,
  .mision,
  .productos-header {
    grid-template-columns: 1fr;
  }

  .hero-decoration {
    width: 450px;
    height: 450px;
    right: -180px;
  }

  .historia-header {
    align-items: flex-start;
    flex-direction: column;
  }

  .historia-visual {
    min-height: 400px;
  }

  .valores-list,
  .productos-list {
    grid-template-columns: 1fr;
  }

  .grupo-shape {
    opacity: 0.35;
  }
}

@media (max-width: 600px) {
  .hero,
  .intro,
  .historia,
  .valores,
  .grupo,
  .productos,
  .final {
    padding-left: 6%;
    padding-right: 6%;
  }

  .hero h1 {
    font-size: 55px;
    letter-spacing: -2px;
  }

  .hero-decoration {
    width: 300px;
    height: 300px;
    right: -160px;
  }

  .hero-decoration::before {
    inset: 40px;
  }

  .intro,
  .historia,
  .valores,
  .productos {
    padding-top: 80px;
    padding-bottom: 80px;
  }

  .intro-content {
    gap: 30px;
    margin-top: 35px;
  }

  .historia-body {
    gap: 50px;
  }

  .historia-visual {
    min-height: 320px;
  }

  .visual-circle {
    width: 220px;
    height: 220px;
  }

  .mision-content,
  .vision-content {
    min-height: 400px;
    padding: 60px 6%;
  }

  .mision-content {
    border-radius: 0 50px 0 0;
  }

  .vision-content {
    border-radius: 50px 0 0 0;
  }

  .valores-header {
    gap: 20px;
    margin-bottom: 40px;
  }

  .valor {
    min-height: 140px;
  }

  .grupo-shape {
    width: 350px;
    height: 350px;
    right: -200px;
  }
  /* Carrusel de Productos - Ajuste de proporción */
.carrusel-container {
  position: relative;
  margin: 60px auto 0;
  max-width: 900px;
  width: 100%;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  background-color: #f0f0f0;
}

.carrusel-wrapper {
  width: 100%;
  overflow: hidden;
}

.carrusel-track {
  display: flex;
  transition: transform 0.5s ease-in-out;
  width: 100%;
}

.carrusel-slide {
  min-width: 100%;
  height: clamp(350px, 50vh, 550px);
  display: flex;
  align-items: center;
  justify-content: center;
}

.carrusel-slide img {
  width: 100%;
  height: 100%;
  object-fit: contain !important;
  display: block;
}

  .final {
    min-height: 450px;
  }

  .final-circle {
    width: 380px;
    height: 380px;
    right: -200px;
  }

  .final-circle::after {
    inset: 60px;
  }
}
</style>