<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed } from "vue";

const props = defineProps({
    patient: Object
})

console.log(props.patient)

const firstName = computed(() => {
    return props.patient.name.split(' ')[0]
})
</script>

<template>
    <Head title="Dados do Paciente" />
    <BreezeAuthenticatedLayout>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="overflow-hidden bg-white md:max-w-5xl md:mt-10 md:mx-auto shadow sm:rounded-lg">
            <div class="px-4 py-5 bg-red-100 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Informações do/a paciente {{ firstName }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Dados pessoais</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ patient.name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{  patient.birthday }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Idade</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{  patient.age }} anos</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">E-mail</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ patient.email }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
