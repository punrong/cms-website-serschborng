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
            <div class="flex flex-wrap items-center mt-32">
                <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                    <div
                        class="text-gray-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-gray-100"
                    >
                        <i class="fas fa-user-friends text-xl"></i>
                    </div>
                    <h3 class="text-3xl mb-2 font-semibold leading-normal">
                        Working with us is a pleasure
                    </h3>
                    <p
                        class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700"
                    >
                        Don't let your uses guess by attaching tooltips and
                        popoves to any element. Just make sure you enable them
                        first via JavaScript.
                    </p>
                    <p
                        class="text-lg font-light leading-relaxed mt-0 mb-4 text-gray-700"
                    >
                        The kit comes with three pre-built pages to help you get
                        started faster. You can change the text and images and
                        you're good to go. Just make sure you enable them first
                        via JavaScript.
                    </p>
                    <a
                        href="https://www.creative-tim.com/framework/tailwind-starter-kit"
                        class="font-bold text-gray-800 mt-8"
                        target="_blank"
                        >Check Tailwind Starter Kit!</a
                    >
                </div>
                <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-blue-600 w-full mb-6 shadow-lg rounded-lg"
                    >
                        <img
                            alt="..."
                            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1051&amp;q=80"
                            class="w-full align-middle rounded-t-lg"
                        />
                        <blockquote class="relative p-8 mb-4">
                            <svg
                                preserveAspectRatio="none"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 583 95"
                                class="absolute left-0 w-full block"
                                style="height: 95px; top: -94px"
                            >
                                <polygon
                                    points="-30,95 583,95 583,65"
                                    class="fill-current text-blue-600"
                                ></polygon>
                            </svg>
                            <h4 class="text-xl font-bold text-white">
                                Top Notch Services
                            </h4>
                            <p class="text-md font-light mt-2 text-white">
                                The Arctic Ocean freezes every winter and much
                                of the sea-ice then thaws every summer, and that
                                process will continue whatever happens.
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
    },
    components: {
        InputError,
    },
};
</script>
