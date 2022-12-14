<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/components/InputLabel.vue';
import BreezeInput from '@/components/TextInput.vue';
import BreezeInputError from '@/components/InputError.vue';
import BreezeButton from '@/Components/PrimaryButton.vue'
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import { useAlerts } from "@/Composables/useAlerts";
import { computed, ref } from "vue";

const form = useForm({
    name: '',
    dob: '',
    email: '',
    zipcode: '',
    street: '',
    region: '',
    city: ''
})

let placeholderText = ref('')

const fillAddress = async () => {
    if(form.zipcode.length === 8) {
        placeholderText.value = 'Pesquisando CEP...'
        const resp = await axios.get(`https://viacep.com.br/ws/${form.zipcode}/json/`)
        if(resp.data.erro) {
            placeholderText.value = ''
            let alert = useAlerts('Aviso', 'Nenhum endereço foi retornado, verifique se o seu CEP foi digitado corretamente e tente novamente', 'warning')
            alert
        } else {
            placeholderText.value = ''
            form.street = resp.data.logradouro
            form.region = resp.data.bairro
            form.city = resp.data.localidade
        }
    }
}

const onlyNumber = (e) => {
    let keyCodes = [8,9,37,39,46,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105]
    if (! keyCodes.includes(e.keyCode)) {
        e.preventDefault();
    }
}

const successMessage = computed(() => usePage().props.value.flash.success)

const submit = () => {
    form.post(route('patient.store'), {
        onSuccess: () => {
            form.reset()
            let alert = useAlerts('Sucesso', successMessage.value, 'success')
            alert
        },
        onError: (errors) => {
            if(errors.create) {
                let alert = useAlerts('Erro', errors.create, 'error')
                alert
            }
        }
    });
};
</script>

<template>
    <Head title="Novo Cadastro" />

    <BreezeAuthenticatedLayout>
        <form @submit.prevent="submit">
            <div class="mt-10 px-2 md:px-8">
                <!-- Personal Information -->
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informações Pessoais</h3>
                            <p class="mt-1 text-sm text-gray-600">Informações do Paciente</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-8 gap-4">
                                    <div class="col-span-8 sm:col-span-6">
                                        <BreezeLabel for="name" value="Nome" />
                                        <BreezeInput id="name"
                                                     type="text"
                                                     class="mt-1 block w-full"
                                                     v-model="form.name"
                                                     autofocus
                                                     autocomplete="name" />
                                        <BreezeInputError class="mt-2" :message="form.errors.name" />
                                    </div>

                                    <div class="col-span-8 sm:col-span-2">
                                        <BreezeLabel for="dob" value="Data de Nascimento" />
                                        <BreezeInput id="dob"
                                                     type="date"
                                                     class="mt-1 block w-full"
                                                     v-model="form.dob"
                                                     autocomplete="dob" />
                                        <BreezeInputError class="mt-2" :message="form.errors.dob" />
                                    </div>

                                    <div class="col-span-8 sm:col-span-6">
                                        <BreezeLabel for="email" value="E-mail" />
                                        <BreezeInput id="email"
                                                     type="email"
                                                     class="mt-1 block w-full"
                                                     v-model="form.email"
                                                     autocomplete="email" />
                                        <BreezeInputError class="mt-2" :message="form.errors.email" />
                                    </div>
                                </div>
                            </div>
                            <div class="sm:border-t sm:border-gray-300"></div>
                        </div>
                    </div>
                </div>
                <!-- /Personal Information -->

                <!-- Address Information -->
                <div class="md:grid md:grid-cols-3 md:gap-6 mt-10 md:mt-0">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Endereço residencial</h3>
                            <p class="mt-1 text-sm text-gray-600">O campo de CEP pode ser usado para pesquisar o endereço. Digite os 8 dígitos do CEP e pressione a tecla TAB ou clique fora do input para que o CEP seja pesquisado automaticamente quando houver acesso à internet</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-8 gap-4">
                                    <div class="col-span-8 sm:col-span-2">
                                        <BreezeLabel for="cep" value="Cep" />
                                        <BreezeInput id="cep"
                                                     type="text"
                                                     maxlength="8"
                                                     placeholder="12345678"
                                                     @keydown="onlyNumber"
                                                     class="mt-1 block w-full"
                                                     v-model="form.zipcode"
                                                     @blur="fillAddress"
                                                     autocomplete="zipcode" />
                                        <BreezeInputError class="mt-2" :message="form.errors.zipcode" />
                                    </div>

                                    <div class="col-span-8 sm:col-span-6">
                                        <BreezeLabel for="street" value="Logradouro" />
                                        <BreezeInput id="street"
                                                     type="text"
                                                     class="mt-1 block w-full"
                                                     :placeholder=placeholderText
                                                     v-model="form.street"
                                                     autocomplete="street" />
                                        <BreezeInputError class="mt-2" :message="form.errors.street" />
                                    </div>

                                    <div class="col-span-8 sm:col-span-4">
                                        <BreezeLabel for="region" value="Bairro" />
                                        <BreezeInput id="region"
                                                     type="text"
                                                     class="mt-1 block w-full"
                                                     :placeholder=placeholderText
                                                     v-model="form.region"
                                                     autocomplete="region" />
                                        <BreezeInputError class="mt-2" :message="form.errors.region" />
                                    </div>

                                    <div class="col-span-8 sm:col-span-4">
                                        <BreezeLabel for="city" value="Cidade" />
                                        <BreezeInput id="city"
                                                     type="text"
                                                     class="mt-1 block w-full"
                                                     :placeholder=placeholderText
                                                     v-model="form.city"
                                                     autocomplete="city" />
                                        <BreezeInputError class="mt-2" :message="form.errors.city" />
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                <BreezeButton :class="{ 'opacity-25': form.processing }"
                                              :disabled="form.processing">
                                    Salvar
                                </BreezeButton>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Address information -->
            </div>
        </form>
    </BreezeAuthenticatedLayout>
</template>
