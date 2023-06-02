<template>
    <div
        class="relative pt-16 pb-32 flex content-center items-center justify-center"
        style="min-height: 75vh"
    >
        <div
            class="absolute top-0 w-full h-full bg-center bg-cover"
            :style="`background-image: url('${coverData.image}')`"
        >
            <span
                id="blackOverlay"
                class="w-full h-full absolute opacity-75 bg-black"
            ></span>
        </div>
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div
                    class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center mt-9 sm:mt-0"
                >
                    <div>
                        <h1 class="text-white font-semibold text-5xl">
                            {{ coverData.title }}
                        </h1>
                        <p
                            class="mt-4 text-lg text-gray-300"
                            v-html="coverData.description"
                        ></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        coverData: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
