<template>
    <div class="min-h-screen w-full">
        <main>
            <NavigationBar
                v-if="pageSetting"
                :pageSetting="this.pageSetting"
                :activeMenu="activeMenu"
            />
            <Carousel v-if="mentor" :mentor="this.mentor" />
            <div v-if="mentor" class="bg-white pt-14">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="text-center">
                            <h2 class="text-4xl font-semibold">
                                {{ mentor.name }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="mentor" class="bg-white">
                <div class="flex flex-wrap justify-center mb-10">
                    <div class="w-full lg:w-6/12 px-4">
                        <p
                            class="mt-4 text-lg leading-relaxed text-gray-600 mentorship-content"
                            v-html="mentor.description"
                        ></p>
                    </div>
                </div>
            </div>
            <FormKit
                type="button"
                label="Request an appointment"
                @click="
                    $page.props.auth.user
                        ? requestAppointment(mentor)
                        : showNotLogInDialog(mentor)
                "
                :classes="{
                    outer: '$reset m-0 text-center',
                    input: '$reset bg-blue-500 text-white active:bg-blue-300 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mb-14',
                }"
            />
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
import InputError from "@/components/InputError.vue";
export default {
    name: "App",
    components: {
        NavigationBar,
        Carousel,
        InputError,
        Footer,
    },
    props: {
        mentor: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            pageSetting: null,
            activeMenu: "mentorship",
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
        requestAppointment(mentor) {
            this.appointmentDialogVisibile = true;
            this.formData.mentor_id = mentor.id;
            this.dialogHeader = "Request an appointment with " + mentor.name;
        },
        showNotLogInDialog(mentor) {
            this.notLogInDialogVisible = true;
            this.dialogHeader = "Request an appointment with " + mentor.name;
        },
        closeAppointmentRequest(){
            this.appointmentDialogVisibile = false  
            this.errorMsg = null
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
                        this.errorMsg = null
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
.mentorship-content a {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    color: rgb(59 113 202 / var(--tw-text-opacity));
}
.mentorship-content a:hover {
    text-decoration: underline;
}
.mentorship-content ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.mentorship-content ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}

.mentorship-content h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
}

.mentorship-content h3 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2d3748;
}

.mentorship-content h4 {
    font-size: 1.125rem;
    font-weight: 1000;
    color: #2d3748;
}

.mentorship-content blockquote {
    position: relative;
    padding: 2rem;
    font-weight: 600;
}
</style>
