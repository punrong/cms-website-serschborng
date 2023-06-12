<template>
    <div
        class="relative pt-16 pb-32 flex w-full content-center items-center justify-center"
        style="min-height: 75vh"
    >
        <div
            class="absolute top-0 w-full h-full bg-center bg-cover"
            :style="`background-image: url('${blog.image}')`"
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
                            {{ blog.title }}
                        </h1>
                        <p class="mt-4 text-lg text-gray-300">
                            Author: {{ blog.publisher }}
                        </p>
                        <p class="text-lg text-gray-300">
                            Published Date: {{ blog.publish_date }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        blog: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
