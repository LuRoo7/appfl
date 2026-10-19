import { createRouter, createWebHistory } from 'vue-router'
import PagE from '../views/PagE.vue'
import PaE from '../views/PagE.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/App'
    },
    
    {
      path: '/PagE',
      name: 'PagE',
      component: () => import('../views/PagE.vue'),
    },
    {
      path: '/PagW',
      name: 'PagW',
      component: () => import('../views/PagW.vue'),
    },
    {
      path: '/EmpleadosAdmin',
      name: 'EmpleadosAdmin',
      component: () => import('../views/EmpleadosAdmin.vue'),
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/calendario',
      name: 'calendario',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/calendario.vue'),
    },
    {
      path: '/NovedadesAdmin',
      name: 'NovedadesAdmin',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/NovedadesAdmin.vue'),
    },
    {
      path: '/HigieneAdmin',
      name: 'HigieneAdmin',
      component: () => import('../views/HigieneAdmin.vue'),
    },
    {
      path: '/Miperfiladmin',
      name: 'Miperfiladmin',
      component: () => import('../views/Miperfiladmin.vue')
    },
    {
      path: '/capacitacionesadmin',
      name: 'capacitacionesadmin',
      component: () => import('../views/capacitacionesadmin.vue')
    },


  ],
  
})

export default router
