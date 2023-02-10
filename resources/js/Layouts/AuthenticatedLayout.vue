<template>
    <div class="min-h-screen bg-white">
        <div class="flex bg-white">
            <div
                class="bg-blue-800 h-screen p-5 pt-8 relative duration-300"
                :class="isOpen ? 'w-72 mr-2' : 'w-20'"
            >
                <FontAwesomeIcon
                    class="bg-blue-800 text-white text-3xl rounded-full absolute -right-3 top-9 border cursor-pointer"
                    icon="fa-solid fa-circle-arrow-left"
                    :class="!isOpen && 'rotate-180'"
                    @click="setIsOpenStatus"
                />
                <div class="inline-flex">
                    <img
                        :class="isOpen && 'object-contain h-32 w-96'"
                        src="../../assets/logo.png"
                    />
                </div>
                <ul class="pt-2" v-for="(menu, index) in Menus">
                    <li
                        :key="index"
                        class="text-gray-300 text-sm flex items-center gap-x-4 cursor-pointer p-2 hover:bg-red-300 rounded-md"
                        :class="menu.spacing ? 'mt-9' : 'mt-2'"
                        @click="menuClicked(menu.route, menu.isLogout)"
                    >
                        <span class="text-2xl block float-left mr-2">
                            <FontAwesomeIcon :icon="menu.icon"
                        /></span>
                        <span
                            class="text-base font-medium flex-1 duration-200"
                            :class="!isOpen && 'hidden'"
                            >{{ menu.title }}</span
                        >
                    </li>
                </ul>
            </div>
            <main class="flex-auto">
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
    components: {
        ApplicationLogo,
        Dropdown,
        DropdownLink,
        BreezeNavLink,
        ResponsiveNavLink,
        Link,
    },
    data() {
        return {
            isOpen: true,
            Menus: [
                {
                    title: "Home",
                    icon: "fa-solid fa-house",
                    route: route("home"),
                },
                {
                    title: "Dashboard",
                    icon: "fa-solid fa-table-columns",
                    route: route("dashboard"),
                },
                {
                    title: "Users",
                    icon: "fa-solid fa-users",
                    route: route("user.index"),
                },
                {
                    title: "Permissions",
                    icon: "fa-solid fa-universal-access",
                    route: route("permission.index"),
                },
                {
                    title: "Roles",
                    icon: "fa-solid fa-people-roof",
                    route: route("role.index"),
                },
                {
                    title: "Post",
                    icon: "fa-solid fa-mail-bulk",
                    route: route("post.index"),
                },
                {
                    title: "Setting",
                    icon: "fa-solid fa-gear",
                    route: route("profile.edit"),
                },
                {
                    title: "Logout",
                    icon: "fa-solid fa-sign-out",
                    route: route("logout"),
                },
            ],
        };
    },
    methods: {
        setIsOpenStatus() {
            this.isOpen = !this.isOpen;
        },
        menuClicked(route, isLogout) {
            if (isLogout) Inertia.post(route);
            else Inertia.visit(route);
        },
    },
};
</script>
