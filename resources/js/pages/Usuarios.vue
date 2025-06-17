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
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Usuarios</h1>
    <p>Gestión de usuarios aquí.</p>
  </div>
</AppLayout>
</template> 