<template>
    <Head title="Appointments" />
    <MenuSideBar>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <FormKit
                    type="button"
                    label="Go Back"
                    @click="goBack()"
                    :classes="{
                        outer: 'mb-2',
                        input: 'bg-blue-500 text-white font-bold px-3 mb-2 w-auto rounded-md py-2',
                    }"
                />
                <div class="px-4 bg-white shadow sm:rounded-lg">
                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Appointment Information
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Update appointment's mentee, mentor, method,
                                description, appointment datetime, status and
                                opportunity
                            </p>
                        </header>
                    </div>
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
                        <div class="grid grid-cols-3 gap-x-4">
                            <FormKit
                                type="select"
                                label="Mentee *"
                                v-model="formData.mentee_id"
                                :options="menteeList"
                                placeholder="Select a mentee"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="select"
                                label="Mentor *"
                                v-model="formData.mentor_id"
                                :options="mentorList"
                                placeholder="Select a mentor"
                                validation="required"
                                :classes="{
                                    input: 'border border-gray-400',
                                }"
                            />
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
                            <FormKit
                                type="select"
                                label="Opportunity"
                                v-model="formData.opportunity_id"
                                :options="opportunityList"
                                placeholder="Select an opportunity"
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
                            <FormKit
                                type="select"
                                label="Status *"
                                :options="statuses"
                                name="status"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <div>
                            <FormKit
                                type="textarea"
                                label="Description"
                                name="description"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <FormKit
                            type="submit"
                            label="Update"
                            :classes="{
                                outer: 'm-0 text-right',
                                input: '$reset rounded-md py-2 bg-blue-500 text-white font-bold px-3 w-auto mb-2',
                            }"
                        />
                    </FormKit>
                </div>
            </div>
        </div>
        <Toast />
    </MenuSideBar>
</template>

<script>
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/components/InputError.vue";

export default {
    components: {
        InputError,
    },
    data() {
        return {
            formData: {},
            methods: {
                ZOOM: "ZOOM",
                EMAIL: "EMAIL",
                IN_PERSON: "IN_PERSON",
            },
            statuses: {
                ACP: "ACCEPTED",
                PND: "PENDING",
                REJ: "REJECTED",
            },
            errorMsg: null,
            mentorList: {},
            opportunityList: {},
            menteeList: {},
        };
    },
    props: {
        appointment: {
            type: Object,
            default: () => ({}),
        },
        isTriggeredFromTable: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        initForm() {
            this.formData = this.appointment;
        },
        onSubmit() {
            axios
                .put(
                    route("appointment.update", this.formData.id),
                    this.formData
                )
                .then((res) => {
                    if (res.data.success)
                        Inertia.visit(route("appointment.index"));
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
        goBack() {
            if (this.isTriggeredFromTable)
                Inertia.visit(route("appointment.index"));
            else Inertia.get(route("appointment.show", this.formData.id));
        },
        getMentorListAsObject() {
            axios
                .get(route("mentor.getMentorListAsObject"))
                .then((res) => {
                    this.mentorList = res.data;
                })
                .catch((err) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
        getOpportunityListAsObject() {
            axios
                .get(route("post.getOpportunityListAsObject"))
                .then((res) => {
                    this.opportunityList = res.data;
                })
                .catch((err) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
        getMenteeListAsObject() {
            axios
                .get(route("user.getMenteeListAsObject"))
                .then((res) => {
                    this.menteeList = res.data;
                })
                .catch((err) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
    },
    created() {
        this.initForm();
        this.getMentorListAsObject();
        this.getOpportunityListAsObject();
        this.getMenteeListAsObject();
    },
};
</script>
<style scoped>
.p-multiselect {
    width: 100%;
    border-width: 1px;
    border-radius: 0.375rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    margin-bottom: 0.25rem;
}
</style>
