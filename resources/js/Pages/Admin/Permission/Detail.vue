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
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Permission Information
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Permission details
                        </p>
                    </div>
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
                                    {{ permission.name }}
                                </dd>
                            </div>
                            <div
                                class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-md font-medium text-gray-500">
                                    Status
                                </dt>
                                <dd
                                    class="mt-1 text-md text-gray-900 sm:col-span-2 sm:mt-0"
                                >
                                    {{ permission.status }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 p-2">
                                <div
                                    class="flex items-center mt-2 gap-4 justify-end"
                                >
                                <FormKit
                                    type="button"
                                    label="Edit"
                                    @click="edit(permission.id)"
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
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { usePage } from '@inertiajs/inertia-vue3'

export default {
    props: {
        permission: {
            type: Object,
            default: () => ({}),
        },
    },
    methods: {
        edit(id) {
            Inertia.get(route("permission.edit", id));
        },
        back(){
            Inertia.visit(route('permission.index'))
        },
    },
};
</script>
