<template>
    <div class="bg-white pt-14 pb-14">
        <div class="flex flex-wrap justify-center text-center mb-10">
            <div class="w-full lg:w-6/12 px-4">
                <h2 class="text-4xl font-semibold">
                    {{ blogTitle.title }}
                </h2>
                <p
                    class="text-lg leading-relaxed text-gray-600"
                    v-html="blogTitle.description"
                ></p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-5">
            <div
                v-for="(blog, index) in blogItem"
                :key="index"
                class="block rounded-lg shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700"
            >
                <a href="#" @click="readBlog(blog.id)">
                    <img class="rounded-t-lg" :src="blog.image" />
                    <div class="p-6">
                        <h5
                            class="mb-2 text-xl font-bold leading-tight text-neutral-800 dark:text-neutral-50"
                        >
                            {{ blog.title }}
                        </h5>
                        <p
                            class="mb-4 text-base text-neutral-600 dark:text-neutral-200"
                        >
                            {{ blog.description }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="text-center">
            <a
                :href="route('menu.blog')"
                class="inline-block rounded-full text-xl font-semibold leading-normal text-blue-500 transition duration-150 ease-in-out hover:underline focus:outline-none focus:ring-0 active:text-blue-500"
            >
                See all articles
            </a>
        </div>
    </div>
</template>

<script>
import { Ripple, initTE } from "tw-elements";
import { Inertia } from "@inertiajs/inertia";
export default {
    props: {
        blogTitle: {
            type: Object,
            default: () => ({}),
        },
        blogItem: {
            type: Object,
            default: () => ({}),
        },
    },
    methods: {
        readBlog(id) {
            Inertia.get(route("public.readBlog", id));
        },
    },
    mounted() {
        // Call the initTE function to initialize the "tw-elements" library
        initTE({ Ripple });
        this.blogItem.forEach((item) => {
            item.description =
                item.description.replace(/<[^>]+>/g, "").slice(0, 255) + "...";
        });
    },
};
</script>
