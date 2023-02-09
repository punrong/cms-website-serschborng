<template>
    <Head title="Role" />
    <AuthenticatedLayout>
        <template #header>
            <FormKit
                type="button"
                label="Back"
                @click="back()"
                :classes="{
                    outer: 'm-0',
                    input: 'bg-blue-500 text-white font-bold px-3 mb-2 w-auto rounded-md py-2',
                }"
            />
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="overflow-hidden bg-white py-4 shadow sm:rounded-lg">
                    <div class="px-4 pb-4 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Update Role Information
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Role details
                        </p>
                    </div>
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
                            <div class="grid grid-cols-2 gap-x-4">
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
                                    <InputError class="text-red-500 text-sm font-bold" :message="errorMsg" />
                                </div>
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
        </div>
    </AuthenticatedLayout>
</template>

<script>
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import InputError from '@/Components/InputError.vue';

export default {
    components:{
        InputError
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
                    this.errorMsg = err.response.data.message
                })
        },
        back() {
            if (this.isTriggeredFromTable) 
                Inertia.visit(route("role.index"));
            else 
                Inertia.get(route("role.show", this.formData.id));
        },
        getPermissionList() {
            axios.get(route("permission.getPermissionList")).then((res) => {
                this.permissionList = res.data;
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
