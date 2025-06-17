<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { ref } from 'vue'
import { Edit, Trash, Plus, Eye, EyeOff } from 'lucide-vue-next'

interface User {
  id: number
  name: string
  email: string
  password: string
  mi_coins_balance: number
  created_at: string
}

const users = ref<User[]>([
  {
    id: 1,
    name: 'Juan Pérez',
    email: 'juan@example.com',
    password: '********',
    mi_coins_balance: 100,
    created_at: '2024-06-01',
  },
  {
    id: 2,
    name: 'Ana López',
    email: 'ana@example.com',
    password: '********',
    mi_coins_balance: 250,
    created_at: '2024-06-02',
  },
])

const showModal = ref(false)
const isEdit = ref(false)
const showPassword = ref(false)
const form = ref<User>({
  id: 0,
  name: '',
  email: '',
  password: '',
  mi_coins_balance: 0,
  created_at: '',
})

function openCreate() {
  isEdit.value = false
  showModal.value = true
  showPassword.value = false
  form.value = {
    id: 0,
    name: '',
    email: '',
    password: '',
    mi_coins_balance: 0,
    created_at: '',
  }
}

function openEdit(user: User) {
  isEdit.value = true
  showModal.value = false
  setTimeout(() => {
    showModal.value = true
    form.value = { ...user }
    showPassword.value = false
  }, 100)
}

function saveUser() {
  if (isEdit.value) {
    const idx = users.value.findIndex(u => u.id === form.value.id)
    if (idx !== -1) users.value[idx] = { ...form.value }
  } else {
    users.value.push({
      ...form.value,
      id: Date.now(),
      created_at: new Date().toISOString().slice(0, 10),
    })
  }
  showModal.value = false
}

function deleteUser(id: number) {
  users.value = users.value.filter(u => u.id !== id)
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Usuarios</h1>
        <button
          class="flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition"
          @click="openCreate"
        >
          <Plus class="w-4 h-4" /> Nuevo Usuario
        </button>
      </div>

      <div class="bg-card rounded-lg border p-4">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b">
                <th class="text-left py-3 px-4">ID</th>
                <th class="text-left py-3 px-4">Nombre</th>
                <th class="text-left py-3 px-4">Email</th>
                <th class="text-left py-3 px-4">MiCoins</th>
                <th class="text-left py-3 px-4">Fecha de creación</th>
                <th class="text-left py-3 px-4">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id" class="border-b">
                <td class="py-3 px-4">{{ user.id }}</td>
                <td class="py-3 px-4">{{ user.name }}</td>
                <td class="py-3 px-4">{{ user.email }}</td>
                <td class="py-3 px-4">{{ user.mi_coins_balance }}</td>
                <td class="py-3 px-4">{{ user.created_at }}</td>
                <td class="py-3 px-4">
                  <div class="flex space-x-2">
                    <button class="text-primary hover:text-primary/80" @click="openEdit(user)">
                      <Edit class="w-4 h-4" />
                    </button>
                    <button class="text-destructive hover:text-destructive/80" @click="deleteUser(user.id)">
                      <Trash class="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="users.length === 0">
                <td colspan="6" class="text-center py-6 text-muted-foreground">No hay usuarios registrados.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal -->
      <div
        v-if="showModal"
        class="fixed inset-y-0 right-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-md ml-64 w-[calc(100vw-16rem)]"
      >
        <div class="bg-white dark:bg-background rounded-lg shadow-lg w-full max-w-md p-6 relative">
          <h2 class="text-xl font-bold mb-4">
            {{ isEdit ? 'Editar Usuario' : 'Nuevo Usuario' }}
          </h2>
          <form @submit.prevent="saveUser" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre</label>
              <input
                v-model="form.name"
                type="text"
                class="input input-bordered w-full"
                required
                placeholder="Nombre completo"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <input
                v-model="form.email"
                type="email"
                class="input input-bordered w-full"
                required
                placeholder="correo@ejemplo.com"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Password</label>
              <div class="relative">
                <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  class="input input-bordered w-full pr-10"
                  required
                  placeholder="********"
                />
                <button
                  type="button"
                  class="absolute right-2 top-1/2 -translate-y-1/2 text-muted-foreground"
                  @click="showPassword = !showPassword"
                  tabindex="-1"
                >
                  <Eye v-if="!showPassword" class="w-4 h-4" />
                  <EyeOff v-else class="w-4 h-4" />
                </button>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Saldo MiCoins</label>
              <input
                v-model.number="form.mi_coins_balance"
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