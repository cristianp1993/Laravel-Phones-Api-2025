<script setup>
import { Head, router, usePage, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    phones: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();

const search = ref(props.filters.search || '');
let timeout = null;

watch(search, (value) => {
    if (timeout) {
        clearTimeout(timeout);
    }

    timeout = setTimeout(() => {
        router.get(route('phones.index'), { search: value }, {
            preserveState: true,
            replace: true,
        });
    }, 400);
});

const toastVisible = ref(false);
const toastMessage = ref('');
const toastType = ref('success');
let toastTimeout = null;

const showToast = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    toastVisible.value = true;
    if (toastTimeout) {
        clearTimeout(toastTimeout);
    }
    toastTimeout = setTimeout(() => {
        toastVisible.value = false;
    }, 3000);
};

watch(
    () => page.props.flash,
    (flash) => {
        if (flash && flash.success) {
            showToast(flash.success, 'success');
        }
        if (flash && flash.error) {
            showToast(flash.error, 'error');
        }
    },
    { deep: true }
);

const goToCreate = () => {
    router.get('/phones/create');
};

const goToEdit = (phone) => {
    router.get(`/phones/${phone.id}/edit`);
};

const goToShow = (phone) => {
    router.get(`/phones/${phone.id}`);
};

const showDeleteModal = ref(false);
const phoneToDelete = ref(null);

const askDelete = (phone) => {
    phoneToDelete.value = phone;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    if (!phoneToDelete.value) return;

    router.delete(`/phones/${phoneToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            phoneToDelete.value = null;
        },
        onError: () => {
            showDeleteModal.value = false;
        },
    });
};

const cancelDelete = () => {
    showDeleteModal.value = false;
    phoneToDelete.value = null;
};
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Teléfonos" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listado de teléfonos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <input v-model="search" type="text" placeholder="Buscar por número..."
                                    class="border rounded px-3 py-2 text-sm" />
                            </div>
                           
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded shadow hover:bg-indigo-700"
                                @click="goToCreate">
                                Nuevo teléfono
                            </button>
                             <Link :href="route('dashboard')"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-xs font-semibold rounded shadow hover:bg-gray-700">
                            Ir al dashboard
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left p-2">ID</th>
                                        <th class="text-left p-2">Número</th>
                                        <th class="text-left p-2">Categoría</th>
                                        <th class="text-left p-2">Tipo</th>
                                        <th class="text-left p-2">Principal</th>
                                        <th class="text-left p-2">Código país</th>
                                        <th class="text-left p-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="phone in phones.data" :key="phone.id" class="border-b hover:bg-gray-50">
                                        <td class="p-2">{{ phone.id }}</td>
                                        <td class="p-2">
                                            <button type="button" class="text-indigo-600 hover:underline"
                                                @click="goToShow(phone)">
                                                {{ phone.number }}
                                            </button>
                                        </td>
                                        <td class="p-2">
                                            {{ phone.category ? phone.category.name : 'Sin categoría' }}
                                        </td>
                                        <td class="p-2">
                                            {{ phone.type || '—' }}
                                        </td>
                                        <td class="p-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs"
                                                :class="phone.is_primary ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'">
                                                {{ phone.is_primary ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="p-2">
                                            {{ phone.country_code || '—' }}
                                        </td>
                                        <td class="p-2 space-x-2">
                                            <button type="button" class="text-xs text-blue-600 hover:underline"
                                                @click="goToEdit(phone)">
                                                Editar
                                            </button>
                                            <button type="button" class="text-xs text-red-600 hover:underline"
                                                @click="askDelete(phone)">
                                                Eliminar
                                            </button>
                                            <button type="button" class="text-xs text-gray-600 hover:underline"
                                                @click="goToShow(phone)">
                                                Ver detalle
                                            </button>
                                        </td>
                                    </tr>

                                    <tr v-if="phones.data.length === 0">
                                        <td colspan="7" class="p-4 text-center text-gray-500">
                                            No hay teléfonos para mostrar.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <p class="text-xs text-gray-500">
                                Mostrando {{ phones.from || 0 }}-{{ phones.to || 0 }}
                                de {{ phones.total }} resultados
                            </p>

                            <div class="flex space-x-2">
                                <button v-for="link in phones.links" :key="link.label" type="button"
                                    class="px-3 py-1 border rounded text-xs" :class="{
                                        'bg-indigo-600 text-white': link.active,
                                        'text-gray-600 bg-white': !link.active,
                                        'opacity-50 cursor-not-allowed': !link.url,
                                    }" :disabled="!link.url"
                                    @click="link.url && router.get(link.url, {}, { preserveState: true })"
                                    v-html="link.label" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="toastVisible" class="fixed bottom-4 right-4 px-4 py-2 rounded shadow text-sm"
            :class="toastType === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'">
            {{ toastMessage }}
        </div>

        <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Eliminar teléfono
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    ¿Seguro que deseas eliminar el teléfono
                    <span class="font-semibold">
                        "{{ phoneToDelete?.number }}"
                    </span>
                    ?
                </p>
                <div class="flex justify-end space-x-2">
                    <button type="button"
                        class="px-4 py-2 text-sm rounded border border-gray-300 text-gray-700 hover:bg-gray-100"
                        @click="cancelDelete">
                        Cancelar
                    </button>
                    <button type="button" class="px-4 py-2 text-sm rounded bg-red-600 text-white hover:bg-red-700"
                        @click="confirmDelete">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
