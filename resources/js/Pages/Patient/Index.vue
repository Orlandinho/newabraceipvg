<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from "@/Components/TextInput.vue"
import Pagination from "@/Components/Pagination.vue"
import HeadlessModalDialog from '@/Components/HeadlessModalDialog.vue'
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { TrashIcon, PencilSquareIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, watch } from "vue";
import { useAlerts } from "@/Composables/useAlerts";
import { Inertia } from "@inertiajs/inertia";
import { debounce } from "lodash";

const props = defineProps({
    patients: Object,
    filters: Object
})

const modal = ref(null)
let search = ref(props.filters.search)

const form = useForm()

const destroy = (id) => {
    form.delete(route('patient.destroy', id), {
        onSuccess: () => {
            let alert = useAlerts('Sucesso', usePage().props.value.flash.success, 'success')
            alert
        },
        onError: (errors) => {
            if(errors.create) {
                let alert = useAlerts('Erro', errors.create, 'error')
                alert
            }
        }
    })
}

watch(search, debounce(function(value) {
     Inertia.get('/patient', { search: value }, {
        preserveState: true,
        replace: true
    })
}, 300))

</script>

<template>
    <Head title="Lista de Pacientes" />
    <BreezeAuthenticatedLayout>
        <div class="flex flex-col px-2 md:max-w-5xl md:mx-auto md:mt-4">
            <div class="sm:flex sm:justify-between mb-2">
                <TextInput placeholder="Pesquisar pacientes" v-model="search" type="text" class="py-1 px-2 max-w-xs"/>
                <div class="flex items-center">
                    <Link :href="route('patient.create')">
                        <PlusCircleIcon class="h-8 w-8 text-indigo-600 hover:text-indigo-800"/>
                    </Link>
                    <p class="text-sm text-gray-700 ml-2">Cadastrar novo paciente</p>
                </div>
            </div>
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    nome
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    data nasc
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    idade
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    <span>Nova Consulta</span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    <span>Editar</span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    <span>Deletar</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(patient, index) in patients.data" :key="index" class="hover:bg-gray-200" :class="index % 2 === 1 ? 'bg-gray-100' : ''">
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <Link :href="route('patient.show', patient.id)" class="underline">{{ patient.name }}</Link>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ patient.birthday }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ patient.age }} anos
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 text-center whitespace-nowrap">
                                        <Link as="button" type="button" href="#">
                                            <PlusCircleIcon class="h-6 w-6 text-indigo-600 hover:text-indigo-800" />
                                        </Link>
                                    </td>
                                    <td class="px-6 py-2 text-center whitespace-nowrap">
                                        <Link as="button" type="button" :href="route('patient.edit', patient.id)">
                                            <PencilSquareIcon class="h-6 w-6 text-green-600 hover:text-green-800" />
                                        </Link>
                                    </td>

                                    <td class="px-6 py-2 text-center whitespace-nowrap">
                                        <button @click="modal.openModal(patient)">
                                            <TrashIcon class="h-6 w-6 text-red-500 hover:text-red-700"/>
                                        </button>
                                    </td>
                                </tr>
                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <Pagination class="mt-4" :filters="props.filters" :linkData="props.patients" />
        </div>
    </BreezeAuthenticatedLayout>
    <HeadlessModalDialog ref="modal" @confirmed="(patient) => destroy(patient.id)" />
</template>
