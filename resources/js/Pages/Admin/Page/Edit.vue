<template>
    <Head title="Mentors" />
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
                <div class="px-4 bg-white shadow sm:rounded-lg">
                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Edit Page Settings
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Update name, email, phone number, logo, facebook
                                link, description, and copyrights
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
                        <div class="grid grid-cols-3 gap-x-4">
                            <FormKit
                                type="text"
                                label="Name"
                                name="name"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="email"
                                label="Email"
                                name="email"
                                validation="required|email"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="tel"
                                label="Phone number"
                                name="phone_number"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <div class="grid grid-cols-3 gap-x-4">
                            <FormKit
                                type="text"
                                label="Facebook Link"
                                name="facebook"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="text"
                                label="Copyrights"
                                name="copyrights"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <FormKit
                            type="image"
                            label="Logo"
                            name="logo"
                            accept=".jpg,.png,.jepg"
                            :classes="{
                                outer: 'pb-4',
                                input: 'border border-gray-400 px-2 mb-1',
                            }"
                        />
                        <FormKit
                            type="image"
                            label="Favicon"
                            name="favicon"
                            accept=".jpg,.png,.jepg"
                            :classes="{
                                outer: 'pb-4',
                                input: 'border border-gray-400 px-2 mb-1',
                            }"
                        />
                        <div class="pb-4 mb-1">
                            <span class="block mb-1 font-bold text-base"
                                >Description</span
                            >
                            <Editor
                                :content="formData.description"
                                @updateEditorData="updateEditorData"
                            />
                            <InputError
                                class="text-red-500 text-sm font-bold"
                                :message="errorMsg"
                            />
                        </div>
                        <FormKit
                            type="submit"
                            label="Update"
                            :classes="{
                                outer: 'm-0 text-right',
                                input: '$reset rounded-md py-2 bg-blue-500 text-white font-bold px-3 w-auto mb-2',
                            }"
                        />
                    </FormKit>
                </div>
            </div>
        </div>
        <Toast />
    </MenuSideBar>
</template>

<script>
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/components/InputError.vue";
import Editor from "@/components/Editor.vue";

export default {
    components: {
        InputError,
        Editor,
    },
    props: {
        page_settings: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            formData: {},
            errorMsg: null,
        };
    },
    methods: {
        initForm() {
            this.formData = this.page_settings;
        },
        onSubmit() {
            const formData = new FormData();
            formData.append("name", this.formData.name);
            formData.append("email", this.formData.email);
            formData.append("facebook", this.formData.facebook);
            formData.append("phone_number", this.formData.phone_number);
            formData.append("copyrights", this.formData.copyrights);
            formData.append("description", this.formData.description);
            formData.append("logo", this.formData.logo);
            formData.append("favicon", this.formData.favicon);
            formData.append("_method", "PUT");

            const config = {
                headers: { "content-type": "multipart/form-data" },
            };
            axios
                .post(
                    route("page-settings.update", this.formData.id),
                    formData,
                    config
                )
                .then((res) => {
                    if (res.data.success)
                        Inertia.visit(route("page-settings.index"));
                })
                .catch((err) => {
                    if (err.response.status === 422)
                        this.errorMsg = err.response.data.message;
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
        goBack() {
            Inertia.visit(route("page-settings.index"));
        },
        updateEditorData(editorData) {
            this.formData.description = editorData;
        },
    },
    created() {
        this.initForm();
    },
};
</script>
<style>
button.formkit-file-item-remove {
    background-color: rgb(239 68 68) !important;
    border-radius: 0.375rem !important;
    color: rgb(255 255 255) !important;
    font-weight: 700 !important;
    padding-left: 0.75rem !important;
    padding-right: 0.75rem !important;
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
    width: auto !important;
    margin-top: 0.5rem !important;
}
img.formkit-file-item-image {
    max-width: 20% !important;
}
</style>
