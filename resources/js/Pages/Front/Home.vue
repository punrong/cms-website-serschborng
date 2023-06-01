<template>
    <div id="app" class="min-h-screen w-full">
        <main>
            <NavigationBar v-if="pageSetting" :pageSetting="this.pageSetting" />
            <Hero v-if="coverData" :coverData="this.coverData" />
            <Features
                v-if="featureData && aboutUsTextData && aboutUsCardData"
                :featureData="this.featureData"
                :aboutUsTextData="this.aboutUsTextData"
                :aboutUsCardData="aboutUsCardData"
            />
            <Mission v-if="ourMissionData" :ourMissionData="ourMissionData" />
            <BlogPost
                v-if="blogPostTitleData && blogPostItemData"
                :blogPostTitleData="blogPostTitleData"
                :blogPostItemData="blogPostItemData"
            />
            <Team
                v-if="ourHeroTitleData && ourHeroItemData"
                :ourHeroTitleData="ourHeroTitleData"
                :ourHeroItemData="ourHeroItemData"
            />
            <Services
                v-if="ourServiceTitleData && ourServiceItemData"
                :ourServiceTitleData="ourServiceTitleData"
                :ourServiceItemData="ourServiceItemData"
            />
            <Contact v-if="joinUsData" :joinUsData="this.joinUsData" />
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
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
import BlogPost from "./components/BlogPost.vue";
import Testimonial from "./components/Testimonial.vue";
import NavigationBar from "./components/NavigationBar.vue";
import Footer from "./components/Footer.vue";
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
        Testimonial,
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
            ourHeroTitleData: null,
            ourHeroItemData: null,
            ourServiceTitleData: null,
            ourServiceItemData: null,
            blogPostTitleData: null,
            blogPostItemData: null,
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        getCoverData() {
            axios.get(route("public.getCoverData")).then((res) => {
                this.coverData = res.data;
            });
        },
        getJoinUsData() {
            axios.get(route("public.getJoinUsData")).then((res) => {
                this.joinUsData = res.data;
            });
        },
        getFeatureData() {
            axios.get(route("public.getFeatureData")).then((res) => {
                this.featureData = res.data;
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
        getOurMissionData() {
            axios.get(route("public.getOurMissionData")).then((res) => {
                this.ourMissionData = res.data;
            });
        },
        getOurHeroTitleData() {
            axios.get(route("public.getOurHeroTitleData")).then((res) => {
                this.ourHeroTitleData = res.data;
            });
        },
        getOurHeroItemData() {
            axios.get(route("public.getOurHeroItemData")).then((res) => {
                this.ourHeroItemData = res.data;
            });
        },
        getOurServiceTitleData() {
            axios.get(route("public.getOurServiceTitleData")).then((res) => {
                this.ourServiceTitleData = res.data;
            });
        },
        getOurServiceItemData() {
            axios.get(route("public.getOurServiceItemData")).then((res) => {
                this.ourServiceItemData = res.data;
            });
        },
        getBlogPostTitleData() {
            axios.get(route("public.getBlogPostTitleData")).then((res) => {
                this.blogPostTitleData = res.data;
            });
        },
        getBlogPostItemData() {
            axios.get(route("public.getBlogPostItemData")).then((res) => {
                this.blogPostItemData = res.data;
            });
        },
    },
    mounted() {
        this.getPageSetting();
        this.getCoverData();
        this.getJoinUsData();
        this.getFeatureData();
        this.getAboutUsTextData();
        this.getAboutUsCardData();
        this.getOurMissionData();
        this.getOurHeroTitleData();
        this.getOurHeroItemData();
        this.getOurServiceTitleData();
        this.getOurServiceItemData();
        this.getBlogPostTitleData();
        this.getBlogPostItemData();
    },
};
</script>
