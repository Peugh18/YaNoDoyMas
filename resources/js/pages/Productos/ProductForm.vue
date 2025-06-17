<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Loader2, ImagePlus } from 'lucide-vue-next'

const props = defineProps({
  product: Object,
  onSuccess: Function,
})

const emit = defineEmits(['close', 'created', 'updated'])

const form = useForm({
  name: props.product?.name || '',
  description: props.product?.description || '',
  price: props.product?.price || '',
  size: props.product?.size || '',
  state: props.product?.state || '',
  points: props.product?.points || '',
  image: null,
})

const imagePreview = ref(props.product?.image_url ? '/' + props.product.image_url : null)

watch(() => props.product, (newVal) => {
  if (newVal) {
    form.reset({
      name: newVal.name,
      description: newVal.description,
      price: Number(newVal.price),
      size: newVal.size,
      state: newVal.state,
      points: Number(newVal.points),
      image: null
    });
    imagePreview.value = newVal.image_url ? '/' + newVal.image_url : null
  } else {
    form.reset()
    imagePreview.value = null
  }
})

function onImageChange(e) {
  const file = e.target.files[0]
  form.image = file
  if (file) {
    const reader = new FileReader()
    reader.onload = ev => {
      imagePreview.value = ev.target.result
    }
    reader.readAsDataURL(file)
  } else {
    imagePreview.value = null
  }
}

function submit() {
  if (props.product && props.product.id) {
    form.put(route('productos.update', props.product.id), {
      forceFormData: true,
      onSuccess: () => {
        emit('updated')
        emit('close')
        if (props.onSuccess) props.onSuccess()
      },
      onError: () => {},
    })
  } else {
    form.post(route('productos.store'), {
      forceFormData: true,
      onSuccess: () => {
        form.reset()
        imagePreview.value = null
        emit('created')
        emit('close')
        if (props.onSuccess) props.onSuccess()
      },
      onError: () => {}
    })
  }
}
</script>

<template>
  <div class="p-6 max-w-lg mx-auto bg-card rounded-xl">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
      <ImagePlus class="w-6 h-6 text-primary" /> {{ props.product ? 'Editar Producto' : 'Nuevo Producto' }}
    </h2>
    <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">
      <div>
        <label class="block text-sm font-semibold mb-1">Nombre</label>
        <input v-model="form.name" type="text" class="input input-bordered w-full" required placeholder="Nombre del producto" />
        <span v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</span>
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1">Descripción</label>
        <textarea v-model="form.description" class="input input-bordered w-full" placeholder="Descripción"></textarea>
        <span v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</span>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold mb-1">Precio</label>
          <input v-model.number="form.price" type="number" step="0.01" class="input input-bordered w-full" required placeholder="0" />
          <span v-if="form.errors.price" class="text-red-500 text-xs">{{ form.errors.price }}</span>
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Puntos</label>
          <input v-model.number="form.points" type="number" class="input input-bordered w-full" required placeholder="0" />
          <span v-if="form.errors.points" class="text-red-500 text-xs">{{ form.errors.points }}</span>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold mb-1">Tamaño</label>
          <input v-model="form.size" type="text" class="input input-bordered w-full" placeholder="Ej: 45 cm" />
          <span v-if="form.errors.size" class="text-red-500 text-xs">{{ form.errors.size }}</span>
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Estado</label>
          <input v-model="form.state" type="text" class="input input-bordered w-full" placeholder="Ej: Nuevo" />
          <span v-if="form.errors.state" class="text-red-500 text-xs">{{ form.errors.state }}</span>
        </div>
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1">Imagen</label>
        <div class="flex items-center gap-4">
          <input type="file" @change="onImageChange" accept="image/*" class="input input-bordered w-full" />
          <div v-if="form.processing">
            <Loader2 class="animate-spin w-6 h-6 text-primary" />
          </div>
        </div>
        <div v-if="imagePreview" class="mt-2">
          <img :src="imagePreview" alt="preview" class="w-24 h-24 object-cover rounded border" />
        </div>
        <span v-if="form.errors.image" class="text-red-500 text-xs">{{ form.errors.image }}</span>
      </div>
      <div class="flex justify-end gap-2 mt-8">
        <button type="button" class="btn btn-ghost" @click="$emit('close')">Cancelar</button>
        <button type="submit" class="btn btn-primary flex items-center gap-2" :disabled="form.processing">
          <Loader2 v-if="form.processing" class="animate-spin w-4 h-4" />
          Guardar
        </button>
      </div>
    </form>
  </div>
</template> 