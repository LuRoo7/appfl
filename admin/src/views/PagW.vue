
<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <div class="pagina-admin">
    <header class="encabezado">
      <div class="encabezado-contenido">
        <div class="marca">
          <span class="marca-frontera">FRONTERA</span>
          <span class="marca-living">LIVING</span>
        </div>

        <div class="encabezado-texto">
          <h1>Administración de la página web</h1>
          <p>Gestioná los productos que ven los clientes.</p>
        </div>
      </div>
    </header>

    <main class="contenido">
      <div class="titulo-seccion">
        <span class="etiqueta">PANEL DE CONTROL</span>
        <h2>Página web</h2>
        <p>
          Desde acá podés administrar los productos que se publican
          en la página web de Frontera Living.
        </p>
      </div>

      <section class="tarjetas">
        <article class="tarjeta tarjeta-productos">
          <div class="icono">▦</div>

          <span class="categoria">CATÁLOGO WEB</span>

          <h3>Productos</h3>

          <p>
            Agregá productos, modificá sus datos, cargá imágenes
            y modelos 3D, y elegí cuáles se muestran a los clientes.
          </p>

          <RouterLink to="/ProdWeb" class="boton">
            Administrar productos
            <span>→</span>
          </RouterLink>
        </article>

        <article class="tarjeta tarjeta-publicacion">
          <div class="icono">◎</div>

          <span class="categoria">PUBLICACIÓN</span>

          <h3>Visibilidad de productos</h3>

          <p>
            Los productos marcados como visibles en el administrador
            podrán aparecer en el catálogo de la página web.
          </p>

          <RouterLink to="/ProdWeb" class="boton boton-secundario">
            Gestionar publicaciones
            <span>→</span>
          </RouterLink>
        </article>
      </section>

      <section class="informacion">
        <div class="informacion-icono">i</div>

        <div>
          <h3>¿Cómo funciona?</h3>
          <p>
            Los productos se guardan en la base de datos compartida
            mediante el backend. Cuando modificás un producto desde
            la administración, la página web puede mostrar esos cambios
            al volver a consultar los productos publicados.
          </p>
        </div>
      </section>

      <div class="volver">
        <RouterLink to="/" class="enlace-volver">
          ← Volver al inicio de administración
        </RouterLink>
      </div>
    </main>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

:global(*) {
  box-sizing: border-box;
}

:global(html),
:global(body),
:global(#app) {
  margin: 0;
  min-height: 100%;
  width: 100%;
}

:global(body) {
  font-family: 'Poppins', sans-serif;
  background: #EDEDED;
}

.pagina-admin {
  min-height: 100vh;
  color: #4A4A4E;
  background: #EDEDED;
  font-family: 'Poppins', sans-serif;
}

.encabezado {
  width: 100%;
  background: #FFFFFF;
  border-bottom: 4px solid #EB3135;
  box-shadow: 0 3px 12px rgba(74, 74, 78, 0.08);
}

.encabezado-contenido {
  max-width: 1200px;
  min-height: 115px;
  margin: 0 auto;
  padding: 22px 35px;
  display: flex;
  align-items: center;
  gap: 30px;
}

.marca {
  display: flex;
  flex-direction: column;
  line-height: 1;
  border-right: 1px solid #D8D8D8;
  padding-right: 30px;
}

.marca-frontera {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: 1px;
  color: #EB3135;
}

.marca-living {
  margin-top: 5px;
  font-size: 15px;
  font-weight: 700;
  letter-spacing: 6px;
  color: #4A4A4E;
}

.encabezado-texto h1 {
  margin: 0;
  font-size: 23px;
  font-weight: 700;
}

.encabezado-texto p {
  margin: 7px 0 0;
  color: #77777C;
  font-size: 14px;
}

.contenido {
  max-width: 1150px;
  margin: 0 auto;
  padding: 55px 30px 70px;
}

.titulo-seccion {
  margin-bottom: 30px;
}

.etiqueta,
.categoria {
  color: #EB3135;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2px;
}

.titulo-seccion h2 {
  margin: 8px 0;
  font-size: 34px;
  font-weight: 700;
}

.titulo-seccion p {
  margin: 0;
  max-width: 650px;
  color: #77777C;
  font-size: 15px;
  line-height: 1.7;
}

.tarjetas {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 25px;
}

.tarjeta {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  min-height: 340px;
  padding: 30px;
  background: #FFFFFF;
  border: 1px solid #E1E1E1;
  border-radius: 16px;
  box-shadow: 0 5px 18px rgba(74, 74, 78, 0.06);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.tarjeta:hover {
  transform: translateY(-3px);
  box-shadow: 0 9px 24px rgba(74, 74, 78, 0.11);
}

.icono {
  width: 55px;
  height: 55px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
  border-radius: 12px;
  background: #FDEBEC;
  color: #EB3135;
  font-size: 30px;
  font-weight: 500;
}

.categoria {
  margin-bottom: 8px;
}

.tarjeta h3 {
  margin: 0 0 12px;
  font-size: 24px;
  font-weight: 700;
}

.tarjeta p {
  margin: 0 0 25px;
  color: #77777C;
  font-size: 14px;
  line-height: 1.8;
  flex: 1;
}

.boton {
  width: 100%;
  min-height: 48px;
  padding: 12px 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  border-radius: 8px;
  background: #EB3135;
  color: #FFFFFF;
  text-decoration: none;
  font-size: 13px;
  font-weight: 600;
  transition: background 0.2s ease;
}

.boton:hover {
  background: #C92328;
}

.boton span {
  font-size: 20px;
}

.boton-secundario {
  color: #EB3135;
  background: #FFFFFF;
  border: 1px solid #EB3135;
}

.boton-secundario:hover {
  color: #FFFFFF;
  background: #EB3135;
}

.informacion {
  display: flex;
  gap: 16px;
  align-items: flex-start;
  margin-top: 30px;
  padding: 24px;
  border: 1px solid #E0E0E0;
  border-radius: 12px;
  background: #FFFFFF;
}

.informacion-icono {
  flex-shrink: 0;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: #FDEBEC;
  color: #EB3135;
  font-weight: 700;
}

.informacion h3 {
  margin: 2px 0 8px;
  font-size: 16px;
}

.informacion p {
  margin: 0;
  color: #77777C;
  font-size: 13px;
  line-height: 1.8;
}

.volver {
  margin-top: 30px;
}

.enlace-volver {
  color: #4A4A4E;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
}

.enlace-volver:hover {
  color: #EB3135;
}

@media (max-width: 700px) {
  .encabezado-contenido {
    align-items: flex-start;
    flex-direction: column;
    gap: 18px;
    padding: 25px 20px;
  }

  .marca {
    border-right: none;
    border-bottom: 1px solid #D8D8D8;
    padding: 0 0 15px;
  }

  .encabezado-texto h1 {
    font-size: 20px;
  }

  .contenido {
    padding: 35px 18px 50px;
  }

  .titulo-seccion h2 {
    font-size: 29px;
  }

  .tarjetas {
    grid-template-columns: 1fr;
  }

  .tarjeta {
    min-height: 320px;
    padding: 24px;
  }
}
</style>
