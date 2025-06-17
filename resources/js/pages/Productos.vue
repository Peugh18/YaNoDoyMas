<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];  
</script>
<template>
<AppLayout >
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Gestión de Productos</h1>
      <button class="bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90">
        Nuevo Producto
      </button>
    </div>
    <div class="bg-card rounded-lg border p-4">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b">
              <th class="text-left py-3 px-4">ID</th>
              <th class="text-left py-3 px-4">Nombre</th>
              <th class="text-left py-3 px-4">Categoría</th>
              <th class="text-left py-3 px-4">Precio</th>
              <th class="text-left py-3 px-4">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="i in 5" :key="i" class="border-b">
              <td class="py-3 px-4">{{ i }}</td>
              <td class="py-3 px-4">Producto {{ i }}</td>
              <td class="py-3 px-4">Categoría {{ i }}</td>
              <td class="py-3 px-4">${{ (i * 10).toFixed(2) }}</td>
              <td class="py-3 px-4">
                <div class="flex space-x-2">
                  <button class="text-primary hover:text-primary/80">
                    <Edit class="w-4 h-4" />
                  </button>
                  <button class="text-destructive hover:text-destructive/80">
                    <Trash class="w-4 h-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</AppLayout>
</template>

