<template>
    <div>
        <NavigationBar v-if="pageSetting" :pageSetting="this.pageSetting"/>
        <Carousel />
        <AboutUs/>
        <Service/>
        <Testimonial/>
        <OurTeam/>
        <BlogPost/>
        <Footer v-if="pageSetting" :pageSetting="this.pageSetting"/>
    </div>
</template>

<script>

import axios from "axios";
import Carousel from "./components/Carousel.vue";
import NavigationBar from "./components/NavigationBar.vue";
import Footer from './components/Footer.vue';
import BlogPost from './components/BlogPost.vue'
import OurTeam from "./components/OurTeam.vue";
import Testimonial from "./components/Testimonial.vue"
import Service from "./components/Service.vue";
import AboutUs from "./components/AboutUs.vue";

export default {
    components: {
        NavigationBar,
        Carousel,
        AboutUs,
        Service,
        Testimonial,
        OurTeam,
        BlogPost,
        Footer,
    },
    data() {
        return {
            pageSetting: null
        };
    },
    methods: {
        getPageSetting(){
            axios.get(route("page-settings.getData")).then((res) => {
                this.pageSetting = res.data;
            });
        }
    },
    mounted(){
        this.getPageSetting()
    }
};
</script>
