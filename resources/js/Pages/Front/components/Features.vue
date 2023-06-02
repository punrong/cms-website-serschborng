<template>
    <section class="pb-20 bg-gray-300 -mt-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
                    >
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="p-3 text-center inline-flex items-center justify-center h-12 mt-5 mb-5"
                            >
                                <img :src="featureData[0].image" class="h-20" />
                            </div>
                            <h6 class="text-xl font-semibold">
                                {{ featureData[0].title }}
                            </h6>
                            <p
                                class="mt-2 mb-4 text-gray-600"
                                v-html="featureData[0].description"
                            ></p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-4/12 px-4 text-center">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
                    >
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="p-3 text-center inline-flex items-center justify-center h-12 mt-5 mb-5"
                            >
                                <img :src="featureData[1].image" class="h-20" />
                            </div>
                            <h6 class="text-xl font-semibold">
                                {{ featureData[1].title }}
                            </h6>
                            <p
                                class="mt-2 mb-4 text-gray-600"
                                v-html="featureData[1].description"
                            ></p>
                        </div>
                    </div>
                </div>
                <div class="pt-6 w-full md:w-4/12 px-4 text-center">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
                    >
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="p-3 text-center inline-flex items-center justify-center h-12 mt-5 mb-5"
                            >
                                <img :src="featureData[2].image" class="h-20" />
                            </div>
                            <h6 class="text-xl font-semibold">
                                {{ featureData[2].title }}
                            </h6>
                            <p
                                class="mt-2 mb-4 text-gray-600"
                                v-html="featureData[2].description"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-center mt-20">
                <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                    <div
                        class="text-gray-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-gray-100"
                    >
                        <i class="fas fa-user-friends text-xl"></i>
                    </div>
                    <h3 class="text-3xl mb-2 font-semibold leading-normal">
                        {{ aboutUsTextData.title }}
                    </h3>
                    <p
                        class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700"
                        v-html="aboutUsTextData.description"
                    ></p>
                </div>
                <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-blue-600 w-full mb-6 shadow-lg rounded-lg"
                    >
                        <img
                            :src="aboutUsCardData.image"
                            class="w-full align-middle rounded-t-lg"
                        />
                        <blockquote class="relative p-8 mb-4">
                            <h4 class="text-xl font-bold text-white">
                                {{ aboutUsCardData.title }}
                            </h4>
                            <p class="text-md font-light mt-2 text-white" v-html="aboutUsCardData.description">
                            </p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import InputError from "@/components/InputError.vue";
export default {
    props: {
        featureData: {
            type: Object,
            default: () => ({}),
        },
        aboutUsTextData: {
            type: Object,
            default: () => ({}),
        },
        aboutUsCardData: {
            type: Object,
            default: () => ({}),
        },
    },
    components: {
        InputError,
    },
};
</script>

<style scoped>
a {
}
</style>
