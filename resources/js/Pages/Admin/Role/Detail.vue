<template>
    <Head title="Role" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Role
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Role
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                View role information
                            </p>
                        </header>
                        <section class="mt-6 space-y-6">

                        </section>
                            <div>
                                <InputLabel for="name" value="Name" />
                                <p>{{ props.role.name }}</p>
                            </div>

                            <div>
                                <InputLabel for="status" value="Status" />
                                <p>{{ props.role.status }}</p>
                            </div>

                            <div class="flex items-center mt-2 gap-4">
                                <Button
                                    label="Edit"
                                    @click="edit(props.role.id)"
                                />
                            </div>

                    </section>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
    import InputLabel from "@/Components/InputLabel.vue";
    import { Inertia } from "@inertiajs/inertia";

    const props = defineProps({
        role: {
            type: Object,
            default: () => ({}),
        },
    });

    function edit(id){
        Inertia.get(route('role.edit', id))
    }

</script>
