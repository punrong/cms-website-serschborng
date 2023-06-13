<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="mentorshipCover" :cover="this.mentorshipCover" />
            <div class="bg-white pt-14 pb-14">
                <div
                    v-if="mentorshipPageTitle"
                    class="flex flex-wrap justify-center text-center mb-10"
                >
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold">
                            {{ mentorshipPageTitle.title }}
                        </h2>
                        <p
                            class="text-lg leading-relaxed text-gray-600"
                            v-html="mentorshipPageTitle.description"
                        ></p>
                    </div>
                </div>
                <div v-if="mentorItem" class="flex flex-wrap -mx-4 p-4">
                    <div
                        v-for="(mentor, index) in mentorItem"
                        :key="index"
                        class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-4 mb-4"
                    >
                        <a href="#" @click="readMentorBackground(mentor.id)">
                            <div class="bg-white rounded-lg shadow p-4">
                                <img
                                    :src="mentor.image"
                                    :alt="mentor.name"
                                    class="w-full rounded-lg h-[200px] object-cover mb-4"
                                />
                                <div class="flex justify-between">
                                    <h3 class="font-bold mb-2">
                                        {{ mentor.name }}
                                    </h3>
                                    <a
                                        href="#"
                                        class="ml-2 text-blue-500 hover:underline"
                                    >
                                        Make an appointment
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <Pagination :data="mentors" />
            </div>
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
    </div>
</template>

<script>
import axios from "axios";
import NavigationBar from "../components/NavigationBar.vue";
import Carousel from "../components/Carousel.vue";
import Pagination from "../components/Pagination.vue";
import Footer from "../components/Footer.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
    name: "App",
    components: {
        NavigationBar,
        Carousel,
        Pagination,
        Footer,
    },
    props: {
        mentorshipCover: {
            type: Object,
            default: () => ({}),
        },
        mentors: {
            type: Object,
            default: () => ({}),
        },
        mentorshipPageTitle: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
            mentorItem: null,
            activeMenu: "mentorship",
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        readMentorBackground(id) {
            Inertia.get(route("public.readMentorBackground", id));
        },
    },
    mounted() {
        this.getPageSetting();
        this.mentorItem = this.mentors.data;
        this.mentorItem.forEach((item) => {
            item.description =
                item.description.replace(/<[^>]+>/g, "").slice(0, 255) + "...";
        });
    },
};
</script>
