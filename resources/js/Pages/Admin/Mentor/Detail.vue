<template>
    <Head title="Mentors" />
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
                <div
                    class="border-t border-gray-200 bg-white shadow sm:rounded-lg"
                >
                    <dl>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    Mentor Information
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    View mentor's title, status, and description
                                </p>
                            </header>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Name
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ mentor.name }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Email
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ mentor.email }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Phone Number
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ mentor.phone_number }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Status
                            </dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                {{ mentor.status }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Image
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                <img :src="mentor.image" />
                            </dd>
                        </div>
                        <div v-if="can.edit" class="bg-white p-2">
                            <div
                                class="flex items-center mt-2 gap-4 justify-end"
                            >
                                <FormKit
                                    type="button"
                                    label="Edit"
                                    @click="edit(mentor.id)"
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
    </MenuSideBar>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        mentor: {
            type: Object,
            default: () => ({}),
        },
        can: {
            type: Object,
            default: () => ({}),
        },
    },
    methods: {
        edit(id) {
            Inertia.get(route("mentor.edit", id));
        },
        goBack() {
            Inertia.visit(route("mentor.index"));
        },
    },
};
</script>
