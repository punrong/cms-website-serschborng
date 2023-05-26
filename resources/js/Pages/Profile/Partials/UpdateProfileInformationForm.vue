<script setup>
import InputError from "@/components/InputError.vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>
        <FormKit
            type="form"
            @submit="form.patch(route('profile.update'))"
            :actions="false"
            :config="{
                classes: {
                    label: 'block mb-1 font-bold text-base',
                    outer: 'mt-6',
                    input: 'w-full rounded-md py-2',
                    message: 'text-red-500 text-sm font-bold',
                    messages: 'pt-2',
                },
            }"
        >
            <div>
                <FormKit
                    type="text"
                    label="Name *"
                    v-model="form.name"
                    validation="required"
                    :classes="{
                        outer: 'mt-1 block w-full',
                        input: 'border border-gray-400 px-2 mb-1',
                    }"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <FormKit
                    type="email"
                    label="Email *"
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
            </div>

            <div
                v-if="props.mustVerifyEmail && user.email_verified_at === null"
            >
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <FormKit
                    type="submit"
                    label="Save"
                    :disabled="form.processing"
                    :classes="{
                        outer: form.processing ? 'm-0 text-right opacity-25' : 'm-0 text-right',
                        input: 'bg-blue-500 text-white font-bold px-3 w-auto mb-2 ',
                    }"
                />

                <Transition
                    enter-from-class="opacity-0"
                    leave-to-class="opacity-0"
                    class="transition ease-in-out"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="font-bold text-base text-gray-600 mt-4"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </FormKit>
    </section>
</template>
