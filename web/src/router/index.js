import { createRouter, createWebHistory } from 'vue-router'
import Inicio from '../views/inicio.vue'
import Empresa from '../views/Empresa.vue'
import Productos from '@/views/productos.vue'
import Curriculum from '@/views/curriculum.vue'
import Contacto from '@/views/contacto.vue'
import LoginView from '@/views/login.vue'
import RegistrarseView from '@/views/registrarse.vue' 
import SubirCurriculumView from '@/views/subir-curriculum.vue' 
import colchonesView from '@/views/colchones.vue' 
import livingView from '@/views/living.vue' 
import EspumaView from '@/views/espuma.vue' 
import EspumaSoftView from '@/views/espumasoft.vue' 
import ResortesView from '@/views/resortes.vue' 




const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'inicio',
      component: Inicio
    },
    {
      path: '/Empresa',
      name: 'Empresa',
      component: Empresa
    },
    {
      path: '/productos',
      name: 'productos',
      component: Productos
    },
    {
      path: '/curriculum',
      name: 'curriculum',
      component: Curriculum  
    },
    {
      path: '/contacto',
      name: 'contacto',
      component: Contacto  
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/registrarse',
      name: 'registrarse',
      component: RegistrarseView
    },
    {
      path: '/subir-curriculum',
      name: 'subir-curriculum',
      component: SubirCurriculumView,
      meta: { requiresAuth: true }
    },
    {
      path: '/colchones',
      name: 'colchones',
      component: colchonesView,
    },
    {
      path: '/living',
      name: 'living',
      component: livingView,
    },
    {
    path: '/espuma',
    name: 'espuma',
    component: EspumaView
  },
  {
    path: '/espumasoft',
    name: 'espumasoft',
    component: EspumaSoftView
  },
  {
    path: '/resortes',
    name: 'resortes',
    component: ResortesView
  }
  
  ]
})

// Guardia de navegación para bloquear rutas protegidas
router.beforeEach((to, from, next) => {
  const usuarioAutenticado = localStorage.getItem('usuario')

  if (to.meta.requiresAuth && !usuarioAutenticado) {
    // Redirige al login si no hay sesión iniciada
    next('/login')
  } else {
    next()
  }
})

export default router