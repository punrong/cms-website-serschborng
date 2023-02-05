<template>
    <Head title="User" />
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
                            Create a User
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            User details
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
                                    message:
                                        'text-red-500 text-sm font-bold',
                                    messages: 'pt-2'
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
                                <FormKit type="group">
                                    <FormKit
                                        type="password"
                                        name="password"
                                        label="Password"
                                        v-model="formData.password"
                                        help="Enter a new password"
                                        validation="required"
                                    />
                                    <FormKit
                                        type="password"
                                        name="password_confirm"
                                        label="Confirm password"
                                        v-model="formData.password_confirmation"
                                        help="Confirm your new password"
                                        validation="required|confirm"
                                        validation-label="Password confirmation"
                                    />
                                </FormKit>
                            </div>
                            <FormKit
                                type="submit"
                                label="Create"
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

export default {
    data() {
        return {
            formData: {
                name: null,
                email: null,
                status: "ACT",
                role: null,
                password: null,
                password_confirmation: null
            },
            statuses: {
                ACT: "ACTIVE",
                PND: "PENDING",
                DSBL: "DISABLED",
            },
            roleList: {}
        };
    },
    methods: {
        onSubmit() {
            axios
                .post(route("user.store"), this.formData)
                .then((res) => {
                    if (res.data.success) Inertia.visit(route("user.index"));
                })
                .catch((err) => console.log(err));
        },
        back(){
            Inertia.visit(route('user.index'))
        },
        getRoleList(){
            axios.get(route('role.getRoleList')).then(res =>{
                this.roleList = res.data
            })
        }
    },
    mounted(){
        this.getRoleList()
    }
};
</script>