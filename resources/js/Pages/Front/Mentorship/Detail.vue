<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="mentor" :mentor="this.mentor" />
            <div v-if="mentor" class="bg-white pt-14">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="text-center">
                            <h2 class="text-4xl font-semibold">
                                {{ mentor.name }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="mentor" class="bg-white pb-14">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <p
                            class="mt-4 text-lg leading-relaxed text-gray-600 mentorship-content"
                            v-html="mentor.description"
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
        mentor: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
            activeMenu: "mentorship",
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
    },
    mounted() {
        this.getPageSetting();
    },
};
</script>
<style>
.mentorship-content a {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    color: rgb(59 113 202 / var(--tw-text-opacity));
}
.mentorship-content a:hover {
    text-decoration: underline;
}
.mentorship-content ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.mentorship-content ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.mentorship-content h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
}

.mentorship-content h3 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2d3748;
}

.mentorship-content h4 {
    font-size: 1.125rem;
    font-weight: 1000;
    color: #2d3748;
}

.mentorship-content blockquote {
    position: relative;
    padding: 2rem;
    font-weight: 600;
}
</style>
