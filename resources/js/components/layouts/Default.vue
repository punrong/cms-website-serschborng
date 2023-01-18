<template>
    <div class="flex">
        <div
            class="bg-blue-800 h-screen p-5 pt-8 relative duration-300"
            :class="isOpen ? 'w-72' : 'w-20'"
        >
            <FontAwesomeIcon
                class="bg-blue-800 text-white text-3xl rounded-full absolute -right-3 top-9 border cursor-pointer"
                icon="fa-solid fa-circle-arrow-left"
                :class="!isOpen && 'rotate-180'"
                @click="setIsOpenStatus"
            />
            <div class="inline-flex">
                <img :class="isOpen && 'object-contain h-32 w-96'" src="../../../assets/logo.png">
            </div>
            <div class="flex items-center rounded-md bg-slate-500 py-2">
                <FontAwesomeIcon
                    class="text-white text-lg block float-left cursor-pointer mr-2"
                    icon="fa-solid fa-search"
                    :class="(isOpen ? 'px-4' : 'px-2.5', isOpen && 'mr-2 ml-2')"
                />
                <input
                    type="search"
                    placeholder="Search"
                    class="text-base bg-transparent w-full text-white focus:outline-none"
                    :class="!isOpen && 'hidden'"
                />
            </div>
            <ul class="pt-2" v-for="(menu, index) in Menus">
                <li
                    v-if="!menu.isLogout"
                    :key="index"
                    class="text-gray-300 text-sm flex items-center gap-x-4 cursor-pointer p-2 hover:bg-red-300 rounded-md"
                    :class="menu.spacing ? 'mt-9' : 'mt-2'"
                    @click="setSubMenuOpen(menu.submenu)"
                >
                    <span class="text-2xl block float-left mr-2">
                        <FontAwesomeIcon
                            :icon="menu.icon"
                    /></span>
                    <span
                        class="text-base font-medium flex-1 duration-200"
                        :class="!isOpen && 'hidden'"
                        >{{ menu.title }}</span
                    >
                    <FontAwesomeIcon
                        v-if="menu.submenu && isOpen"
                        icon="fa-solid fa-circle-arrow-left mr-2"
                        :class="!subMenuOpen ? 'rotate-[-90deg]' : 'rotate-90'"
                    />
                </li>
                <ul v-if="menu.submenu && subMenuOpen && isOpen">
                    <li
                        v-for="(submenu, index) in menu.submenuItems"
                        :key="index"
                        class="text-gray-300 text-sm flex items-center gap-x-4 cursor-pointer p-2 px-5 hover:bg-red-300 rounded-md"
                    >
                        {{ submenu.title }}
                    </li>
                </ul>
                <li
                    v-if="menu.title == 'Logout'"
                    :key="index"
                    class="text-gray-300 text-sm flex items-center gap-x-4 cursor-pointer p-2 hover:bg-red-300 rounded-md mt-2"
                    @click="logout"
                >
                    <span class="text-2xl block float-left mr-2">
                        <FontAwesomeIcon
                            :icon="menu.icon"
                    /></span>
                    <span
                        class="text-base font-medium flex-1 duration-200"
                        :class="!isOpen && 'hidden'"
                        >{{ menu.title }}</span
                    >
                </li>
            </ul>
        </div>
        <div class="p-7">
            <h1>Hello world</h1>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import axios from "axios";
export default {
    name: "default-layout",
    data() {
        return {
            isOpen: true,
            subMenuOpen: false,
            Menus: [
                { title: "Dashboard", icon: "fa-solid fa-circle-arrow-left" },
                { title: "Pages", icon: "fa-solid fa-circle-arrow-left" },
                { title: "Media",icon: "fa-solid fa-circle-arrow-left", spacing: true },
                {
                    title: "Projects",
                    icon: "fa-solid fa-circle-arrow-left",
                    submenu: true,
                    submenuItems: [
                        { title: "Submenu 1" },
                        { title: "Submenu 2" },
                        { title: "Submenu 3" },
                    ],
                },
                { title: "Analytics", icon: "fa-solid fa-circle-arrow-left" },
                { title: "Inbox", icon: "fa-solid fa-circle-arrow-left" },
                { title: "Profile", icon: "fa-solid fa-circle-arrow-left", spacing: true },
                { title: "Setting", icon: "fa-solid fa-circle-arrow-left" },
                { title: "Logout", icon: "fa-solid fa-sign-out", isLogout: true },
            ],
            user: this.$store.state.auth.user,
        };
    },
    methods: {
        setIsOpenStatus() {
            this.isOpen = !this.isOpen;
        },
        setSubMenuOpen(hasSubmenu) {
            if(hasSubmenu)
                this.subMenuOpen = !this.subMenuOpen;
        },
        ...mapActions({
            signOut: "auth/logout",
        }),
        async logout() {
            await axios.post("/logout").then(({ data }) => {
                this.signOut();
                this.$router.push({ name: "login" });
            });
        },
    },
};
</script>
