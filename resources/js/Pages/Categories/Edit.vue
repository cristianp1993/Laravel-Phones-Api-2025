<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    category: {
        type: Object,
        required: true
    }
});

const page = usePage();

const form = useForm({
    name: props.category.name || '',
    description: props.category.description || '',
    estado: props.category.estado ?? true,
    position: props.category.position ?? ''
});

const submit = () => {
    form.clearErrors();

    if (!form.name || form.name.length < 3) {
        form.setError('name', 'El nombre es obligatorio y debe tener al menos 3 caracteres.');
    }

    if (Object.keys(form.errors).length > 0) {
        return;
    }

    form.put(`/categories/${props.category.id}`);
};

const goBack = () => {
    router.get('/categories');
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Editar categoría" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar categoría
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

                        <div
                            v-if="page.props.flash && page.props.flash.success"
                            class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 px-3 py-2 rounded"
                        >
                            {{ page.props.flash.success }}
                        </div>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nombre
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full border rounded px-3 py-2 text-sm"
                                />
                                <div v-if="form.errors.name" class="text-xs text-red-600 mt-1">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Descripción
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    class="w-full border rounded px-3 py-2 text-sm"
                                />
                                <div v-if="form.errors.description" class="text-xs text-red-600 mt-1">
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Estado
                                    </label>
                                    <select
                                        v-model="form.estado"
                                        class="border rounded px-3 py-2 text-sm"
                                    >
                                        <option :value="true">Activa</option>
                                        <option :value="false">Inactiva</option>
                                    </select>
                                    <div v-if="form.errors.estado" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.estado }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Posición
                                    </label>
                                    <input
                                        v-model="form.position"
                                        type="number"
                                        class="border rounded px-3 py-2 text-sm w-24"
                                    />
                                    <div v-if="form.errors.position" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.position }}
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded shadow hover:bg-indigo-700 disabled:opacity-50"
                                    :disabled="form.processing"
                                >
                                    Actualizar categoría
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
