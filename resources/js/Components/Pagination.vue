<script setup>
import { ChevronLeftIcon, ChevronRightIcon, ChevronDoubleRightIcon, ChevronDoubleLeftIcon } from '@heroicons/vue/20/solid'
import { Link } from "@inertiajs/inertia-vue3"
import { computed } from "vue";

const props = defineProps({
    linkData: Object
})

const pages = computed(() => {
    const totalPages = props.linkData.last_page
    let currentPage = props.linkData.current_page
    if ([1, 2].includes(currentPage)) currentPage = 3;
    else if ([totalPages -1, totalPages].includes(currentPage)) currentPage = totalPages - Math.trunc(5 / 2);

    return [...Array(5).keys()].map(i => i - Math.trunc(5 / 2) + currentPage)
})

console.log(pages)

</script>

<template>
    <div class="flex items-center justify-between border border-gray-200 bg-white rounded-lg px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link :href="props.linkData.prev_page_url" v-if="props.linkData.prev_page_url" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</Link>
            <Link :href="props.linkData.next_page_url" v-if="props.linkData.next_page_url" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Exibindo de
                    <span class="font-medium">{{ props.linkData.from }}</span>
                    a
                    <span class="font-medium">{{ props.linkData.to }}</span>
                    pacientes de um total de
                    <span class="font-medium">{{ props.linkData.total}}</span>
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" v-if="props.linkData.last_page > 1" aria-label="Pagination">
                    <Link as="button" type="button" :disabled="props.linkData.current_page === 1" :href="props.linkData.first_page_url" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                        <ChevronDoubleLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </Link>
                    <Link as="button" type="button" :disabled="props.linkData.current_page === 1" :href="props.linkData.prev_page_url" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </Link>
                    <template v-for="(page, index) in pages" :key="index">
                        <Link v-show="page <= props.linkData.last_page"
                              :href="`http://localhost:8000/patient?page=${page}`"
                              v-text="page"
                              class="relative inline-flex items-center border px-2 py-2 text-sm font-medium focus:z-20"
                              :class="props.linkData.current_page === page ? 'z-10 hover:bg-red-100 border-red-300 text-red-500' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-100'">
                        </Link>
                    </template>
                    <Link as="button" type="button" :disabled="props.linkData.current_page === props.linkData.last_page" :href="props.linkData.next_page_url" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-red-500 focus:z-20">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </Link>
                    <Link as="button" type="button" :disabled="props.linkData.current_page === props.linkData.last_page" :href="props.linkData.last_page_url" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-red-500 focus:z-20">
                        <span class="sr-only">Next</span>
                        <ChevronDoubleRightIcon class="h-5 w-5" aria-hidden="true" />
                    </Link>
                </nav>

                <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                <!-- <span class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">...</span> -->
<!--                 <a href="#" aria-current="page" class="relative z-10 inline-flex items-center border border-indigo-500 bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-600 focus:z-20">1</a>
                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">2</a>
                <a href="#" class="relative hidden items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20 md:inline-flex">3</a>

                <a href="#" class="relative hidden items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20 md:inline-flex">8</a>
                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">9</a>
                <a href="#" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">10</a>
                <Link :href="props.links.next_page_url" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                    <span class="sr-only">Next</span>
                    <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                </Link> -->
            </div>
        </div>
    </div>
</template>
