<template>
    <section class="relative block pt-24 lg:pt-0 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center lg:-mt-64 -mt-48">
                <div class="w-full lg:w-6/12 px-4">
                    <div
                        class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300"
                    >
                        <FormKit
                            v-model="formData"
                            type="form"
                            id="joinUsForm"
                            :actions="false"
                            :config="{
                                classes: {
                                    outer: 'block text-gray-700 text-xs font-bold mb-2',
                                    input: 'px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full',
                                    message: 'text-red-500 text-sm font-bold',
                                    messages: 'pt-2',
                                    label: 'block mb-1',
                                },
                            }"
                        >
                            <div class="flex-auto p-5 lg:p-10">
                                <h4 class="text-2xl font-semibold">
                                    {{ joinUsData.title }}
                                </h4>
                                <p
                                    class="leading-relaxed mt-1 mb-4 text-gray-600"
                                    v-html="joinUsData.description"
                                >
                                </p>
                                <div class="relative w-full mb-3 mt-8">
                                    <FormKit
                                        type="text"
                                        label="Full Name"
                                        name="name"
                                        validation="required"
                                        placeholder="Full Name"
                                    />
                                </div>
                                <div class="relative w-full mb-3">
                                    <FormKit
                                        type="email"
                                        label="Email"
                                        name="email"
                                        validation="required|email"
                                        placeholder="Email"
                                    />
                                </div>
                                <div class="relative w-full mb-3">
                                    <FormKit
                                        type="textarea"
                                        label="Message"
                                        name="message"
                                        rows="4"
                                        cols="80"
                                        placeholder="Type a message..."
                                    />
                                </div>
                                <div class="text-center mt-6">
                                    <FormKit
                                        type="button"
                                        label="Send Message"
                                        @click="subscribe()"
                                        :classes="{
                                            outer: '$reset m-0 text-center',
                                            input: '$reset bg-blue-500 text-white active:bg-blue-300 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1',
                                        }"
                                    />
                                    <div
                                        class="text-green-500 text-sm font-bold"
                                        v-if="complete"
                                    >
                                        Submitted successfully!
                                    </div>
                                    <InputError
                                        class="text-red-500 text-sm font-bold"
                                        :message="errorMsg"
                                    />
                                </div>
                            </div>
                        </FormKit>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import InputError from "@/components/InputError.vue";
import axios from "axios";
export default {
    props: {
        joinUsData: {
            type: Object,
            default: () => ({}),
        },
    },
    components: {
        InputError,
    },
    data() {
        return {
            formData: {
                name: "",
                email: "",
                message: null,
            },
            errorMsg: null,
            complete: false,
        };
    },
    methods: {
        subscribe() {
            axios
                .post(route("join-our-networks.store"), this.formData)
                .then((res) => {
                    if (res.data.success) {
                        this.$formkit.reset("joinUsForm");
                        this.complete = true;
                    }
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
    },
};
</script>

<style></style>
