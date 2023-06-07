<template>
    <div>
        <footer class="bg-gray-900">
            <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
                <div class="md:flex md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <a
                            :href="route('home')"
                            class="flex items-center"
                        >
                            <img
                                src="../../../../../public/logo.png"
                                class="h-20 mr-3"
                            />
                            <span
                                class="self-center text-2xl font-semibold whitespace-nowrap text-white"
                                >{{ this.pageSetting.name }}</span
                            >
                        </a>
                        <div
                            class="mb-6 text-sm font-semibold text-white"
                            v-html="this.pageSetting.description"
                        ></div>
                    </div>
                    <div class="">
                        <div>
                            <h2
                                class="mb-6 text-sm font-semibold uppercase text-white"
                            >
                                Contact
                            </h2>
                            <ul class="text-gray-400 font-medium">
                                <li class="mb-4">
                                    <FontAwesomeIcon
                                        icon="fa-solid fa-envelope"
                                    />
                                    <a
                                        class="hover:underline ml-3"
                                        :href="
                                            'mailto:' + this.pageSetting.email
                                        "
                                        >{{ this.pageSetting.email }}</a
                                    >
                                </li>
                                <li>
                                    <FontAwesomeIcon icon="fa-solid fa-phone" />
                                    <a
                                        class="hover:underline ml-3"
                                        :href="
                                            'tel:' +
                                            this.pageSetting.phone_number
                                        "
                                        >{{ this.pageSetting.phone_number }}</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr class="my-6 sm:mx-auto border-gray-700 lg:my-8" />
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span class="text-sm sm:text-center text-gray-400"
                        >{{ this.pageSetting.copyrights }}
                    </span>
                    <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
                        <a
                            :href="this.pageSetting.facebook"
                            class="text-gray-500 hover:text-white"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="sr-only">Facebook page</span>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    props: {
        pageSetting: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
