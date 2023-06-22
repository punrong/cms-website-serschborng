<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel
                v-if="mentorshipCover"
                :cover="this.mentorshipCover"
                :hasCoverBtn="true"
                :coverBtnLabel="coverBtnLabel"
                @coverBtnClicked="openMentorRegisterDialog"
            />
            <div class="bg-white pt-14 pb-14">
                <div
                    v-if="mentorshipPageTitle"
                    class="flex flex-wrap justify-center text-center"
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
                <div
                    v-if="mentorItem"
                    class="flex flex-wrap -mx-4 p-4 justify-center items-center"
                >
                    <div
                        v-for="(mentor, index) in mentorItem"
                        :key="index"
                        class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-4 mb-4"
                    >
                        <div class="bg-white rounded-lg shadow p-4">
                            <a
                                href="#"
                                @click="readMentorBackground(mentor.id)"
                            >
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
                        v-model="appointmentData"
                        @submit="onAppointmentSubmit"
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
                                @click="closeAppointmentRequest"
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
                    v-model:visible="registerDialogVisibile"
                    modal
                    header="Mentor Registration"
                    :style="{ width: '50vw' }"
                    :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
                >
                    <FormKit
                        type="form"
                        v-model="registerData"
                        @submit="onRegistrationSubmit"
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
                        <div class="grid grid-cols-3 gap-x-4">
                            <FormKit
                                type="text"
                                label="Name *"
                                name="name"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="email"
                                label="Email *"
                                name="email"
                                validation="required|email"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="tel"
                                label="Phone number"
                                name="phone_number"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <FormKit
                            type="image"
                            label="Image"
                            name="image"
                            accept=".jpg,.png,.jepg"
                            :classes="{
                                outer: 'pb-4',
                                input: 'border border-gray-400 px-2 mb-1',
                            }"
                        />
                        <div class="pb-4 mb-1">
                            <span class="block mb-1 font-bold text-base"
                                >Mentor's Background *</span
                            >
                            <Editor
                                :content="registerData.description"
                                @updateEditorData="updateEditorData"
                            />
                            <InputError
                                class="text-red-500 text-sm font-bold"
                                :message="errorMsg"
                            />
                        </div>
                        <div class="flex justify-end">
                            <FormKit
                                type="button"
                                label="Cancel"
                                @click="closeRegisterRequest"
                                :classes="{
                                    outer: 'm-0 text-right',
                                    input: '$reset rounded-md py-2 bg-gray-500 text-white font-bold px-3 w-auto mb-2',
                                }"
                            />
                            <FormKit
                                type="submit"
                                label="Register"
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

                <Pagination :data="mentors" />
            </div>
            <Footer v-if="pageSetting" :pageSetting="this.pageSetting" />
        </main>
        <Toast />
    </div>
</template>

<script>
import axios from "axios";
import NavigationBar from "../components/NavigationBar.vue";
import Carousel from "../components/Carousel.vue";
import Pagination from "../components/Pagination.vue";
import Footer from "../components/Footer.vue";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/components/InputError.vue";
import Editor from "@/components/Editor.vue";

export default {
    name: "App",
    components: {
        NavigationBar,
        Carousel,
        Pagination,
        Footer,
        InputError,
        Editor,
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
            appointmentDialogVisibile: false,
            registerDialogVisibile: false,
            notLogInDialogVisible: false,
            appointmentData: {
                mentee_id: this.$page.props.auth.user
                    ? this.$page.props.auth.user.id
                    : null,
                mentor_id: null,
                method: "ZOOM",
                status: "PND",
                description: null,
                appointment_datetime: null,
            },
            registerData: {
                name: null,
                status: "PND",
                email: null,
                image: null,
                phone_number: "",
                description: "",
            },
            methods: {
                ZOOM: "ZOOM",
                EMAIL: "EMAIL",
                IN_PERSON: "IN_PERSON",
            },
            dialogHeader: null,
            errorMsg: null,
            coverBtnLabel: "Become our mentor now",
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
            this.appointmentData.mentor_id = mentor.id;
            this.dialogHeader = "Request an appointment with " + mentor.name;
        },
        closeAppointmentRequest() {
            this.appointmentDialogVisibile = false;
            this.errorMsg = null;
        },
        showNotLogInDialog(mentor) {
            this.notLogInDialogVisible = true;
            this.dialogHeader = "Request an appointment with " + mentor.name;
        },
        openMentorRegisterDialog() {
            this.registerDialogVisibile = true;
        },
        closeRegisterRequest() {
            this.registerDialogVisibile = false;
            this.errorMsg = null;
        },
        onAppointmentSubmit() {
            axios
                .post(route("appointment.store"), this.appointmentData)
                .then((res) => {
                    if (res.data.success) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Appointment requested",
                            detail: "Your request has been sent",
                            life: 4000,
                        });
                        this.errorMsg = null;
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
        onRegistrationSubmit() {
            axios
                .post(route("mentor.storeRegistration"), this.registerData)
                .then((res) => {
                    if (res.data.success) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Mentor Registration Requested",
                            detail: "Please wait for admin's approval",
                            life: 4000,
                        });
                        this.errorMsg = null;
                        this.registerDialogVisibile = false;
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
        updateEditorData(editorData) {
            this.registerData.description = editorData;
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
<style>
button.formkit-file-item-remove {
    background-color: rgb(239 68 68) !important;
    border-radius: 0.375rem !important;
    color: rgb(255 255 255) !important;
    font-weight: 700 !important;
    padding-left: 0.75rem !important;
    padding-right: 0.75rem !important;
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
    width: auto !important;
    margin-top: 0.5rem !important;
}
img.formkit-file-item-image{
    max-width: 20% !important;
}
</style>