<template>
  <div class="curriculum-container">
    <h2>Subir Currículum Vitae</h2>

    <div v-if="usuario">
      <p class="usuario-info">Sesión iniciada como: <strong>{{ usuario.email }}</strong></p>

      <form @submit.prevent="subirArchivo">
        <div class="form-group">
          <label for="archivo">Seleccioná tu archivo (PDF, JPG o PNG):</label>
          <input 
            type="file" 
            id="archivo" 
            @change="seleccionarArchivo" 
            accept=".pdf,.jpg,.jpeg,.png" 
            required 
          />
        </div>

        <!-- VISTA PREVIA DEL ARCHIVO -->
        <div v-if="vistaPrevia" class="preview-container">
          <h3>Vista Previa:</h3>

          <!-- Si es Imagen -->
          <img 
            v-if="esImagen" 
            :src="vistaPrevia" 
            alt="Vista previa del archivo" 
            class="preview-img" 
          />

          <!-- Si es PDF -->
          <iframe 
            v-else-if="esPdf" 
            :src="vistaPrevia" 
            class="preview-pdf"
          ></iframe>

          <p class="nombre-archivo">Archivo: {{ archivoSeleccionado.name }}</p>
        </div>

        <button type="submit" :disabled="cargando">
          {{ cargando ? 'Subiendo...' : 'Enviar Currículum' }}
        </button>
      </form>

      <p v-if="mensajeError" class="error-msg">{{ mensajeError }}</p>
      <p v-if="mensajeExito" class="exito-msg">{{ mensajeExito }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SubirCurriculumView',
  data() {
    return {
      usuario: null,
      archivoSeleccionado: null,
      vistaPrevia: null,
      esImagen: false,
      esPdf: false,
      cargando: false,
      mensajeExito: '',
      mensajeError: ''
    };
  },
  mounted() {
    const sesion = localStorage.getItem('usuario');
    if (sesion) {
      this.usuario = JSON.parse(sesion);
    }
  },
  methods: {
    seleccionarArchivo(event) {
      const archivo = event.target.files[0];
      if (!archivo) return;

      this.archivoSeleccionado = archivo;
      
      // Liberar URL previa si ya existía una
      if (this.vistaPrevia) {
        URL.revokeObjectURL(this.vistaPrevia);
      }

      // Detectar tipo de archivo
      this.esImagen = archivo.type.startsWith('image/');
      this.esPdf = archivo.type === 'application/pdf';

      // Crear URL para vista previa
      this.vistaPrevia = URL.createObjectURL(archivo);
    },
    async subirArchivo() {
      if (!this.archivoSeleccionado) {
        this.mensajeError = 'Por favor, seleccioná un archivo.';
        return;
      }

      this.cargando = true;
      this.mensajeExito = '';
      this.mensajeError = '';

      const formData = new FormData();
      formData.append('curriculum', this.archivoSeleccionado);

      try {
        const response = await fetch('http://localhost/conexion/subir_curriculum.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.mensaje) {
          this.mensajeExito = data.mensaje;
          this.archivoSeleccionado = null;
          this.vistaPrevia = null;
          this.esImagen = false;
          this.esPdf = false;
          const input = document.getElementById('archivo');
          if (input) input.value = '';
        } else {
          this.mensajeError = data.error || 'Error al subir el archivo.';
        }
      } catch (error) {
        this.mensajeError = 'Error de conexión con el servidor.';
      } finally {
        this.cargando = false;
      }
    }
  }
};
</script>

<style scoped>
.curriculum-container {
  max-width: 500px;
  margin: 30px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.usuario-info {
  margin-bottom: 15px;
  color: #333;
}

.form-group {
  margin: 20px 0;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
}

.form-group input {
  width: 100%;
}

/* Estilos de la Vista Previa */
.preview-container {
  margin: 15px 0;
  padding: 10px;
  border: 1px dashed #bbb;
  border-radius: 6px;
  text-align: center;
}

.preview-img {
  max-width: 100%;
  max-height: 250px;
  border-radius: 4px;
  object-fit: contain;
}

.preview-pdf {
  width: 100%;
  height: 300px;
  border: none;
}

.nombre-archivo {
  font-size: 0.9em;
  color: #555;
  margin-top: 8px;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #27ae60;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:disabled {
  background-color: #95a5a6;
}

.error-msg {
  color: red;
  margin-top: 10px;
}

.exito-msg {
  color: green;
  margin-top: 10px;
}
</style>