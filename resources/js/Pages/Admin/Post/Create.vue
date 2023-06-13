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
                <div class="px-4 bg-white shadow sm:rounded-lg">
                    <div
                        class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Create New Post
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Add post's title, category, status, image, and
                                description
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
                                label="Title *"
                                name="title"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="select"
                                label="Category *"
                                :options="categoryList"
                                v-model="formData.category_id"
                                placeholder="Select a category"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <FormKit
                                type="select"
                                label="Status *"
                                :options="statuses"
                                name="status"
                                validation="required"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                        </div>
                        <div class="grid grid-cols-2 gap-x-4">
                            <FormKit
                                type="number"
                                label="Sequence"
                                name="sequence"
                                validation="number|min:1"
                                :classes="{
                                    outer: 'pb-4',
                                    input: 'border border-gray-400 px-2 mb-1',
                                }"
                            />
                            <div>
                                <span class="block font-bold text-base"
                                    >Mentors</span
                                >
                                <div class="py-1">
                                    <MultiSelect
                                        v-model="formData.mentors"
                                        class="w-full rounded-md"
                                        optionValue="value"
                                        :options="mentorList"
                                        optionLabel="name"
                                        placeholder="Select mentors"
                                    />
                                    <InputError
                                        class="text-red-500 text-sm font-bold"
                                        :message="errorMsg"
                                    />
                                </div>
                            </div>
                        </div>
                        <FormKit
                            type="image"
                            label="Image"
                            name="image"
                            accept=".jpg,.png,.jepg"
                            :classes="{
                                outer: 'pb-4',
                                input: 'border border-gray-400 px-2 mb-1',
                            }"
                        />
                        <div class="pb-4 mb-1">
                            <span class="block mb-1 font-bold text-base"
                                >Description *</span
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
                            label="Create"
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
    data() {
        return {
            formData: {
                title: null,
                status: "ACT",
                category_id: null,
                image: null,
                description: "",
                mentors: null,
                sequence: null,
            },
            statuses: {
                ACT: "ACTIVE",
                DSBL: "DISABLED",
            },
            categoryList: {},
            errorMsg: null,
            mentorList: null,
        };
    },
    methods: {
        onSubmit() {
            const formData = new FormData();
            formData.append("title", this.formData.title);
            formData.append("category_id", this.formData.category_id);
            formData.append("status", this.formData.status);
            if(this.formData.sequence)
                formData.append("sequence", this.formData.sequence);
            formData.append("description", this.formData.description);
            if (this.formData.mentors)
                if (this.formData.mentors.length > 0)
                    for (var i = 0; i < this.formData.mentors.length; i++) {
                        formData.append("mentors[]", this.formData.mentors[i]);
                    }
            formData.append("image", this.formData.image);
            axios
                .post(route("post.store"), formData)
                .then((res) => {
                    if (res.data.success) Inertia.visit(route("post.index"));
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
            Inertia.visit(route("post.index"));
        },
        getCategoryList() {
            axios
                .get(route("category.getCategoryList"))
                .then((res) => {
                    this.categoryList = res.data;
                })
                .catch((err) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
        updateEditorData(editorData) {
            this.formData.description = editorData;
        },
        getMentorListAsArray() {
            axios
                .get(route("mentor.getMentorListAsArray"))
                .then((res) => {
                    this.mentorList = res.data;
                })
                .catch((err) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: err.response.data.message,
                        life: 3000,
                    });
                });
        },
    },
    mounted() {
        this.getCategoryList();
        this.getMentorListAsArray();
    },
};
</script>

<style scoped>
.p-multiselect {
    border-width: 1px;
    border-radius: 0.375rem;
    border-color: rgb(156, 163, 175);
}
</style>
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
img.formkit-file-item-image{
    max-width: 20% !important;
}
</style>
