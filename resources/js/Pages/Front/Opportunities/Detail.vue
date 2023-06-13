<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="opportunity" :opportunity="this.opportunity" />
            <div v-if="opportunity" class="bg-white pt-14">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="text-center">
                            <h2 class="text-4xl font-semibold">
                                {{ opportunity.title }}
                            </h2>
                            <p class="mt-4 text-lg text-gray-500">
                                Author: {{ opportunity.publisher }}
                            </p>
                            <p class="text-lg text-gray-500">
                                Published Date: {{ opportunity.publish_date }}
                            </p>
                        </div>
                        <p
                            class="mt-4 text-lg leading-relaxed text-gray-600 opportunity-content"
                            v-html="opportunity.description"
                        ></p>
                    </div>
                </div>
            </div>
            <div
                v-if="mentorList.length > 0"
                class="flex flex-wrap justify-center text-center"
            >
                <div class="w-full lg:w-6/12">
                    <h2 class="text-4xl font-semibold">
                        {{ opportunitiesMentorTitle.title }}
                    </h2>
                    <p
                        class="text-lg leading-relaxed text-gray-600"
                        v-html="opportunitiesMentorTitle.description"
                    ></p>
                </div>
            </div>
            <div v-if="mentorList" class="flex flex-wrap -mx-4 p-4">
                <div
                    v-for="(mentor, index) in mentorList"
                    :key="index"
                    class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-4 mb-4"
                >
                    <div class="bg-white rounded-lg shadow p-4">
                        <a href="#" @click="readMentorBackground(mentor.id)">
                            <img
                                :src="mentor.image"
                                :alt="mentor.name"
                                class="w-full rounded-lg h-[200px] object-cover mb-4"
                            />
                        </a>
                        <div class="flex justify-between">
                            <a
                                href="#"
                                @click="readMentorBackground(mentor.id)"
                            >
                                <h3 class="font-bold mb-2 hover:underline">
                                    {{ mentor.name }}
                                </h3>
                            </a>
                            <a
                                href="#"
                                @click="
                                    $page.props.auth.user
                                        ? requestAppointment(mentor)
                                        : showNotLogInDialog(mentor)
                                "
                                class="ml-2 text-blue-500 hover:underline"
                            >
                                Request an appointment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <Dialog
                v-model:visible="appointmentDialogVisibile"
                modal
                :header="dialogHeader"
                :style="{ width: '50vw' }"
                :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
            >
                <FormKit
                    type="form"
                    v-model="formData"
                    @submit="onSubmit"
                    :actions="false"
                    :config="{
                        classes: {
                            label: 'block mb-1 font-bold text-base',
                            input: 'w-full rounded-md py-2',
                            help: 'text-xs text-gray-500',
                            message: 'text-red-500 text-sm font-bold',
                            messages: 'pt-2',
                        },
                    }"
                >
                    <div class="grid grid-cols-2 gap-x-4">
                        <FormKit
                            type="select"
                            label="Method *"
                            :options="methods"
                            name="method"
                            validation="required"
                            :classes="{
                                outer: 'pb-4',
                                input: 'border border-gray-400 px-2 mb-1',
                            }"
                        />
                        <div class="pb-4 px-2 mb-1">
                            <FormKit
                                type="datetime-local"
                                label="Date and Time *"
                                name="appointment_datetime"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <InputError
                                class="text-red-500 text-sm font-bold"
                                :message="errorMsg"
                            />
                        </div>
                    </div>
                    <div>
                        <FormKit
                            type="textarea"
                            label="Description *"
                            name="description"
                            validation="required"
                            :classes="{
                                outer: 'pb-4',
                                input: 'border border-gray-400 px-2 mb-1',
                            }"
                        />
                    </div>
                    <div class="flex justify-end">
                        <FormKit
                            type="button"
                            label="Cancel"
                            @click="appointmentDialogVisibile = false"
                            :classes="{
                                outer: 'm-0 text-right',
                                input: '$reset rounded-md py-2 bg-gray-500 text-white font-bold px-3 w-auto mb-2',
                            }"
                        />
                        <FormKit
                            type="submit"
                            label="Submit"
                            :classes="{
                                outer: 'm-0 text-right',
                                input: '$reset rounded-md py-2 bg-blue-500 text-white font-bold px-3 w-auto ml-5 mb-2',
                            }"
                        />
                    </div>
                </FormKit>
            </Dialog>
            <Dialog
                v-model:visible="notLogInDialogVisible"
                modal
                :header="dialogHeader"
                :style="{ width: '50vw' }"
                :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
            >
                <p>Please log in first</p>
            </Dialog>
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
        <Toast />
    </div>
</template>

<script>
import axios from "axios";
import Carousel from "./components/Carousel.vue";
import NavigationBar from "../components/NavigationBar.vue";
import Footer from "../components/Footer.vue";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/components/InputError.vue";

export default {
    name: "App",
    components: {
        NavigationBar,
        Carousel,
        Footer,
        InputError,
    },
    props: {
        opportunity: {
            type: Object,
            default: () => ({}),
        },
        opportunitiesMentorTitle: {
            type: Object,
            default: () => ({}),
        },
        mentorList: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
            activeMenu: "opportunities",
            appointmentDialogVisibile: false,
            notLogInDialogVisible: false,
            formData: {
                mentee_id: this.$page.props.auth.user
                    ? this.$page.props.auth.user.id
                    : null,
                mentor_id: null,
                method: "ZOOM",
                status: "PND",
                description: null,
                appointment_datetime: null,
                opportunity_id: this.opportunity.id,
            },
            methods: {
                ZOOM: "ZOOM",
                EMAIL: "EMAIL",
                IN_PERSON: "IN_PERSON",
            },
            dialogHeader: null,
            errorMsg: null,
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
        requestAppointment(mentor) {
            this.appointmentDialogVisibile = true;
            this.formData.mentor_id = mentor.id;
            this.dialogHeader = "Request an appointment with " + mentor.name;
        },
        showNotLogInDialog(mentor) {
            this.notLogInDialogVisible = true;
            this.dialogHeader = "Request an appointment with " + mentor.name;
        },
        onSubmit() {
            axios
                .post(route("appointment.store"), this.formData)
                .then((res) => {
                    if (res.data.success) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Appointment requested",
                            detail: "Your request has been sent",
                            life: 4000,
                        });
                        this.appointmentDialogVisibile = false;
                    }
                })
                .catch((err) => {
                    if (err.response.status === 422)
                        this.errorMsg = err.response.data.message;
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
    },
    mounted() {
        this.getPageSetting();
    },
};
</script>
<style>
.opportunity-content a {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    color: rgb(59 113 202 / var(--tw-text-opacity));
}
.opportunity-content a:hover {
    text-decoration: underline;
}
.opportunity-content ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.opportunity-content ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.opportunity-content h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
}

.opportunity-content h3 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2d3748;
}

.opportunity-content h4 {
    font-size: 1.125rem;
    font-weight: 1000;
    color: #2d3748;
}

.opportunity-content blockquote {
    position: relative;
    padding: 2rem;
    font-weight: 600;
}
</style>
