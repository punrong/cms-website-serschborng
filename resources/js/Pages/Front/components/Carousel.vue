<template>
    <div
        class="relative pt-16 pb-32 flex content-center items-center justify-center"
        style="min-height: 75vh"
    >
        <div
            class="absolute top-0 w-full h-full bg-center bg-cover"
            :style="`background-image: url('${cover.image}')`"
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
                            {{ cover.title }}
                        </h1>
                        <p
                            class="mt-4 text-lg text-gray-300"
                            v-html="cover.description"
                        ></p>
                        <FormKit
                            v-if="hasCoverBtn"
                            type="button"
                            @click='$emit("coverBtnClicked")'
                            :label="coverBtnLabel"
                            :classes="{
                                outer: 'm-0 text-center mt-5',
                                input: 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white text-xl font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mb-14',
                            }"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        cover: {
            type: Object,
            default: () => ({}),
        },
        hasCoverBtn: {
            type: Boolean,
            default: false,
        },
        coverBtnLabel: {
            type: String,
            default: '',
        }
    },
};
</script>
