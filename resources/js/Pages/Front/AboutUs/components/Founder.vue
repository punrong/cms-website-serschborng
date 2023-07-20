<template>
    <section class="relative pt-20 pb-20 bg-white">
        <div class="mx-auto px-4">
            <div class="items-center flex flex-wrap">
                <div class="w-full md:w-4/12 ml-auto mr-auto px-4">
                    <img
                        class="max-w-full rounded-lg shadow-lg"
                        :src="ourFounder.image"
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
                            {{ ourFounder.title }}
                        </h3>
                        <p
                            class="mt-4 text-lg leading-relaxed text-gray-600 founder-component"
                            v-html="ourFounder.description"
                        ></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        ourFounder: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
<style>
.founder-component ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}
</style>
