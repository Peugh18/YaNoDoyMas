<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Edit, Trash, Plus, PackageSearch } from 'lucide-vue-next';
import { ref } from 'vue';
import CreateProductForm from './Create.vue';
import ProductForm from './ProductForm.vue';

defineProps({
  products: Array
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const productToEdit = ref(null);
const showDeleteAlert = ref(false);
const productToDelete = ref(null);

function openCreateModal() {
  showCreateModal.value = true;
}
function closeCreateModal() {
  showCreateModal.value = false;
}
function handleProductCreated() {
  // Recargar la página para actualizar el listado tras crear un producto
  window.location.reload();
}
function openEditModal(product) {
  productToEdit.value = product;
  showEditModal.value = true;
}
function closeEditModal() {
  showEditModal.value = false;
  productToEdit.value = null;
}
function handleProductUpdated() {
  window.location.reload();
}
function openDeleteAlert(product) {
  productToDelete.value = product;
  showDeleteAlert.value = true;
}
function closeDeleteAlert() {
  showDeleteAlert.value = false;
  productToDelete.value = null;
}


function confirmDelete() {
  if (productToDelete.value) {
    router.delete(route('productos.destroy', productToDelete.value.id), {
      onSuccess: () => {
        closeDeleteAlert();
        window.location.reload();
      }
    });
  }
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold flex items-center gap-2">
          <PackageSearch class="w-7 h-7 text-primary" /> Gestión de Productos
        </h1>
        <button
          type="button"
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition shadow"
          @click="openCreateModal"
        >
          <Plus class="w-5 h-5" /> Nuevo Producto
        </button>
      </div>

      <div class="bg-card rounded-xl border p-6 shadow-lg">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          <div
            v-for="product in products"
            :key="product.id"
            class="rounded-xl border bg-background p-6 shadow flex flex-col items-center hover:shadow-xl transition"
          >
            <img
              :src="'/' + product.image_url"
              alt="img"
              class="w-32 h-32 object-cover rounded-lg mb-4 border"
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
            <div class="flex gap-4 mt-4">
              <button @click="openEditModal(product)" class="text-primary hover:text-primary/80 p-2 rounded-full bg-primary/10">
                <Edit class="w-5 h-5" />
              </button>
              <button @click="openDeleteAlert(product)" class="text-destructive hover:text-destructive/80 p-2 rounded-full bg-destructive/10">
                <Trash class="w-5 h-5" />
              </button>
            </div>
          </div>
          <div v-if="products.length === 0" class="col-span-full text-center text-muted-foreground py-12 flex flex-col items-center gap-2">
            <PackageSearch class="w-10 h-10 opacity-40 mb-2" />
            <span class="text-lg">No hay productos registrados.</span>
          </div>
        </div>
      </div>

      <!-- Modal para crear producto -->
      <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-card rounded-xl shadow-2xl border border-border max-w-lg w-full relative">
          <button @click="closeCreateModal" class="absolute top-2 right-2 text-xl text-muted-foreground hover:text-primary">&times;</button>
          <ProductForm @close="closeCreateModal" @created="handleProductCreated" />
        </div>
      </div>

      <!-- Modal para editar producto -->
      <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-card rounded-xl shadow-2xl border border-border max-w-lg w-full relative">
          <button @click="closeEditModal" class="absolute top-2 right-2 text-xl text-muted-foreground hover:text-primary">&times;</button>
          <ProductForm :product="productToEdit" @close="closeEditModal" @updated="handleProductUpdated" />
        </div>
      </div>

      <!-- Alerta de confirmación para eliminar -->
      <div v-if="showDeleteAlert" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-card rounded-xl shadow-2xl border border-border max-w-sm w-full p-6 text-center relative">
          <button @click="closeDeleteAlert" class="absolute top-2 right-2 text-xl text-muted-foreground hover:text-primary">&times;</button>
          <h3 class="text-xl font-bold mb-4">¿Eliminar producto?</h3>
          <p class="mb-6">¿Estás seguro de que deseas eliminar <span class="font-semibold">{{ productToDelete?.name }}</span>? Esta acción no se puede deshacer.</p>
          <div class="flex justify-center gap-4">
            <button @click="closeDeleteAlert" class="btn btn-ghost">Cancelar</button>
            <button @click="confirmDelete" class="btn btn-destructive">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

