<script setup>
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password)
                form.reset("password", "password_confirmation");
            if (form.errors.current_password) form.reset("current_password");
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </header>

        <FormKit
            type="form"
            @submit="updatePassword"
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
            <FormKit
                id="current_password"
                type="password"
                name="password"
                label="Current Password"
                validation="required"
                v-model="form.current_password"
                :classes="{
                    outer: 'mt-1 block w-full',
                }"
            />
            <InputError
                :message="form.errors.current_password"
                class="mt-2 text-red-500 text-sm font-bold"
            />

            <FormKit type="group">
                <FormKit
                    type="password"
                    name="password"
                    id="password"
                    label="New Password"
                    validation="required"
                    v-model="form.password"
                    :classes="{
                        outer: 'mt-1 block w-full',
                    }"
                />
                <InputError
                    :message="form.errors.password"
                    class="mt-2 text-red-500 text-sm font-bold"
                />

                <FormKit
                    id="password_confirmation"
                    type="password"
                    name="password_confirm"
                    label="Confirm New Password"
                    v-model="form.password_confirmation"
                    validation="required|confirm"
                    validation-label="Password confirmation"
                    :classes="{
                        outer: 'mt-1 block w-full',
                    }"
                />
            </FormKit>

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
