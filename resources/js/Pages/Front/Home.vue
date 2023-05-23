<template>
    <div>
        <NavigationBar />
        <Carousel />
        <AboutUs/>
        <Service/>
        <Testimonial/>
        <OurTeam/>
        <BlogPost/>
        <Footer/>
    </div>
</template>

<script>
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
        return {};
    },
    methods: {},
};
</script>
