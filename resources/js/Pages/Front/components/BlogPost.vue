<template>
    <div class="bg-white pt-14 pb-14">
        <div class="flex flex-wrap justify-center text-center mb-10">
            <div class="w-full lg:w-6/12 px-4">
                <h2 class="text-4xl font-semibold">
                    {{ blogPostTitleData.title }}
                </h2>
                <p
                    class="text-lg leading-relaxed text-gray-600"
                    v-html="blogPostTitleData.description"
                ></p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-5">
            <div
                v-for="(blogPostItem, index) in blogPostItemData"
                :key="index"
                class="block rounded-lg shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700"
            >
                <a href="#!">
                    <img class="rounded-t-lg" :src="blogPostItem.image" />
                </a>
                <div class="p-6">
                    <h5
                        class="mb-2 text-xl font-bold leading-tight text-neutral-800 dark:text-neutral-50"
                    >
                        {{ blogPostItem.title }}
                    </h5>
                    <p
                        class="mb-4 text-base text-neutral-600 dark:text-neutral-200"
                    >
                        {{ blogPostItem.description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a
                href="#"
                class="inline-block rounded-full text-xl font-semibold leading-normal text-primary transition duration-150 ease-in-out hover:underline hover:text-primary-600 focus:text-primary-600 focus:outline-none focus:ring-0 active:text-primary-700"
            >
                See all articles
            </a>
        </div>
    </div>
</template>

<script>
import { Ripple, initTE } from "tw-elements";
export default {
    props: {
        blogPostTitleData: {
            type: Object,
            default: () => ({}),
        },
        blogPostItemData: {
            type: Object,
            default: () => ({}),
        },
    },
    mounted() {
        // Call the initTE function to initialize the "tw-elements" library
        initTE({ Ripple });
        this.blogPostItemData.forEach((item) => {
            item.description =
                item.description.replace(/<[^>]+>/g, "").slice(0, 255) + "...";
        });
    },
};
</script>
