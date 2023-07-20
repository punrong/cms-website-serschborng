<template>
    <section class="p-14 bg-gray-300">
        <div class="mx-auto px-4">
            <div class="flex flex-wrap justify-center">
                <div class="w-full px-4">
                    <h2 class="text-4xl font-semibold text-center">
                        {{ ourStory.title }}
                    </h2>
                    <p
                        class="text-lg leading-relaxed m-4 text-gray-600"
                        v-html="ourStory.description"
                    ></p>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        ourStory: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
