<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="opportunity" :opportunity="this.opportunity" />
            <div v-if="opportunity" class="bg-white pt-14 pb-14">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="text-center">
                            <h2 class="text-4xl font-semibold">
                                {{ opportunity.title }}
                            </h2>
                            <p class="mt-4 text-lg text-gray-500">
                                Author: {{ opportunity.publisher }}
                            </p>
                            <p class="text-lg text-gray-500">
                                Published Date: {{ opportunity.publish_date }}
                            </p>
                        </div>
                        <p
                            class="mt-4 text-lg leading-relaxed text-gray-600 opportunity-content"
                            v-html="opportunity.description"
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
        opportunity: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
            activeMenu: "opportunities",
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
.opportunity-content a {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    color: rgb(59 113 202 / var(--tw-text-opacity));
}
.opportunity-content a:hover {
    text-decoration: underline;
}
.opportunity-content ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.opportunity-content ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.opportunity-content h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
}

.opportunity-content h3 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2d3748;
}

.opportunity-content h4 {
    font-size: 1.125rem;
    font-weight: 1000;
    color: #2d3748;
}

.opportunity-content blockquote {
    position: relative;
    padding: 2rem;
    font-weight: 600;
}
</style>
