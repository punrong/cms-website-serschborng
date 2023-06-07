<template>
    <nav
        class="bg-white fixed w-full z-20 top-0 left-0 border-b border-gray-200"
    >
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto"
        >
            <a :href="route('home')" class="flex">
                <img
                    src="../../../../../public/logo.png"
                    class="h-20 mr-3"
                    :alt="pageSetting.name"
                />
            </a>
            <div class="flex custom-sm:order-2">
                <!-- Conditional rendering block -->
                <div
                    v-if="$page.props.auth.user"
                    class="relative invisible custom-sm:visible"
                >
                    <button
                        @click="toggleDropdown"
                        class="flex items-center text-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-3"
                    >
                        <span class="mr-2 underline">{{
                            $page.props.auth.user.name
                        }}</span>
                        <FontAwesomeIcon
                            icon="fa-solid fa-caret-down"
                            :class="{ 'rotate-180': isDropdownOpen }"
                        />
                    </button>
                    <!-- Dropdown menu -->
                    <ul
                        v-if="isDropdownOpen"
                        class="absolute right-0 mt-2 py-2 bg-white shadow-md"
                    >
                        <!-- Dropdown items -->
                        <li>
                            <a
                                :href="route('dashboard')"
                                class="block px-4 py-2"
                                >Dashboard</a
                            >
                        </li>
                        <li>
                            <a
                                href="#"
                                @click="logout()"
                                class="block px-4 py-2"
                                >Logout</a
                            >
                        </li>
                    </ul>
                </div>
                <div class="mt-2 invisible custom-sm:visible" v-else>
                    <a
                        :href="route('login')"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 custom-sm:mr-3"
                    >
                        Member Sign In
                    </a>
                </div>

                <!-- Mobile View -->
                <button
                    data-collapse-toggle="navbar-sticky"
                    type="button"
                    class="inline-flex items-center p-2 mr-2 text-sm text-gray-500 rounded-lg custom-sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
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
                class="items-center justify-between hidden w-full custom-sm:flex custom-sm:w-auto custom-sm:order-1 mt-2"
                id="navbar-sticky"
            >
                <ul
                    class="flex flex-col p-4 custom-sm:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 custom-sm:flex-row custom-sm:space-x-8 custom-sm:mt-0 custom-sm:border-0 custom-sm:bg-white"
                >
                    <li>
                        <a
                            :href="route('home')"
                            class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'home'
                                    ? 'text-blue-700 font-semibold'
                                    : 'text-gray-900'
                            "
                            >Home</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.about-us')"
                            class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'about-us'
                                    ? 'text-blue-700 font-semibold'
                                    : 'text-gray-900'
                            "
                            >About Us</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.mentorship')"
                            class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'mentorship'
                                    ? 'text-blue-700 font-semibold'
                                    : 'text-gray-900'
                            "
                            >Mentorship</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.opportunities')"
                            class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'opportunities'
                                    ? 'text-blue-700 font-semibold'
                                    : 'text-gray-900'
                            "
                            >Opportunities</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.blog')"
                            class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'blog'
                                    ? 'text-blue-700 font-semibold'
                                    : 'text-gray-900'
                            "
                            >Blog</a
                        >
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isMenuOpen" class="custom-sm:hidden bg-gray-50">
            <div
                class="w-full custom-sm:block custom-sm:w-auto"
                id="navbar-default"
            >
                <ul
                    class="font-medium flex flex-col p-4 custom-sm:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 custom-sm:flex-row custom-sm:space-x-8 custom-sm:mt-0 custom-sm:border-0 custom-sm:bg-white"
                >
                    <li>
                        <a
                            :href="route('home')"
                            class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:border-0 custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'home'
                                    ? 'text-white bg-blue-700'
                                    : null
                            "
                            >Home</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.about-us')"
                            class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:border-0 custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'about-us'
                                    ? 'text-white bg-blue-700'
                                    : null
                            "
                            >About Us</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.mentorship')"
                            class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:border-0 custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'mentorship'
                                    ? 'text-white bg-blue-700'
                                    : null
                            "
                            >Mentorship</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('menu.opportunities')"
                            class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:border-0 custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'opportunities'
                                    ? 'text-white bg-blue-700'
                                    : null
                            "
                            >Opportunities</a
                        >
                    </li>
                    <li class="mb-5">
                        <a
                            :href="route('menu.blog')"
                            class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 custom-sm:hover:bg-transparent custom-sm:hover:text-blue-700 custom-sm:p-0"
                            :class="
                                activeMenu === 'blog'
                                    ? 'text-white bg-blue-700'
                                    : null
                            "
                            >Blog</a
                        >
                    </li>
                    <div class="border-b border-gray-300"></div>
                    <li v-if="$page.props.auth.user">
                        <button
                            @click="toggleDropdown"
                            data-dropdown-toggle="dropdownNavbar"
                            class="flex items-center justify-between underline py-2 pl-3 pr-4 text-gray-900 rounded"
                        >
                            {{ $page.props.auth.user.name }}
                            <svg
                                class="w-5 h-5 ml-1"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <ul
                            v-if="isDropdownOpen"
                            class="absolute mt-2 py-2 bg-white shadow-md"
                        >
                            <!-- Dropdown items -->
                            <li>
                                <a
                                    :href="route('dashboard')"
                                    class="block px-4 py-2"
                                    >Dashboard</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    @click="logout()"
                                    class="block px-4 py-2"
                                    >Logout</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li v-else>
                        <a
                            :href="route('login')"
                            class="py-2 pl-3 pr-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm custom-sm:p-0"
                        >
                            Member Sign In
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
    props: {
        pageSetting: {
            type: Object,
            default: () => ({}),
        },
        activeMenu: {
            type: String,
            default: () => "home",
        },
    },
    data() {
        return {
            isMenuOpen: false,
            isDropdownOpen: false,
        };
    },
    methods: {
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        },
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        logout() {
            event.preventDefault();
            Inertia.post(route("logout"));
        },
    },
    mounted() {
        console.log(this.activeMenu);
    },
};
</script>

<style>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
