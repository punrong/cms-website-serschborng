<template>
    <Head title="Permission" />
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
                            Create a Permission
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Permission details
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
        <Toast />
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
                status: "ACT",
            },
            statuses: {
                ACT: "ACTIVE",
                DSBL: "DISABLED",
            },
        };
    },
    methods: {
        onSubmit() {
            axios
                .post(route("permission.store"), this.formData)
                .then((res) => {
                    if (res.data.success) Inertia.visit(route("permission.index"));
                })
                .catch((err) => {
                    this.$toast.add({severity:'error', summary: 'Error Message', detail:err.response.data.message, life: 3000});
                })
        },
        back(){
            Inertia.visit(route('permission.index'))
        },
    },
};
</script>

<style scoped>
</style>
