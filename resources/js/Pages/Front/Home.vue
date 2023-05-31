<template>
    <div id="app" class="min-h-screen w-full bg-gray-200">
      <main>
        <NavigationBar v-if="pageSetting" :pageSetting="this.pageSetting"/>
        <Hero v-if="coverData" :coverData="this.coverData"/>
        <Features v-if="featureData && aboutUsTextData && aboutUsCardData" :featureData="this.featureData" :aboutUsTextData="this.aboutUsTextData" :aboutUsCardData="aboutUsCardData"/>
        <Mission v-if="ourMissionData" :ourMissionData="ourMissionData"/>
        <Team/>
        <Services/>
        <Contact v-if="joinUsData" :joinUsData="this.joinUsData"/>
        <Footer v-if="pageSetting" :pageSetting="this.pageSetting"/>
      </main>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import Mission from "./components/Mission.vue";
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
      Mission,
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
            aboutUsTextData: null,
            aboutUsCardData: null,
            ourMissionData: null,
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
        getAboutUsTextData(){
          axios.get(route("public.getAboutUsTextData")).then((res) => {
                this.aboutUsTextData = res.data;
            });
        },
        getAboutUsCardData(){
          axios.get(route("public.getAboutUsCardData")).then((res) => {
                this.aboutUsCardData = res.data;
            });
        },
        getOurMissionData(){
          axios.get(route("public.getOurMissionData")).then((res) => {
                this.ourMissionData = res.data;
            });
        },
    },
    mounted(){
        this.getPageSetting()
        this.getCoverData()
        this.getJoinUsData()
        this.getFeatureData()
        this.getAboutUsTextData()
        this.getAboutUsCardData()
        this.getOurMissionData()
    }
  };
  </script>
  