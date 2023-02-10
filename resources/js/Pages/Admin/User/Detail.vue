<template>
    <Head title="User" />
    <AuthenticatedLayout>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <Toolbar>
                    <template #start>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            User Information
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
                <div class="border-t border-gray-200">
                    <dl>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-500">
                                Name
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ user.name }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-500">
                                Email
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ user.email }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-500">
                                Status
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ user.status }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-500">
                                Role
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ user.role }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 p-2">
                            <div
                                class="flex items-center mt-2 gap-4 justify-end"
                            >
                                <FormKit
                                    type="button"
                                    label="Edit"
                                    @click="edit(user.id)"
                                    :classes="{
                                        outer: 'text-right m-0',
                                        input: 'bg-blue-500 text-white font-bold px-3 mb-2 w-auto rounded-md py-2',
                                    }"
                                />
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        user: {
            type: Object,
            default: () => ({}),
        },
    },
    methods: {
        edit(id) {
            Inertia.get(route("user.edit", id));
        },
        back() {
            Inertia.visit(route("user.index"));
        },
    },
};
</script>
