<template>
    <section class="pb-20 relative block bg-gray-900">
        <div class="mx-auto px-4 lg:pt-24 lg:pb-64">
            <div class="flex flex-wrap text-center justify-center">
                <div class="w-full lg:w-6/12 px-4">
                    <h2 class="text-4xl font-semibold text-white mt-5">
                        {{ ourServiceTitle.title }}
                    </h2>
                    <p
                        class="text-lg leading-relaxed mt-4 mb-4 text-gray-500"
                        v-html="ourServiceTitle.description"
                    ></p>
                </div>
            </div>
            <div class="flex flex-wrap mt-12 mb-12 sm:mb-0 justify-center">
                <div
                    v-for="(ourService, index) in ourServiceItem"
                    :key="index"
                    class="w-full lg:w-3/12 px-4 text-center"
                >
                    <div class="p-3 inline-flex items-center justify-center">
                        <img :src="ourService.image" class="h-20" />
                    </div>
                    <h6 class="text-xl mt-5 font-semibold text-white">
                        {{ ourService.title }}
                    </h6>
                    <p
                        class="mt-2 mb-4 text-gray-500"
                        v-html="ourService.description"
                    ></p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        ourServiceTitle: {
            type: Object,
            default: () => ({}),
        },
        ourServiceItem: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
