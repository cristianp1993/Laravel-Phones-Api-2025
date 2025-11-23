<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalPhones: 0,
            totalCategories: 0,
        }),
    },
    topCategories: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <AppLayout title="Dashboard">
        <Head title="Dashboard" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm text-gray-500">Teléfonos registrados</p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ props.stats.totalPhones }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm text-gray-500">Categorías</p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ props.stats.totalCategories }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex flex-col justify-between h-full">
                            <div>
                                <p class="text-sm text-gray-500 mb-2">
                                    Gestión de categorías
                                </p>
                                <p class="text-xs text-gray-400 mb-4">
                                    Desde aquí puedes ir al listado completo de categorías.
                                </p>
                            </div>
                            <div class="mt-auto">
                                <Link
                                    :href="route('categories.index')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Ver categorías
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Categorías con más teléfonos
                        </h3>

                        <div v-if="props.topCategories.length">
                            <ul class="divide-y divide-gray-200">
                                <li
                                    v-for="category in props.topCategories"
                                    :key="category.id"
                                    class="py-3 flex items-center justify-between"
                                >
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ category.name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            ID: {{ category.id }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-indigo-50 text-indigo-700">
                                        {{ category.phones_count }} teléfonos
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <p v-else class="text-sm text-gray-500">
                            Aún no hay categorías con teléfonos registrados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
