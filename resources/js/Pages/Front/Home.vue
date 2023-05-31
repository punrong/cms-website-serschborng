<template>
    <div id="app" class="min-h-screen w-full bg-gray-200">
      <main>
        <NavigationBar v-if="pageSetting" :pageSetting="this.pageSetting"/>
        <Hero v-if="coverData" :coverData="this.coverData"/>
        <Features v-if="featureData" :featureData="this.featureData"/>
        <About/>
        <Team/>
        <Services/>
        <Contact v-if="joinUsData" :joinUsData="this.joinUsData"/>
        <Footer v-if="pageSetting" :pageSetting="this.pageSetting"/>
      </main>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import About from "./components/About.vue";
  import Contact from "./components/Contact.vue";
  import Features from "./components/Features.vue";
  import Hero from "./components/Hero.vue";
  import Services from "./components/Services.vue";
  import Team from "./components/Team.vue";
  import BlogPost from './components/BlogPost.vue'
  import Testimonial from "./components/Testimonial.vue"
  import NavigationBar from "./components/NavigationBar.vue";
  import Footer from './components/Footer.vue';
  export default {
    name: "App",
    components: {
      About,
      Contact,
      Features,
      Hero,
      Services,
      Team,
      NavigationBar,
      Footer,
      BlogPost,
      Testimonial
    },
    data() {
        return {
            pageSetting: null,
            coverData: null,
            joinUsData: null,
            featureData: null,
        };
    },
    methods: {
        getPageSetting(){
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        getCoverData(){
          axios.get(route("public.getCoverData")).then((res) => {
                this.coverData = res.data;
            });
        },
        getJoinUsData(){
          axios.get(route("public.getJoinUsData")).then((res) => {
                this.joinUsData = res.data;
            });
        },
        getFeatureData(){
          axios.get(route("public.getFeatureData")).then((res) => {
                this.featureData = res.data;
            });
        },
    },
    mounted(){
        this.getPageSetting()
        this.getCoverData()
        this.getJoinUsData()
        this.getFeatureData()
    }
  };
  </script>
  