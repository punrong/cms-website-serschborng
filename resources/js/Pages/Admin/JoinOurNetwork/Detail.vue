<template>
    <Head title="Categories" />
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
                                    Join Our Network Information
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    View Join Our Network's name, email, and
                                    message
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
                                {{ join_our_network.name }}
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
                                {{ join_our_network.email }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Message
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ join_our_network.message }}
                            </dd>
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
        join_our_network: {
            type: Object,
            default: () => ({}),
        },
    },
    methods: {
        goBack() {
            Inertia.visit(route("join-our-networks.index"));
        },
    },
};
</script>
