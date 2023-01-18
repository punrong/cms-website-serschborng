<template>
    <section class="h-screen">
        <div class="px-6 h-full text-gray-800">
            <div
                class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6"
            >
                <div
                    class="grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0"
                >
                    <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="w-full"
                        alt="Sample image"
                    />
                </div>
                <div
                    class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0"
                >
                    <form
                        action="javascript:void(0)"
                        @submit="register"
                        class="row"
                        method="post"
                    >
                        <div
                            class="col-12"
                            v-if="Object.keys(validationErrors).length > 0"
                        >
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <li
                                        v-for="(value, key) in validationErrors"
                                        :key="key"
                                    >
                                        {{ value[0] }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-6">
                            <input
                                name="name"
                                v-model="user.name"
                                id="name"
                                placeholder="Enter name"
                                type="text"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            />
                        </div>
                        <div class="mb-6">
                            <input
                                type="email"
                                name="email"
                                v-model="user.email"
                                id="email"
                                placeholder="Enter Email"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            />
                        </div>

                        <!-- Password input -->
                        <div class="mb-6">
                            <input
                                type="password"
                                name="password"
                                v-model="user.password"
                                id="password"
                                placeholder="Enter Password"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            />
                        </div>

                        <div class="mb-6">
                            <input
                                type="password_confirmation"
                                name="password_confirmation"
                                v-model="user.password_confirmation"
                                id="password_confirmation"
                                placeholder="Enter Password"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            />
                        </div>

                        <div class="text-center lg:text-left">
                            <div class="col-12 mb-2">
                                <button
                                    type="submit"
                                    :disabled="processing"
                                    class="btn btn-primary btn-block"
                                >
                                    {{
                                        processing ? "Please wait" : "Register"
                                    }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label
                                    >Already have an account?
                                    <router-link :to="{ name: 'login' }"
                                        >Login Now!</router-link
                                    ></label
                                >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapActions } from "vuex";
import axios from "axios";
export default {
    name: "register",
    data() {
        return {
            user: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            validationErrors: {},
            processing: false,
        };
    },
    methods: {
        ...mapActions({
            signIn: "auth/login",
        }),
        async register() {
            this.processing = true;
            await axios.get("/sanctum/csrf-cookie");
            await axios
                .post("/register", this.user)
                .then((response) => {
                    this.validationErrors = {};
                    this.signIn();
                })
                .catch(({ response }) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors;
                    } else {
                        this.validationErrors = {};
                        alert(response.data.message);
                    }
                })
                .finally(() => {
                    this.processing = false;
                });
        },
    },
};
</script>
