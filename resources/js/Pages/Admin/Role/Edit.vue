<template>
    <Head title="Roles" />
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
                                Role Information
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Update role's name, status and permissions
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
                                name="name"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <div class="pb-4 px-2 mb-1">
                                <FormKit
                                    type="text"
                                    label="Code"
                                    name="code"
                                    validation="required"
                                    :classes="{
                                        input: 'border border-gray-400',
                                    }"
                                />
                                <InputError
                                    class="text-red-500 text-sm font-bold"
                                    :message="errorMsg"
                                />
                            </div>
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
                        <div>
                            <span class="block mb-1 font-bold text-base"
                                >Permissions</span
                            >
                            <div class="w-full rounded-md py-2">
                                <MultiSelect
                                    v-model="formData.permissions"
                                    optionValue="value"
                                    :options="permissionList"
                                    optionLabel="name"
                                    placeholder="Select permissions"
                                />
                            </div>
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
            statuses: {
                ACT: "ACTIVE",
                DSBL: "DISABLED",
            },
            permissionList: null,
            errorMsg: null,
        };
    },
    props: {
        role: {
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
            this.formData = this.role;
        },
        onSubmit() {
            axios
                .put(route("role.update", this.formData.id), this.formData)
                .then((res) => {
                    if (res.data.success) Inertia.visit(route("role.index"));
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
            if (this.isTriggeredFromTable) Inertia.visit(route("role.index"));
            else Inertia.get(route("role.show", this.formData.id));
        },
        getPermissionList() {
            axios
                .get(route("permission.getPermissionList"))
                .then((res) => {
                    this.permissionList = res.data;
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
        this.getPermissionList();
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
