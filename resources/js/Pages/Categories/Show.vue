<script setup>
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    category: {
        type: Object,
        required: true
    }
});

const goBack = () => {
    router.get('/categories');
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Detalle de categoría" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de categoría
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-4">
                            <button
                                type="button"
                                class="text-sm text-gray-600 hover:text-gray-800 underline"
                                @click="goBack"
                            >
                                Volver al listado
                            </button>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">
                                Información de la categoría
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="font-medium text-gray-700">ID</p>
                                    <p class="text-gray-900">{{ category.id }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Nombre</p>
                                    <p class="text-gray-900">{{ category.name }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Slug</p>
                                    <p class="text-gray-900">{{ category.slug }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Estado</p>
                                    <p class="text-gray-900">
                                        {{ category.estado ? 'Activa' : 'Inactiva' }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="font-medium text-gray-700">Descripción</p>
                                    <p class="text-gray-900">
                                        {{ category.description || 'Sin descripción' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-2">
                                Registros asociados
                            </h3>

                            <p class="text-sm text-gray-600 mb-3">
                                Total asociados: {{ category.phones ? category.phones.length : 0 }}
                            </p>

                            <div v-if="category.phones && category.phones.length > 0" class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="text-left p-2">ID</th>
                                            <th class="text-left p-2">Nombre</th>
                                            <th class="text-left p-2">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="phone in category.phones"
                                            :key="phone.id"
                                            class="border-b hover:bg-gray-50"
                                        >
                                            <td class="p-2">{{ phone.id }}</td>
                                            <td class="p-2">
                                                {{ phone.name || phone.title || 'Sin nombre' }}
                                            </td>
                                            <td class="p-2">
                                                <span
                                                    v-if="typeof phone.estado !== 'undefined'"
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs"
                                                    :class="phone.estado ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                                >
                                                    {{ phone.estado ? 'Activo' : 'Inactivo' }}
                                                </span>
                                                <span v-else class="text-xs text-gray-500">
                                                    N/A
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div v-else class="text-sm text-gray-500">
                                No hay registros asociados a esta categoría.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
