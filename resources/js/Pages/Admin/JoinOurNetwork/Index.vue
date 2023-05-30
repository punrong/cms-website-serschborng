<template>
    <Head title="Join Our Networks" />
    <MenuSideBar>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <div
                    class="bg-white shadow sm:rounded-lg px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                >
                    <header>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Join Our Networks
                        </h2>
                    </header>
                </div>
                <DataTable
                    ref="joinOurNetworktbl"
                    :apiUrl="apiUrl"
                    :columnFilters="filters"
                    :searchableColumns="searchableCols"
                    :can="can"
                >
                    <Column
                        v-if="can.delete"
                        selectionMode="multiple"
                        headerStyle="width: 3em"
                    ></Column>
                    <Column
                        field="name"
                        header="Name"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText
                                type="text"
                                v-model="filterModel.value"
                                class="p-column-filter"
                                placeholder="Search by name"
                            />
                        </template>
                    </Column>
                    <Column
                        field="email"
                        header="Email"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #body="{ data }">
                            {{ data.email }}
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText
                                type="text"
                                v-model="filterModel.value"
                                class="p-column-filter"
                                placeholder="Search by email"
                            />
                        </template>
                    </Column>
                    <Column
                        field="actions"
                        header="Actions"
                        :exportable="false"
                        style="min-width: 8rem"
                    >
                        <template #body="slotProps">
                            <Button
                                icon="pi pi-eye"
                                class="p-button-rounded"
                                style="margin-right: 5px"
                                @click="show(slotProps.data.id)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
        <Toast />
    </MenuSideBar>
</template>

<script>
import route from "ziggy-js";
import DataTable from "../../../components/DataTable.vue";
import { Inertia } from "@inertiajs/inertia";
import { FilterMatchMode, FilterOperator } from "primevue/api";

export default {
    components: {
        DataTable,
    },
    data() {
        return {
            apiUrl: route("join-our-networks.getData"),
            searchableCols: ["name", "email", "phone_number"],
            statuses: ["ACT", "DSBL"],
            filters: null,
            selectedMentors: null,
            deleteId: null,
        };
    },
    props: {
        can: {
            type: Object,
            default: () => ({}),
        },
    },

    methods: {
        show(id) {
            Inertia.get(route("join-our-networks.show", id));
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                email: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
            };
        },
    },

    created() {
        this.initFilters();
    },
};
</script>
