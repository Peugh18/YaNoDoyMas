<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const form = useForm({
  name: '',
  description: '',
  price: '',
  size: '',
  state: '',
  points: '',
  image: null,
})

function submit() {
  form.post(route('productos.store'), {
    forceFormData: true
  })
}
</script>

<template>
  <AppLayout>
    <div class="p-6 max-w-md mx-auto bg-card rounded-lg shadow-lg">
      <h2 class="text-2xl font-bold mb-6">Nuevo Producto</h2>
      <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Nombre</label>
          <input v-model="form.name" type="text" class="input input-bordered w-full" required placeholder="Nombre del producto" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Descripción</label>
          <textarea v-model="form.description" class="input input-bordered w-full" placeholder="Descripción"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Precio</label>
          <input v-model="form.price" type="number" step="0.01" class="input input-bordered w-full" required placeholder="0" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Tamaño</label>
          <input v-model="form.size" type="text" class="input input-bordered w-full" placeholder="Ej: 45 cm" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Estado</label>
          <input v-model="form.state" type="text" class="input input-bordered w-full" placeholder="Ej: Nuevo" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Puntos</label>
          <input v-model="form.points" type="number" class="input input-bordered w-full" required placeholder="0" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Imagen</label>
          <input type="file" @change="e => form.image = e.target.files[0]" accept="image/*" class="input input-bordered w-full" />
        </div>
        <div class="flex justify-end gap-2 mt-6">
          <button type="button" class="btn btn-ghost" @click="$inertia.visit(route('productos.index'))">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </AppLayout>
</template> 