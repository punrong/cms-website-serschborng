<template>
    <div class="min-h-screen w-full">
        <main>
        <NavigationBar v-if="pageSetting" :pageSetting="this.pageSetting" :activeMenu="activeMenu" />
        <section class="pb-20 bg-gray-300 -mt-24">
        <div class="container mx-auto px-4">
            <div v-if="aboutUsTextData && aboutUsCardData" class="flex flex-wrap items-center mt-20">
                <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                    <div
                        class="text-gray-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-gray-100"
                    >
                        <i class="fas fa-user-friends text-xl"></i>
                    </div>
                    <h3 class="text-3xl mb-2 font-semibold leading-normal">
                        {{ aboutUsTextData.title }}
                    </h3>
                    <p
                        class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700 features-component"
                        v-html="aboutUsTextData.description"
                    ></p>
                </div>
                <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-blue-600 w-full mb-6 shadow-lg rounded-lg"
                    >
                        <img
                            :src="aboutUsCardData.image"
                            class="w-full align-middle rounded-t-lg"
                        />
                        <blockquote class="relative p-8 mb-4">
                            <h4 class="text-xl font-bold text-white">
                                {{ aboutUsCardData.title }}
                            </h4>
                            <p class="text-md font-light mt-2 text-white" v-html="aboutUsCardData.description">
                            </p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
    </main>
    </div>
</template>

<script>
import axios from "axios";
import NavigationBar from "./components/NavigationBar.vue";
import Footer from "./components/Footer.vue";
export default {
    name: "App",
    components: {
        NavigationBar,
        Footer,
    },
    data() {
        return {
            pageSetting: null,
            aboutUsCardData: null,
            aboutUsTextData: null,
            activeMenu: "about-us",
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        getAboutUsTextData() {
            axios.get(route("public.getAboutUsTextData")).then((res) => {
                this.aboutUsTextData = res.data;
            });
        },
        getAboutUsCardData() {
            axios.get(route("public.getAboutUsCardData")).then((res) => {
                this.aboutUsCardData = res.data;
            });
        },
    },
    mounted() {
        this.getPageSetting()
        this.getAboutUsTextData()
        this.getAboutUsCardData()
    },
};
</script>
