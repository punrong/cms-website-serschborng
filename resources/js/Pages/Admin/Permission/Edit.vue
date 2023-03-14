<template>
    <Head title="Permission" />
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
                                Permission Information
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Update permission's name and status
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
                        <div class="grid grid-cols-2 gap-x-4">
                            <FormKit
                                type="text"
                                label="Name"
                                name="name"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="select"
                                label="Status"
                                :options="statuses"
                                name="status"
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
            formData: {},
            statuses: {
                ACT: "ACTIVE",
                DSBL: "DISABLED",
            },
        };
    },
    props: {
        permission: {
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
            this.formData = this.permission;
        },
        onSubmit() {
            axios
                .put(
                    route("permission.update", this.formData.id),
                    this.formData
                )
                .then((res) => {
                    if (res.data.success)
                        Inertia.visit(route("permission.index"));
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
            if (this.isTriggeredFromTable)
                Inertia.visit(route("permission.index"));
            else Inertia.get(route("permission.show", this.formData.id));
        },
    },
    created() {
        this.initForm();
    },
};
</script>
