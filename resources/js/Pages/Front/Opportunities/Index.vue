<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel
                v-if="opportunitiesCover"
                :cover="this.opportunitiesCover"
            />
            <div class="bg-white pt-14 pb-14">
                <div
                    v-if="opportunitiesPageTitle"
                    class="flex flex-wrap justify-center text-center mb-10"
                >
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold">
                            {{ opportunitiesPageTitle.title }}
                        </h2>
                        <p
                            class="text-lg leading-relaxed text-gray-600"
                            v-html="opportunitiesPageTitle.description"
                        ></p>
                    </div>
                </div>
                <div
                    v-if="opportunityItem"
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-5"
                >
                    <div
                        v-for="(opportunity, index) in opportunityItem"
                        :key="index"
                        class="block rounded-lg shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700"
                    >
                        <a href="#" @click="readOpportunity(opportunity.id)">
                            <img class="rounded-t-lg" :src="opportunity.image" />
                            <div class="p-6">
                                <h5
                                    class="mb-2 text-xl font-bold leading-tight text-neutral-800 dark:text-neutral-50"
                                >
                                    {{ opportunity.title }}
                                </h5>
                                <p
                                    class="mb-4 text-base text-neutral-600 dark:text-neutral-200"
                                >
                                    {{ opportunity.description }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <Pagination :data="opportunities" />
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
        opportunitiesCover: {
            type: Object,
            default: () => ({}),
        },
        opportunities: {
            type: Object,
            default: () => ({}),
        },
        opportunitiesPageTitle: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            pageSetting: null,
            opportunityItem: null,
            activeMenu: "opportunities",
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        readOpportunity(id) {
            Inertia.get(route("public.readOpportunity", id));
        },
    },
    mounted() {
        this.getPageSetting();
        this.opportunityItem = this.opportunities.data;
        this.opportunityItem.forEach((item) => {
            item.description =
                item.description.replace(/<[^>]+>/g, "").slice(0, 255) + "...";
        });
    },
};
</script>
