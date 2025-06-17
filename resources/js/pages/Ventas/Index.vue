<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Edit, Trash, Plus } from 'lucide-vue-next';

interface Sale {
  id: number;
  user_id: number;
  user_name: string;
  product_id: number;
  product_name: string;
  total_amount: number;
  points_earned: number;
  created_at: string;
}

const sales = ref<Sale[]>([
  {
    id: 1,
    user_id: 1,
    user_name: 'Juan Pérez',
    product_id: 1,
    product_name: 'Camiseta Misuji',
    total_amount: 25.5,
    points_earned: 50,
    created_at: '2024-06-01',
  },
  {
    id: 2,
    user_id: 2,
    user_name: 'Ana López',
    product_id: 2,
    product_name: 'Taza Misuji',
    total_amount: 10,
    points_earned: 20,
    created_at: '2024-06-02',
  },
]);

const showModal = ref(false);
const isEdit = ref(false);
const form = ref<Sale>({
  id: 0,
  user_id: 0,
  user_name: '',
  product_id: 0,
  product_name: '',
  total_amount: 0,
  points_earned: 0,
  created_at: '',
});

function openCreate() {
  isEdit.value = false;
  showModal.value = true;
  form.value = {
    id: 0,
    user_id: 0,
    user_name: '',
    product_id: 0,
    product_name: '',
    total_amount: 0,
    points_earned: 0,
    created_at: '',
  };
}

function openEdit(sale: Sale) {
  isEdit.value = true;
  showModal.value = false;
  setTimeout(() => {
    showModal.value = true;
    form.value = { ...sale };
  }, 100);
}

function saveSale() {
  if (isEdit.value) {
    const idx = sales.value.findIndex(s => s.id === form.value.id);
    if (idx !== -1) sales.value[idx] = { ...form.value };
  } else {
    sales.value.push({
      ...form.value,
      id: Date.now(),
      created_at: new Date().toISOString().slice(0, 10),
    });
  }
  showModal.value = false;
}

function deleteSale(id: number) {
  sales.value = sales.value.filter(s => s.id !== id);
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Ventas</h1>
        <button
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition"
          @click="openCreate"
        >
          <Plus class="w-4 h-4" /> Nueva Venta
        </button>
      </div>

      <div class="bg-card rounded-lg border p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div
            v-for="sale in sales"
            :key="sale.id"
            class="rounded-lg border bg-background p-4 shadow transition hover:shadow-lg flex flex-col justify-between"
          >
            <div>
              <h3 class="font-bold text-lg mb-1">{{ sale.product_name }}</h3>
              <div class="text-xs mb-1">Usuario: <span class="font-semibold">{{ sale.user_name }}</span></div>
              <div class="text-xs mb-1">Total: <span class="font-semibold">${{ sale.total_amount }}</span></div>
              <div class="text-xs mb-1">Puntos: <span class="font-semibold">{{ sale.points_earned }}</span></div>
              <div class="text-xs text-muted-foreground">Fecha: {{ sale.created_at }}</div>
            </div>
            <div class="flex gap-2 mt-4">
              <button class="text-primary hover:text-primary/80" @click="openEdit(sale)">
                <Edit class="w-4 h-4" />
              </button>
              <button class="text-destructive hover:text-destructive/80" @click="deleteSale(sale.id)">
                <Trash class="w-4 h-4" />
              </button>
            </div>
          </div>
          <div v-if="sales.length === 0" class="col-span-full text-center text-muted-foreground py-6">
            No hay ventas registradas.
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
            {{ isEdit ? 'Editar Venta' : 'Nueva Venta' }}
          </h2>
          <form @submit.prevent="saveSale" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-1">Usuario</label>
              <input
                v-model="form.user_name"
                type="text"
                class="input input-bordered w-full"
                required
                placeholder="Nombre del usuario"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Producto</label>
              <input
                v-model="form.product_name"
                type="text"
                class="input input-bordered w-full"
                required
                placeholder="Nombre del producto"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Total</label>
              <input
                v-model.number="form.total_amount"
                type="number"
                min="0"
                class="input input-bordered w-full"
                required
                placeholder="0"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Puntos</label>
              <input
                v-model.number="form.points_earned"
                type="number"
                min="0"
                class="input input-bordered w-full"
                required
                placeholder="0"
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

