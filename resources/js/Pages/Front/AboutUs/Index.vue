<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="aboutUsCover" :cover="this.aboutUsCover" />
            <OurStory v-if="ourStory" :ourStory="ourStory" />
            <Founder v-if="ourFounder" :ourFounder="ourFounder" />
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
    </div>
</template>

<script>
import axios from "axios";
import NavigationBar from "../components/NavigationBar.vue";
import Footer from "../components/Footer.vue";
import Carousel from "../components/Carousel.vue";
import Founder from "./components/Founder.vue";
import OurStory from "./components/OurStory.vue";
export default {
    name: "App",
    components: {
        NavigationBar,
        Carousel,
        Founder,
        OurStory,
        Footer,
    },
    props: {
        aboutUsCover: {
            type: Object,
            default: () => ({}),
        },
        ourFounder: {
            type: Object,
            default: () => ({}),
        },
        ourStory: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
            activeMenu: "about-us",
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
