import { createRouter, createWebHistory } from 'vue-router'
import Sidebar from '../Components/Sidebar.vue'

const routes = [
  {
    path: '/',
    component: Sidebar,
    children: [
      {
        path: 'usuarios',
        name: 'usuarios',
        component: () => import('../Pages/Usuarios/Index.vue')
      },
      {
        path: 'productos',
        name: 'productos',
        component: () => import('../Pages/Productos/Index.vue')
      },
      {
        path: 'subastas',
        name: 'subastas',
        component: () => import('../Pages/Subastas/Index.vue')
      },
      {
        path: 'ventas',
        name: 'ventas',
        component: () => import('../Pages/Ventas/Index.vue')
      },
      {
        path: 'micoins',
        name: 'micoins',
        component: () => import('../Pages/MiCoins/Index.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router 