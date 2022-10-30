<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { TrashIcon, PencilSquareIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import HeadlessModalDialog from '@/Components/HeadlessModalDialog.vue'
import { ref } from "vue";
import { useAlerts } from "@/Composables/useAlerts";

const props = defineProps({
    patients: Object
})

const modal = ref(null)

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

</script>

<template>
    <Head title="Lista de Pacientes" />
    <BreezeAuthenticatedLayout>
        <div class="flex flex-col px-2 md:max-w-5xl md:mx-auto md:mt-10">
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
                                    nova consulta/editar/deletar
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="patient in patients" key="patient.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <Link :href="route('patient.show', patient.id)" class="underline">{{ patient.name }}</Link>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ patient.birthday }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ patient.age }} anos
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 flex justify-around">
                                        <Link href="#">
                                            <PlusCircleIcon class="h-6 w-6 text-indigo-600 hover:text-indigo-900" />
                                        </Link>
                                        <Link :href="route('patient.edit', patient.id)">
                                            <PencilSquareIcon class="h-6 w-6 text-green-600 hover:text-green-900" />
                                        </Link>
                                        <Link @click="modal.openModal(patient)" >
                                            <TrashIcon class="h-6 w-6 text-red-500 hover:text-red-700" />
                                        </Link>
                                    </td>
                                </tr>
                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
    <HeadlessModalDialog ref="modal" @confirmed="(patient) => destroy(patient.id)" />
</template>
