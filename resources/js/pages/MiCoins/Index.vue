<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Edit, Trash, Plus } from 'lucide-vue-next';

interface MiCoinTx {
  id: number;
  user_id: number;
  user_name: string;
  amount: number;
  transaction_type: string;
  description: string;
  created_at: string;
}

const transactions = ref<MiCoinTx[]>([
  {
    id: 1,
    user_id: 1,
    user_name: 'Juan Pérez',
    amount: 100,
    transaction_type: 'compra',
    description: 'Compra de producto',
    created_at: '2024-06-01',
  },
  {
    id: 2,
    user_id: 2,
    user_name: 'Ana López',
    amount: -50,
    transaction_type: 'descuento',
    description: 'Descuento por subasta',
    created_at: '2024-06-02',
  },
]);

const showModal = ref(false);
const isEdit = ref(false);
const form = ref<MiCoinTx>({
  id: 0,
  user_id: 0,
  user_name: '',
  amount: 0,
  transaction_type: '',
  description: '',
  created_at: '',
});

function openCreate() {
  isEdit.value = false;
  showModal.value = true;
  form.value = {
    id: 0,
    user_id: 0,
    user_name: '',
    amount: 0,
    transaction_type: '',
    description: '',
    created_at: '',
  };
}

function openEdit(tx: MiCoinTx) {
  isEdit.value = true;
  showModal.value = false;
  setTimeout(() => {
    showModal.value = true;
    form.value = { ...tx };
  }, 100);
}

function saveTx() {
  if (isEdit.value) {
    const idx = transactions.value.findIndex(t => t.id === form.value.id);
    if (idx !== -1) transactions.value[idx] = { ...form.value };
  } else {
    transactions.value.push({
      ...form.value,
      id: Date.now(),
      created_at: new Date().toISOString().slice(0, 10),
    });
  }
  showModal.value = false;
}

function deleteTx(id: number) {
  transactions.value = transactions.value.filter(t => t.id !== id);
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Transacciones MiCoins</h1>
        <button
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition"
          @click="openCreate"
        >
          <Plus class="w-4 h-4" /> Nueva Transacción
        </button>
      </div>

      <div class="bg-card rounded-lg border p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div
            v-for="tx in transactions"
            :key="tx.id"
            class="rounded-lg border bg-background p-4 shadow transition hover:shadow-lg flex flex-col justify-between"
          >
            <div>
              <h3 class="font-bold text-lg mb-1">{{ tx.user_name }}</h3>
              <div class="text-xs mb-1">Monto: <span class="font-semibold">{{ tx.amount }}</span></div>
              <div class="text-xs mb-1">Tipo: <span class="font-semibold">{{ tx.transaction_type }}</span></div>
              <div class="text-xs mb-1">Descripción: <span class="font-semibold">{{ tx.description }}</span></div>
              <div class="text-xs text-muted-foreground">Fecha: {{ tx.created_at }}</div>
            </div>
            <div class="flex gap-2 mt-4">
              <button class="text-primary hover:text-primary/80" @click="openEdit(tx)">
                <Edit class="w-4 h-4" />
              </button>
              <button class="text-destructive hover:text-destructive/80" @click="deleteTx(tx.id)">
                <Trash class="w-4 h-4" />
              </button>
            </div>
          </div>
          <div v-if="transactions.length === 0" class="col-span-full text-center text-muted-foreground py-6">
            No hay transacciones registradas.
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
            {{ isEdit ? 'Editar Transacción' : 'Nueva Transacción' }}
          </h2>
          <form @submit.prevent="saveTx" class="space-y-4">
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
              <label class="block text-sm font-medium mb-1">Monto</label>
              <input
                v-model.number="form.amount"
                type="number"
                class="input input-bordered w-full"
                required
                placeholder="0"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Tipo</label>
              <input
                v-model="form.transaction_type"
                type="text"
                class="input input-bordered w-full"
                required
                placeholder="compra, subasta, descuento..."
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Descripción</label>
              <input
                v-model="form.description"
                type="text"
                class="input input-bordered w-full"
                placeholder="Descripción de la transacción"
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

