<template>
    <Head title="User" />
    <AuthenticatedLayout>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <Toolbar>
                    <template #start>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Role Information
                        </h3>
                    </template>
                </Toolbar>
                <FormKit
                    type="button"
                    label="Back"
                    @click="back()"
                    :classes="{
                        outer: 'mt-4 mb-2',
                        input: 'bg-blue-500 text-white font-bold px-3 mb-2 w-auto rounded-md py-2',
                    }"
                />
                <div class="px-4">
                    <FormKit
                        type="form"
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
                                type="text"
                                label="Name"
                                v-model="formData.name"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="email"
                                label="Email"
                                v-model="formData.email"
                                validation="required|email"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="select"
                                label="Status"
                                :options="statuses"
                                v-model="formData.status"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="select"
                                label="Role"
                                :options="roleList"
                                v-model="formData.role"
                                placeholder="Select a role"
                                validation="required"
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
                                input: 'bg-blue-500 text-white font-bold px-3 w-auto',
                            }"
                        />
                    </FormKit>
                </div>
            </div>
        </div>
        <Toast />
    </AuthenticatedLayout>
</template>

<script>
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

export default {
    data() {
        return {
            formData: {},
            statuses: {
                ACT: "ACTIVE",
                PND: "PENDING",
                DSBL: "DISABLED",
            },
            roleList: {},
        };
    },
    props: {
        user: {
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
            this.formData = this.user;
        },
        onSubmit() {
            axios
                .put(route("user.update", this.formData.id), this.formData)
                .then((res) => {
                    if (res.data.success) Inertia.visit(route("user.index"));
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
        back() {
            if (this.isTriggeredFromTable) Inertia.visit(route("user.index"));
            else Inertia.get(route("user.show", this.formData.id));
        },
        getRoleList() {
            axios
                .get(route("role.getRoleList"))
                .then((res) => {
                    this.roleList = res.data;
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
    },
    mounted() {
        this.getRoleList();
    },
};
</script>
