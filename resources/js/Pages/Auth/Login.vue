<script setup>
// import Checkbox from "@/components/Checkbox.vue";
import InputError from "@/components/InputError.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const onSubmit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="mb-2 text-center">
            <header>
                <h2 class="text-2xl font-bold text-gray-900">LOGIN</h2>

                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <span>
                        <Link
                            :href="route('register')"
                            class="underline text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Sign Up
                        </Link>
                    </span>
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
                    outer: 'mt-1 block w-full',
                    input: 'border border-gray-400 px-2 mb-1',
                }"
            />

            <InputError
                class="mt-1 text-red-500 text-sm font-bold"
                :message="form.errors.email"
            />

            <FormKit
                type="password"
                name="password"
                label="Password"
                validation="required"
                v-model="form.password"
                :classes="{
                    outer: 'mt-4 block w-full',
                }"
            />

            <!-- <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div> -->

            <div class="flex items-center justify-end mt-4">
                <!-- <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link> -->
                <FormKit
                    type="submit"
                    label="Log In"
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
