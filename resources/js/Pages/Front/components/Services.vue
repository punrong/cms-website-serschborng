<template>
    <section class="pb-20 relative block bg-gray-900">
        <div
            class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
            style="height: 80px; transform: translateZ(0px)"
        >
            <svg
                class="absolute bottom-0 overflow-hidden"
                xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="none"
                version="1.1"
                viewBox="0 0 2560 100"
                x="0"
                y="0"
            >
                <polygon
                    class="text-gray-900 fill-current"
                    points="2560 0 2560 100 0 100"
                ></polygon>
            </svg>
        </div>
        <div class="container mx-auto px-4 lg:pt-24 lg:pb-64">
            <div class="flex flex-wrap text-center justify-center">
                <div class="w-full lg:w-6/12 px-4">
                    <h2 class="text-4xl font-semibold text-white">
                        {{ ourServiceTitleData.title }}
                    </h2>
                    <p
                        class="text-lg leading-relaxed mt-4 mb-4 text-gray-500"
                        v-html="ourServiceTitleData.description"
                    ></p>
                </div>
            </div>
            <div class="flex flex-wrap mt-12 mb-12 sm:mb-0 justify-center">
                <div class="w-full lg:w-3/12 px-4 text-center">
                    <div class="p-3 inline-flex items-center justify-center">
                        <img :src="ourServiceItemData[0].image" class="h-20" />
                    </div>
                    <h6 class="text-xl mt-5 font-semibold text-white">
                        {{ ourServiceItemData[0].title }}
                    </h6>
                    <p
                        class="mt-2 mb-4 text-gray-500"
                        v-html="ourServiceItemData[0].description"
                    ></p>
                </div>
                <div class="w-full lg:w-3/12 px-4 text-center">
                    <div class="p-3 inline-flex items-center justify-center">
                        <img :src="ourServiceItemData[1].image" class="h-20" />
                    </div>
                    <h5 class="text-xl mt-5 font-semibold text-white">
                        {{ ourServiceItemData[1].title }}
                    </h5>
                    <p
                        class="mt-2 mb-4 text-gray-500"
                        v-html="ourServiceItemData[1].description"
                    ></p>
                </div>
                <div class="w-full lg:w-3/12 px-4 text-center">
                    <div class="p-3 inline-flex items-center justify-center">
                        <img :src="ourServiceItemData[2].image" class="h-20" />
                    </div>
                    <h5 class="text-xl mt-5 font-semibold text-white">
                        {{ ourServiceItemData[2].title }}
                    </h5>
                    <p
                        class="mt-2 mb-4 text-gray-500"
                        v-html="ourServiceItemData[2].description"
                    ></p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        ourServiceTitleData: {
            type: Object,
            default: () => ({}),
        },
        ourServiceItemData: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>

<style></style>
