<template>
    <section class="relative pt-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="items-center flex flex-wrap">
                <div class="w-full md:w-4/12 ml-auto mr-auto px-4">
                    <img
                        class="max-w-full rounded-lg shadow-lg"
                        :src="ourMissionData.image"
                    />
                </div>
                <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
                    <div class="md:pr-12 mt-6 md:mt-0">
                        <div
                            class="text-blue-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-blue-300"
                        >
                            <i class="fas fa-rocket text-xl"></i>
                        </div>
                        <h3 class="text-3xl font-semibold">
                            {{ ourMissionData.title }}
                        </h3>
                        <p class="mt-4 text-lg leading-relaxed text-gray-600" v-html="ourMissionData.description">
                        </p>
                        <!-- <ul class="list-none mt-6">
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                                        >
                                            <i class="fas fa-fingerprint"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-600">
                                            Carefully crafted components
                                        </h4>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                                        >
                                            <i class="fab fa-html5"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-600">
                                            Amazing page examples
                                        </h4>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                                        >
                                            <i class="far fa-paper-plane"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-600">
                                            Dynamic components
                                        </h4>
                                    </div>
                                </div>
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        ourMissionData: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
