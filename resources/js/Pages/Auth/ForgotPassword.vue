<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/components/InputError.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const onSubmit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-2 text-center">
            <header>
                <h2 class="text-xl font-bold text-gray-900">
                    FORGOT YOUR PASSWORD?
                </h2>

                <p class="text-sm text-gray-600">
                    Just let us know your email address and we will
                    email you a password reset link.
                </p>
            </header>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

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
            <FormKit
                type="email"
                label="Email"
                v-model="form.email"
                validation="required|email"
                :classes="{
                    outer: 'mt-4 block w-full',
                    input: 'border border-gray-400 px-2 mb-1',
                }"
            />
            <InputError
                class="mt-1 text-red-500 text-sm font-bold"
                :message="form.errors.email"
            />
            <div class="flex items-center justify-end mt-4">
                <FormKit
                    type="submit"
                    label="Email Password Reset Link"
                    :disabled="form.processing"
                    :classes="{
                        outer: form.processing
                            ? 'm-0 text-right ml-4 opacity-25'
                            : 'm-0 text-right ml-4',
                        input: 'bg-blue-500 hover:bg-blue-800 text-white font-bold px-3 w-auto mb-2 ',
                    }"
                />
            </div>
        </FormKit>
    </GuestLayout>
</template>
