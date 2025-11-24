<script setup>
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    phone: {
        type: Object,
        required: true,
    },
});

const goBack = () => {
    router.get('/phones');
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Detalle de teléfono" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de teléfono
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
                                Información del teléfono
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="font-medium text-gray-700">ID</p>
                                    <p class="text-gray-900">{{ phone.id }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Número</p>
                                    <p class="text-gray-900">{{ phone.number }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Categoría</p>
                                    <p class="text-gray-900">
                                        {{ phone.category ? phone.category.name : 'Sin categoría' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Tipo</p>
                                    <p class="text-gray-900">{{ phone.type || '—' }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Principal</p>
                                    <p class="text-gray-900">
                                        {{ phone.is_primary ? 'Sí' : 'No' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Código país</p>
                                    <p class="text-gray-900">{{ phone.country_code || '—' }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Código área</p>
                                    <p class="text-gray-900">{{ phone.area_code || '—' }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Extensión</p>
                                    <p class="text-gray-900">{{ phone.extension || '—' }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Código de barras</p>
                                    <p class="text-gray-900">{{ phone.barcode || '—' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="font-medium text-gray-700">Notas</p>
                                    <p class="text-gray-900">
                                        {{ phone.notes || 'Sin notas' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
