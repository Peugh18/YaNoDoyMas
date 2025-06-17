<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Edit, Trash, Plus } from 'lucide-vue-next';

defineProps({
  products: Array
});
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Productos</h1>
        <Link
          :href="route('productos.create')"
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition"
        >
          <Plus class="w-4 h-4" /> Nuevo Producto
        </Link>
      </div>

      <div class="bg-card rounded-lg border p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div
            v-for="product in products"
            :key="product.id"
            class="rounded-lg border bg-background p-4 shadow transition hover:shadow-lg flex flex-col items-center"
          >
            <img
              :src="'/' + product.image_url"
              alt="img"
              class="w-32 h-32 object-cover rounded-lg mb-3 border"
              v-if="product.image_url"
            />
            <h3 class="font-bold text-lg text-center mb-1">{{ product.name }}</h3>
            <p class="text-sm text-muted-foreground text-center mb-2">{{ product.description }}</p>
            <div class="w-full flex flex-col gap-1 text-xs mb-2">
              <div>Precio: <span class="font-semibold">S/ {{ product.price }}</span></div>
              <div>Tamaño: <span class="font-semibold">{{ product.size }}</span></div>
              <div>Estado: <span class="font-semibold">{{ product.state }}</span></div>
              <div>Puntos: <span class="font-semibold">{{ product.points }}</span></div>
              <div class="text-muted-foreground">Creado: {{ product.created_at }}</div>
            </div>
            <div class="flex gap-2 mt-2">
              <Link :href="route('productos.edit', product.id)" class="text-primary hover:text-primary/80">
                <Edit class="w-4 h-4" />
              </Link>
              <form :action="route('productos.destroy', product.id)" method="post" @submit.prevent="$inertia.delete(route('productos.destroy', product.id))">
                <button type="submit" class="text-destructive hover:text-destructive/80">
                  <Trash class="w-4 h-4" />
                </button>
              </form>
            </div>
          </div>
          <div v-if="products.length === 0" class="col-span-full text-center text-muted-foreground py-6">
            No hay productos registrados.
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

