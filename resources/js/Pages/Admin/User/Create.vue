<template>
    <Head title="User" />
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
                                Add New User
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Create user's name, email, status and role
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
                                type="text"
                                label="Name"
                                v-model="name"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="email"
                                label="Email"
                                v-model="email"
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
                                v-model="status"
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
                                v-model="role"
                                placeholder="Select a role"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit type="group">
                                <FormKit
                                    type="password"
                                    name="password"
                                    label="Password"
                                    v-model="password"
                                    help="Enter a new password"
                                    validation="required"
                                />
                                <FormKit
                                    type="password"
                                    name="password_confirm"
                                    label="Confirm password"
                                    v-model="password_confirmation"
                                    help="Confirm your new password"
                                    validation="required|confirm"
                                    validation-label="Password confirmation"
                                />
                            </FormKit>
                            <FormKit
                                type="image"
                                label="Image"
                                v-model="image"
                                accept=".jpg,.png"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <FormKit
                            type="submit"
                            label="Create"
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

export default {
    data() {
        return {
            formData: {
                name: null,
                email: null,
                status: "ACT",
                role: null,
                password: null,
                password_confirmation: null,
                image: null,
            },
            statuses: {
                ACT: "ACTIVE",
                PND: "PENDING",
                DSBL: "DISABLED",
            },
            roleList: {},
        };
    },
    methods: {
        onSubmit() {
            axios
                .post(route("user.store"), this.formData)
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
        goBack() {
            Inertia.visit(route("user.index"));
        },
        getRoleList() {
            axios.get(route("role.getRoleList")).then((res) => {
                this.roleList = res.data;
            });
        },
        async uploadHandler(file){
            const formData = new FormData();
            formData.append("file", file);
            console.log(formData)

            // const response = await fetch("/upload", {
            //     method: "POST",
            //     body: formData,
            // });

            // return response.url;
        }
    },
    mounted() {
        this.getRoleList();
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
</style>
