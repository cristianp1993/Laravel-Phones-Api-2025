<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    phone: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const page = usePage();

const form = useForm({
    number: props.phone.number || '',
    country_code: props.phone.country_code || '',
    area_code: props.phone.area_code || '',
    type: props.phone.type || '',
    is_primary: props.phone.is_primary ?? false,
    extension: props.phone.extension || '',
    notes: props.phone.notes || '',
    category_id: props.phone.category_id || '',
    barcode: props.phone.barcode || '',
});

const submit = () => {
    form.clearErrors();

    if (!form.number || form.number.length < 3) {
        form.setError('number', 'El número es obligatorio y debe tener al menos 3 caracteres.');
    }
    if (!form.category_id) {
        form.setError('category_id', 'La categoría es obligatoria.');
    }

    if (Object.keys(form.errors).length > 0) {
        return;
    }

    form.put(`/phones/${props.phone.id}`);
};

const goBack = () => {
    router.get('/phones');
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Editar teléfono" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar teléfono
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
                                    Número
                                </label>
                                <input
                                    v-model="form.number"
                                    type="text"
                                    class="w-full border rounded px-3 py-2 text-sm"
                                />
                                <div v-if="form.errors.number" class="text-xs text-red-600 mt-1">
                                    {{ form.errors.number }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Código país
                                    </label>
                                    <input
                                        v-model="form.country_code"
                                        type="text"
                                        class="w-full border rounded px-3 py-2 text-sm"
                                    />
                                    <div v-if="form.errors.country_code" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.country_code }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Código área
                                    </label>
                                    <input
                                        v-model="form.area_code"
                                        type="text"
                                        class="w-full border rounded px-3 py-2 text-sm"
                                    />
                                    <div v-if="form.errors.area_code" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.area_code }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Extensión
                                    </label>
                                    <input
                                        v-model="form.extension"
                                        type="text"
                                        class="w-full border rounded px-3 py-2 text-sm"
                                    />
                                    <div v-if="form.errors.extension" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.extension }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tipo
                                    </label>
                                    <input
                                        v-model="form.type"
                                        type="text"
                                        class="w-full border rounded px-3 py-2 text-sm"
                                    />
                                    <div v-if="form.errors.type" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.type }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Principal
                                    </label>
                                    <select
                                        v-model="form.is_primary"
                                        class="w-full border rounded px-3 py-2 text-sm"
                                    >
                                        <option :value="true">Sí</option>
                                        <option :value="false">No</option>
                                    </select>
                                    <div v-if="form.errors.is_primary" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.is_primary }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Código de barras
                                    </label>
                                    <input
                                        v-model="form.barcode"
                                        type="text"
                                        class="w-full border rounded px-3 py-2 text-sm"
                                    />
                                    <div v-if="form.errors.barcode" class="text-xs text-red-600 mt-1">
                                        {{ form.errors.barcode }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Categoría
                                </label>
                                <select
                                    v-model="form.category_id"
                                    class="w-full border rounded px-3 py-2 text-sm"
                                >
                                    <option value="">Seleccione una categoría</option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.category_id" class="text-xs text-red-600 mt-1">
                                    {{ form.errors.category_id }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Notas
                                </label>
                                <textarea
                                    v-model="form.notes"
                                    rows="3"
                                    class="w-full border rounded px-3 py-2 text-sm"
                                />
                                <div v-if="form.errors.notes" class="text-xs text-red-600 mt-1">
                                    {{ form.errors.notes }}
                                </div>
                            </div>

                            <div class="pt-4">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded shadow hover:bg-indigo-700 disabled:opacity-50"
                                    :disabled="form.processing"
                                >
                                    Actualizar teléfono
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
