<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="blog" :blog="this.blog" />
            <div v-if="blog" class="bg-white pt-14 pb-14">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="text-center">
                            <h2 class="text-4xl font-semibold">
                                {{ blog.title }}
                            </h2>
                            <p class="mt-4 text-lg text-gray-500">
                                Author: {{ blog.publisher }}
                            </p>
                            <p class="text-lg text-gray-500">
                                Published Date: {{ blog.publish_date }}
                            </p>
                        </div>
                        <p
                            class="mt-4 text-lg leading-relaxed text-gray-600 blog-content"
                            v-html="blog.description"
                        ></p>
                    </div>
                </div>
            </div>
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
    </div>
</template>

<script>
import axios from "axios";
import Carousel from "./components/Carousel.vue";
import NavigationBar from "../components/NavigationBar.vue";
import Footer from "../components/Footer.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
    name: "App",
    components: {
        NavigationBar,
        Carousel,
        Footer,
    },
    props: {
        blog: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
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
    },
};
</script>
<style>
.blog-content a {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    color: rgb(59 113 202 / var(--tw-text-opacity));
}
.blog-content a:hover {
    text-decoration: underline;
}
.blog-content ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.blog-content ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.blog-content h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
}

.blog-content h3 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2d3748;
}

.blog-content h4 {
    font-size: 1.125rem;
    font-weight: 1000;
    color: #2d3748;
}

.blog-content blockquote {
    position: relative;
    padding: 2rem;
    font-weight: 600;
}
</style>
