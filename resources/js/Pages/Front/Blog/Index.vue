<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="blogCover" :cover="this.blogCover" />
            <div class="bg-white pt-14 pb-14">
                <div
                    v-if="blogPageTitle"
                    class="flex flex-wrap justify-center text-center mb-10"
                >
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold">
                            {{ blogPageTitle.title }}
                        </h2>
                        <p
                            class="text-lg leading-relaxed text-gray-600"
                            v-html="blogPageTitle.description"
                        ></p>
                    </div>
                </div>
                <div
                    v-if="blogItem"
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-5"
                >
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
                <Pagination :data="blogs" />
            </div>
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
    </div>
</template>

<script>
import axios from "axios";
import Carousel from "../components/Carousel.vue";
import NavigationBar from "../components/NavigationBar.vue";
import Footer from "../components/Footer.vue";
import Pagination from "../components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
    name: "App",
    components: {
        Carousel,
        Pagination,
        NavigationBar,
        Footer,
    },
    props: {
        blogs: {
            type: Object,
            default: () => ({}),
        },
        blogCover: {
            type: Object,
            default: () => ({}),
        },
        blogPageTitle: {
            type: Object,
            default: () => ({}),
        }
    },
    data() {
        return {
            pageSetting: null,
            blogItem: null,
            activeMenu: "blog",
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        readBlog(id) {
            Inertia.get(route("public.readBlog", id));
        },
    },
    mounted() {
        this.getPageSetting();
        this.blogItem = this.blogs.data;
        this.blogItem.forEach((item) => {
            item.description =
                item.description.replace(/<[^>]+>/g, "").slice(0, 255) + "...";
        });
    },
};
</script>
