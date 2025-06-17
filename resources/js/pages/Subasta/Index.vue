<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Edit, Trash, Plus } from 'lucide-vue-next';

interface Auction {
  id: number;
  product_id: number;
  product_name: string;
  start_date: string;
  end_date: string;
  highest_bid: number;
  status: string;
  created_at: string;
}

const auctions = ref<Auction[]>([
  {
    id: 1,
    product_id: 1,
    product_name: 'Camiseta Misuji',
    start_date: '2024-06-01 10:00',
    end_date: '2024-06-10 18:00',
    highest_bid: 100,
    status: 'Activa',
    created_at: '2024-06-01',
  },
  {
    id: 2,
    product_id: 2,
    product_name: 'Taza Misuji',
    start_date: '2024-06-05 09:00',
    end_date: '2024-06-12 20:00',
    highest_bid: 50,
    status: 'Finalizada',
    created_at: '2024-06-05',
  },
]);

const showModal = ref(false);
const isEdit = ref(false);
const form = ref<Auction>({
  id: 0,
  product_id: 0,
  product_name: '',
  start_date: '',
  end_date: '',
  highest_bid: 0,
  status: '',
  created_at: '',
});

function openCreate() {
  isEdit.value = false;
  showModal.value = true;
  form.value = {
    id: 0,
    product_id: 0,
    product_name: '',
    start_date: '',
    end_date: '',
    highest_bid: 0,
    status: '',
    created_at: '',
  };
}

function openEdit(auction: Auction) {
  isEdit.value = true;
  showModal.value = false;
  setTimeout(() => {
    showModal.value = true;
    form.value = { ...auction };
  }, 100);
}

function saveAuction() {
  if (isEdit.value) {
    const idx = auctions.value.findIndex(a => a.id === form.value.id);
    if (idx !== -1) auctions.value[idx] = { ...form.value };
  } else {
    auctions.value.push({
      ...form.value,
      id: Date.now(),
      created_at: new Date().toISOString().slice(0, 10),
    });
  }
  showModal.value = false;
}

function deleteAuction(id: number) {
  auctions.value = auctions.value.filter(a => a.id !== id);
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Subastas</h1>
        <button
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition"
          @click="openCreate"
        >
          <Plus class="w-4 h-4" /> Nueva Subasta
        </button>
      </div>

      <div class="bg-card rounded-lg border p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div
            v-for="auction in auctions"
            :key="auction.id"
            class="rounded-lg border bg-background p-4 shadow transition hover:shadow-lg flex flex-col justify-between"
          >
            <div>
              <h3 class="font-bold text-lg mb-1">{{ auction.product_name }}</h3>
              <div class="text-xs mb-1">Fecha inicio: <span class="font-semibold">{{ auction.start_date }}</span></div>
              <div class="text-xs mb-1">Fecha cierre: <span class="font-semibold">{{ auction.end_date }}</span></div>
              <div class="text-xs mb-1">Puja más alta: <span class="font-semibold">${{ auction.highest_bid }}</span></div>
              <div class="text-xs mb-1">Estado: <span class="font-semibold">{{ auction.status }}</span></div>
              <div class="text-xs text-muted-foreground">Creado: {{ auction.created_at }}</div>
            </div>
            <div class="flex gap-2 mt-4">
              <button class="text-primary hover:text-primary/80" @click="openEdit(auction)">
                <Edit class="w-4 h-4" />
              </button>
              <button class="text-destructive hover:text-destructive/80" @click="deleteAuction(auction.id)">
                <Trash class="w-4 h-4" />
              </button>
            </div>
          </div>
          <div v-if="auctions.length === 0" class="col-span-full text-center text-muted-foreground py-6">
            No hay subastas registradas.
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
            {{ isEdit ? 'Editar Subasta' : 'Nueva Subasta' }}
          </h2>
          <form @submit.prevent="saveAuction" class="space-y-4">
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
              <label class="block text-sm font-medium mb-1">Fecha inicio</label>
              <input
                v-model="form.start_date"
                type="datetime-local"
                class="input input-bordered w-full"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Fecha cierre</label>
              <input
                v-model="form.end_date"
                type="datetime-local"
                class="input input-bordered w-full"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Puja más alta</label>
              <input
                v-model.number="form.highest_bid"
                type="number"
                min="0"
                class="input input-bordered w-full"
                required
                placeholder="0"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <input
                v-model="form.status"
                type="text"
                class="input input-bordered w-full"
                placeholder="Activa/Finalizada"
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

