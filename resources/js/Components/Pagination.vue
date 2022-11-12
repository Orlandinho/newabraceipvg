<script setup>
import {
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    ChevronLeftIcon,
    ChevronRightIcon
} from '@heroicons/vue/20/solid'
import { Link } from "@inertiajs/inertia-vue3"
import { computed, ref } from "vue";

const props = defineProps({
    linkData: Object,
    filters: Object
})

const limit = ref(props.linkData.current_page)

const pages = computed(() => {
    const totalPages = props.linkData.links.length - 2
    let currentPage = props.linkData.current_page
    if ([1, 2].includes(currentPage)) currentPage = 3;
    else if ([totalPages -1, totalPages].includes(currentPage)) currentPage = totalPages - Math.trunc(5 / 2);

    return [...Array(5).keys()].map(i => i - Math.trunc(5 / 2) + currentPage)
})

</script>

<template>
    <div class="flex items-center justify-between border border-gray-200 bg-white rounded-lg px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link :href="props.linkData.prev_page_url"
                  v-if="props.linkData.prev_page_url"
                  class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</Link>
            <Link :href="props.linkData.next_page_url"
                  v-if="props.linkData.next_page_url"
                  class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</Link>
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
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" v-show="props.linkData.last_page > 1" aria-label="Pagination">
                    <Link as="button"
                          type="button"
                          :disabled="props.linkData.current_page === 1"
                          :href="props.linkData.first_page_url"
                          class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-red-500 focus:z-20">
                        1
                    </Link>
                    <Link as="button"
                          type="button"
                          :disabled="props.linkData.current_page === 1"
                          :href="linkData.links[0].url"
                          v-html="linkData.links[0].label"
                          class="relative inline-flex items-center border px-2 py-2 text-sm font-medium focus:z-20 bg-white border-gray-300 text-gray-500 hover:bg-gray-200">
                    </Link>
                    <span class="relative inline-flex items-center border px-2 py-2 text-sm font-medium focus:z-20 bg-white border-gray-300 text-gray-500"
                          v-show="props.linkData.current_page > 3">
                        ...
                    </span>
                    <template v-for="(t, index) in linkData.links.length - 2" :key="index">
                        <Link as="button"
                              type="button"
                              v-show="Math.abs(props.linkData.links[index + 1].label - limit) < 3"
                              :href="linkData.links[index + 1].url"
                              v-html="linkData.links[index + 1].label"
                              class="relative inline-flex items-center border px-2 py-2 text-sm font-medium focus:z-20"
                              :class="linkData.links[index + 1].active ? 'z-10 hover:bg-grey-100 border-red-300 text-red-500 font-bold' : 'bg-white border-gray-300 text-gray-500 hover:bg-red-100'">
                        </Link>
                    </template>
                    <span class="relative inline-flex items-center border px-2 py-2 text-sm font-medium focus:z-20 bg-white border-gray-300 text-gray-500"
                          v-show="(props.linkData.current_page + 2) < props.linkData.last_page">
                        ...
                    </span>
                    <Link as="button"
                          type="button"
                          :disabled="props.linkData.current_page === props.linkData.last_page"
                          :href="linkData.links[props.linkData.links.length - 1].url"
                          v-html="linkData.links[props.linkData.links.length - 1].label"
                          class="relative inline-flex items-center border px-2 py-2 text-sm font-medium focus:z-20 bg-white border-gray-300 text-gray-500 hover:bg-gray-200">
                    </Link>
                    <Link as="button"
                          type="button"
                          :disabled="props.linkData.current_page === props.linkData.last_page"
                          :href="props.linkData.last_page_url"
                          class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-red-500 focus:z-20">
                        {{ props.linkData.last_page }}
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>
