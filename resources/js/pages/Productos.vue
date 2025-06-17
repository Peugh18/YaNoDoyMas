<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Edit, Trash, Plus } from 'lucide-vue-next';

interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
  size: string;
  state: string;
  points: number;
  image_url: string;
  created_at: string;
}

const products = ref<Product[]>([
  {
    id: 1,
    name: 'Camiseta Misuji',
    description: 'Camiseta edición limitada',
    price: 25.5,
    size: 'M',
    state: 'Nuevo',
    points: 50,
    image_url: 'https://www.tagoya.com/2748-thickbox_default/camiseta-mizuno-blanca-karate-algodon.jpg',
    created_at: '2024-06-01',
  },
  {
    id: 2,
    name: 'Taza Misuji',
    description: 'Taza de cerámica',
    price: 10,
    size: '350ml',
    state: 'Nuevo',
    points: 20,
    image_url: 'https://rimage.ripley.com.pe/home.ripley/Attachment/MKP/5063/PMP20000550082/imagen2-1.jpeg',
    created_at: '2024-06-02',
  },
]);

const showModal = ref(false);
const isEdit = ref(false);
const form = ref<Product>({
  id: 0,
  name: '',
  description: '',
  price: 0,
  size: '',
  state: '',
  points: 0,
  image_url: '',
  created_at: '',
});

function openCreate() {
  isEdit.value = false;
  showModal.value = true;
  form.value = {
    id: 0,
    name: '',
    description: '',
    price: 0,
    size: '',
    state: '',
    points: 0,
    image_url: '',
    created_at: '',
  };
}

function openEdit(product: Product) {
  isEdit.value = true;
  showModal.value = false;
  setTimeout(() => {
    showModal.value = true;
    form.value = { ...product };
  }, 100);
}

function saveProduct() {
  if (isEdit.value) {
    const idx = products.value.findIndex(p => p.id === form.value.id);
    if (idx !== -1) products.value[idx] = { ...form.value };
  } else {
    products.value.push({
      ...form.value,
      id: Date.now(),
      created_at: new Date().toISOString().slice(0, 10),
    });
  }
  showModal.value = false;
}

function deleteProduct(id: number) {
  products.value = products.value.filter(p => p.id !== id);
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Productos</h1>
        <button
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition"
          @click="openCreate"
        >
          <Plus class="w-4 h-4" /> Nuevo Producto
        </button>
      </div>

      <div class="bg-card rounded-lg border p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div
            v-for="product in products"
            :key="product.id"
            class="rounded-lg border bg-background p-4 shadow transition hover:shadow-lg flex flex-col items-center"
          >
            <img
              :src="product.image_url"
              alt="img"
              class="w-32 h-32 object-cover rounded-lg mb-3 border"
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
              <button class="text-primary hover:text-primary/80" @click="openEdit(product)">
                <Edit class="w-4 h-4" />
              </button>
              <button class="text-destructive hover:text-destructive/80" @click="deleteProduct(product.id)">
                <Trash class="w-4 h-4" />
              </button>
            </div>
          </div>
          <div v-if="products.length === 0" class="col-span-full text-center text-muted-foreground py-6">
            No hay productos registrados.
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div
        v-if="showModal"
        class="fixed inset-y-0 right-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-md ml-64 w-[calc(100vw-16rem)]"
      >
        <div class="bg-white dark:bg-background rounded-lg shadow-lg w-full max-w-md p-6 relative">
          <h2 class="text-xl font-bold mb-4">
            {{ isEdit ? 'Editar Producto' : 'Nuevo Producto' }}
          </h2>
          <form @submit.prevent="saveProduct" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre</label>
              <input
                v-model="form.name"
                type="text"
                class="input input-bordered w-full"
                required
                placeholder="Nombre del producto"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Descripción</label>
              <input
                v-model="form.description"
                type="text"
                class="input input-bordered w-full"
                required
                placeholder="Descripción"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Precio</label>
              <input
                v-model.number="form.price"
                type="number"
                min="0"
                class="input input-bordered w-full"
                required
                placeholder="0"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Tamaño</label>
              <input
                v-model="form.size"
                type="text"
                class="input input-bordered w-full"
                placeholder="Ej: 45 cm"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <input
                v-model="form.state"
                type="text"
                class="input input-bordered w-full"
                placeholder="Ej: Nuevo"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Puntos</label>
              <input
                v-model.number="form.points"
                type="number"
                min="0"
                class="input input-bordered w-full"
                required
                placeholder="0"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">URL Imagen</label>
              <input
                v-model="form.image_url"
                type="text"
                class="input input-bordered w-full"
                placeholder="https://..."
              />
            </div>
            <div class="flex justify-end gap-2 mt-6">
              <button
                type="button"
                class="btn btn-ghost"
                @click="showModal = false"
              >
                Cancelar
              </button>
              <button
                type="submit"
                class="btn btn-primary"
              >
                Guardar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

