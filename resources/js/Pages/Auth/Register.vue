<script setup>
import { ref, onMounted } from "vue";
import InputError from "@/components/InputError.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import NavigationBar from "../Front/components/NavigationBar.vue";
import Footer from "../Front/components/Footer.vue";
import axios from "axios";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const pageSetting = ref({});

const onSubmit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};

onMounted(async () => {
    try {
        const response = await axios.get(route("public.getPageSettingData"));
        pageSetting.value = response.data;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
});
</script>

<template>
    <NavigationBar />
    <GuestLayout>
        <Head title="Register" />
        <div class="mb-2 text-center">
            <header>
                <h2 class="text-2xl font-bold text-gray-900">REGISTER</h2>

                <p class="text-sm text-gray-600">
                    very excited to have you with us
                </p>
            </header>
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
                type="text"
                label="Name"
                v-model="form.name"
                validation="required"
                :classes="{
                    outer: 'mt-1 block w-full',
                    input: 'border border-gray-400 px-2 mb-1',
                }"
            />

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
            <FormKit type="group">
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
                <FormKit
                    type="password"
                    name="password_confirm"
                    label="Confirm password"
                    v-model="form.password_confirmation"
                    help="Confirm your new password"
                    validation="required|confirm"
                    validation-label="Password confirmation"
                    :classes="{
                        outer: 'mt-4 block w-full',
                    }"
                />
            </FormKit>
            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <FormKit
                    type="submit"
                    label="Register"
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
    <Footer v-if="pageSetting" :pageSetting="pageSetting" />
</template>
