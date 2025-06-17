<template>
  <div class="h-screen w-64 bg-background border-r">
    <div class="p-4">
      <h2 class="text-xl font-bold mb-6">Misuji Store</h2>
      <nav class="space-y-2">
        <router-link 
          v-for="item in menuItems" 
          :key="item.path"
          :to="item.path"
          class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors hover:bg-accent"
          :class="{ 'bg-accent': isActive(item.path) }"
        >
          <component :is="item.icon" class="w-5 h-5" />
          <span>{{ item.name }}</span>
        </router-link>
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import {
  Users,
  Package,
  Gavel,
  ShoppingCart,
  Coins
} from 'lucide-vue-next'

const route = useRoute()

const menuItems = ref([
  {
    name: 'Usuarios',
    path: '/usuarios',
    icon: Users
  },
  {
    name: 'Productos',
    path: '/productos',
    icon: Package
  },
  {
    name: 'Subastas',
    path: '/subastas',
    icon: Gavel
  },
  {
    name: 'Ventas',
    path: '/ventas',
    icon: ShoppingCart
  },
  {
    name: 'MiCoins',
    path: '/micoins',
    icon: Coins
  }
])

const isActive = (path: string) => {
  return route.path === path
}
</script>

<style scoped>
.router-link-active {
  @apply bg-accent text-accent-foreground;
}
</style> 