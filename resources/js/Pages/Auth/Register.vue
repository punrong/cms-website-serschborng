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
            v-model="formData"
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
                name="name"
                validation="required"
                :classes="{
                    outer: 'mt-1 block w-full',
                    input: 'border border-gray-400 px-2 mb-1',
                }"
            />

            <FormKit
                type="email"
                label="Email"
                name="email"
                validation="required|email"
                :classes="{
                    outer: 'mt-4 block w-full',
                    input: 'border border-gray-400 px-2 mb-1',
                }"
            />

            <InputError
                class="mt-1 text-red-500 text-sm font-bold"
                :message="$page.props.errors.email"
            />
            <FormKit type="group">
                <FormKit
                    type="password"
                    name="password"
                    label="Password"
                    v-model="formData.password"
                    validation="required"
                    :classes="{
                        outer: 'mt-4 block w-full',
                    }"
                />
                <InputError
                    class="mt-1 text-red-500 text-sm font-bold"
                    :message="$page.props.errors.password"
                />
                <FormKit
                    type="password"
                    name="password_confirm"
                    label="Confirm password"
                    v-model="formData.password_confirmation"
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
                    :disabled="formProcessing"
                    :classes="{
                        outer: formProcessing
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
<script>
import InputError from "@/components/InputError.vue";
import { Link } from "@inertiajs/inertia-vue3";
import NavigationBar from "../Front/components/NavigationBar.vue";
import Footer from "../Front/components/Footer.vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

export default {
    name: "Sers Chborng",
    components: {
        NavigationBar,
        Footer,
        InputError,
        Link,
    },
    data() {
        return {
            pageSetting: null,
            formData: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                terms: false,
            },
            formProcessing: false,
        };
    },
    methods: {
        getPageSetting() {
            axios.get(route("public.getPageSettingData")).then((res) => {
                this.pageSetting = res.data;
            });
        },
        onSubmit() {
            this.formProcessing = true;
            Inertia.post(route("register"), this.formData, {
                onFinish: (visit) => {
                    this.formData.password = "";
                    this.formData.password_confirmation = "";
                    this.formProcessing = false;
                },
            });
        },
    },
    mounted() {
        this.getPageSetting();
    },
};
</script>
