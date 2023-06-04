import "tw-elements";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faCircleArrowLeft, faSignOut, faHouse, faTableColumns, faUsers, faUniversalAccess, faPeopleRoof, faMailBulk, faGear, faLayerGroup, faPersonChalkboard, faUser, faCaretDown, faEnvelope, faPhone } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { createApp, h } from 'vue';
import { createInertiaApp, Head } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { plugin as _plugin, defaultConfig } from '@formkit/vue'
import PrimeVue from 'primevue/config';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Dialog from 'primevue/dialog';
import MenuSideBar from "@/Layouts/MenuSideBar.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import MultiSelect from 'primevue/multiselect';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/themes/fluent-light/theme.css';
import { createFormKitInputsPlugin } from "@kgierke/formkit-inputs";
import SwiperCore, { Navigation, Pagination } from 'swiper';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Sers Chborng';
const formKitInputPlugin = createFormKitInputsPlugin();

library.add(faHouse, faCircleArrowLeft, faSignOut, faTableColumns, faUsers, faUniversalAccess, faPeopleRoof, faMailBulk, faGear, faLayerGroup, faPersonChalkboard, faUser, faCaretDown, faEnvelope, faPhone);

SwiperCore.use([Navigation, Pagination]);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue)
            .use(_plugin, defaultConfig({
                config: {
                    theme: 'genesis',
                },
                plugins: [formKitInputPlugin],
            }))
            .use(ToastService)
            .component("Column", Column)
            .component("MenuSideBar", MenuSideBar)
            .component("GuestLayout", GuestLayout)
            .component("Button", Button)
            .component("InputText", InputText)
            .component("Dropdown", Dropdown)
            .component("Dialog", Dialog)
            .component("MultiSelect", MultiSelect)
            .component("FontAwesomeIcon", FontAwesomeIcon)
            .component("Head", Head)
            .component("Toast", Toast)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
