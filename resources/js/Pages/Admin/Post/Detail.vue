<template>
    <Head title="Posts" />
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
                                    Post Information
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    View post's title, status, and description
                                </p>
                            </header>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Title
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ post.title }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Category
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ post.category }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Status
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ post.status }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Author
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ post.author }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Sequence
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ post.sequence }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Mentors
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                {{ post.mentors }}
                            </dd>
                        </div>
                        <div
                            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Description
                            </dt>
                            <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                {{ post.description }}
                            </dd>
                        </div>
                        <div
                            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                        >
                            <dt class="text-md font-medium text-gray-900">
                                Image
                            </dt>
                            <dd
                                class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                            >
                                <img class="max-w-[20%]" :src="post.image" />
                            </dd>
                        </div>
                        <div v-if="can.edit" class="bg-white p-2">
                            <div
                                class="flex items-center mt-2 gap-4 justify-end"
                            >
                                <FormKit
                                    type="button"
                                    label="Edit"
                                    @click="edit(post.id)"
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
        post: {
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
            Inertia.get(route("post.edit", id));
        },
        goBack() {
            Inertia.visit(route("post.index"));
        },
    },
};
</script>
