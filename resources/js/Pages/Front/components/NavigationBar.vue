<template>
    <div>
        <nav
            class="bg-white fixed w-full z-20 top-0 left-0 border-b border-gray-200"
        >
            <div
                class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto"
            >
                <a href="https://flowbite.com/" class="flex">
                    <img
                        src="../../../../../public/images/logo.png"
                        class="h-20 mr-3"
                        :alt="this.pageSetting.name"
                    />
                </a>
                <div class="flex sm:order-2">
                    <a
                        :href="route('register')"
                        class="text-gray-900 hover:bg-gray-100 sm:hover:bg-transparent sm:hover:text-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3"
                    >
                        Sign Up
                    </a>
                    <a
                        :href="route('login')"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 sm:mr-0"
                    >
                        Sign In
                    </a>

                    <!-- Mobile View -->
                    <button
                        data-collapse-toggle="navbar-sticky"
                        type="button"
                        class="inline-flex items-center p-2 mr-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        aria-controls="navbar-sticky"
                        aria-expanded="false"
                        @click="toggleMenu"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
                            class="w-6 h-6"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                </div>

                <!-- Web View -->
                <div
                    class="items-center justify-between hidden w-full sm:flex sm:w-auto sm:order-1"
                    id="navbar-sticky"
                >
                    <ul
                        class="flex flex-col p-4 sm:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 sm:flex-row sm:space-x-8 sm:mt-0 sm:border-0 sm:bg-white"
                    >
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded sm:bg-transparent sm:text-blue-700 sm:p-0"
                                aria-current="page"
                                >Home</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 sm:hover:bg-transparent sm:hover:text-blue-700 sm:p-0"
                                >About</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 sm:hover:bg-transparent sm:hover:text-blue-700 sm:p-0"
                                >Services</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 sm:hover:bg-transparent sm:hover:text-blue-700 sm:p-0"
                                >Contact</a
                            >
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div v-if="isMenuOpen" class="sm:hidden bg-gray-50">
                <div class="w-full sm:block sm:w-auto" id="navbar-default">
                    <ul
                        class="font-medium flex flex-col p-4 sm:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 sm:flex-row sm:space-x-8 sm:mt-0 sm:border-0 sm:bg-white"
                    >
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded sm:bg-transparent sm:text-blue-700 sm:p-0"
                                aria-current="page"
                                >Home</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 sm:hover:bg-transparent sm:border-0 sm:hover:text-blue-700 sm:p-0"
                                >About</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 sm:hover:bg-transparent sm:border-0 sm:hover:text-blue-700 sm:p-0"
                                >Services</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 sm:hover:bg-transparent sm:border-0 sm:hover:text-blue-700 sm:p-0"
                                >Contact</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
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
    data() {
        return {
            isMenuOpen: false,
        };
    },
    methods: {
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        },
    },
};
</script>
