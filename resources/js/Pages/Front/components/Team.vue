<template>
    <section class="pt-16 pb-0 sm:pb-14 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center text-center mb-10">
                <div class="w-full lg:w-6/12 px-4">
                    <h2 class="text-4xl font-semibold">{{ ourHeroTitleData.title }}</h2>
                    <p class="text-lg leading-relaxed m-4 text-gray-600" v-html="ourHeroTitleData.description">
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center">
                <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                    <div class="px-6">
                        <img
                            :src="ourHeroItemData.image"
                            class="shadow-lg rounded-full max-w-full mx-auto"
                        />
                        <div class="pt-6 text-center">
                            <h5 class="text-xl font-bold">{{ ourHeroItemData.title }}</h5>
                            <p
                                class="mt-1 text-sm text-gray-500 uppercase font-semibold" v-html="ourHeroItemData.description"
                            >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        ourHeroTitleData: {
            type: Object,
            default: () => ({}),
        },
        ourHeroItemData: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
