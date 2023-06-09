<template>
    <div id="app" class="min-h-screen w-full">
        <main>
            <NavigationBar v-if="pageSetting" :pageSetting="this.pageSetting" />
            <Carousel v-if="cover" :cover="this.cover" />
            <Features
                v-if="feature && aboutUsLeftText && aboutUsCard"
                :feature="this.feature"
                :aboutUsLeftText="this.aboutUsLeftText"
                :aboutUsCard="aboutUsCard"
            />
            <Mission v-if="ourMission" :ourMission="ourMission" />
            <Testimonial
                v-if="testimonialTitle && testimonialItem"
                :testimonialTitle="testimonialTitle"
                :testimonialItem="testimonialItem"
            />
            <Team
                v-if="ourTeamTitle && ourTeamItem"
                :ourTeamTitle="ourTeamTitle"
                :ourTeamItem="ourTeamItem"
            />
            <RecentWorks
                v-if="recentWorkTitle && recentWorkItem"
                :recentWorkTitle="recentWorkTitle"
                :recentWorkItem="recentWorkItem"
            />
            <Blog
                v-if="blogTitle && blogItem"
                :blogTitle="blogTitle"
                :blogItem="blogItem"
            />
            <Services
                v-if="ourServiceTitle && ourServiceItem"
                :ourServiceTitle="ourServiceTitle"
                :ourServiceItem="ourServiceItem"
            />
            <Contact v-if="joinUs" :joinUs="this.joinUs" />
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
    </div>
</template>

<script>
import axios from "axios";
import Mission from "./components/Mission.vue";
import Contact from "./components/Contact.vue";
import Features from "./components/Features.vue";
import Carousel from "../components/Carousel.vue";
import Services from "./components/Services.vue";
import Team from "./components/Team.vue";
import Blog from "./components/Blog.vue";
import Testimonial from "./components/Testimonial.vue";
import RecentWorks from "./components/RecentWorks.vue"
import NavigationBar from "../components/NavigationBar.vue";
import Footer from "../components/Footer.vue";
export default {
    name: "Sers Chborng",
    components: {
        Mission,
        Contact,
        Features,
        Carousel,
        Services,
        Team,
        NavigationBar,
        Footer,
        Blog,
        Testimonial,
        RecentWorks,
    },
    data() {
        return {
            pageSetting: null,
            cover: null,
            joinUs: null,
            feature: null,
            aboutUsLeftText: null,
            aboutUsCard: null,
            ourMission: null,
            ourTeamTitle: null,
            ourTeamItem: null,
            ourServiceTitle: null,
            ourServiceItem: null,
            blogTitle: null,
            blogItem: null,
            testimonialTitle: null,
            testimonialItem: null,
            recentWorkTitle: null,
            recentWorkItem: null,
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        getCoverData() {
            axios.get(route("public.getHomeCover")).then((res) => {
                this.cover = res.data;
            });
        },
        getJoinUsData() {
            axios.get(route("public.getHomeJoinUs")).then((res) => {
                this.joinUs = res.data;
            });
        },
        getFeatureData() {
            axios.get(route("public.getHomeFeatures")).then((res) => {
                this.feature = res.data;
            });
        },
        getAboutUsTextData() {
            axios.get(route("public.getHomeAboutUsLeftText")).then((res) => {
                this.aboutUsLeftText = res.data;
            });
        },
        getAboutUsCardData() {
            axios.get(route("public.getHomeAboutUsCard")).then((res) => {
                this.aboutUsCard = res.data;
            });
        },
        getOurMissionData() {
            axios.get(route("public.getHomeOurMission")).then((res) => {
                this.ourMission = res.data;
            });
        },
        getOurHeroTitleData() {
            axios.get(route("public.getHomeOurTeamTitle")).then((res) => {
                this.ourTeamTitle = res.data;
            });
        },
        getOurHeroItemData() {
            axios.get(route("public.getHomeOurTeamItem")).then((res) => {
                this.ourTeamItem = res.data;
            });
        },
        getOurServiceTitleData() {
            axios.get(route("public.getHomeOurServiceTitle")).then((res) => {
                this.ourServiceTitle = res.data;
            });
        },
        getOurServiceItemData() {
            axios.get(route("public.getHomeOurServiceItem")).then((res) => {
                this.ourServiceItem = res.data;
            });
        },
        getBlogPostTitleData() {
            axios.get(route("public.getBlogTitle")).then((res) => {
                this.blogTitle = res.data;
            });
        },
        getBlogPostItemData() {
            axios.get(route("public.getBlogItem")).then((res) => {
                this.blogItem = res.data;
            });
        },
        getTestimonialTitleData() {
            axios.get(route("public.getHomeTestimonialTitle")).then((res) => {
                this.testimonialTitle = res.data;
            });
        },
        getTestimonialItemData() {
            axios.get(route("public.getHomeTestimonialItem")).then((res) => {
                this.testimonialItem = res.data;
            });
        },
        getOurRecentWorkTitleData() {
            axios.get(route("public.getHomeOurRecentWorkTitle")).then((res) => {
                this.recentWorkTitle = res.data;
            });
        },
        getOurRecentWorkItemData() {
            axios.get(route("public.getHomeOurRecentWorkItem")).then((res) => {
                this.recentWorkItem = res.data;
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
        this.getTestimonialTitleData();
        this.getTestimonialItemData();
        this.getOurRecentWorkTitleData();
        this.getOurRecentWorkItemData();
    },
};
</script>
