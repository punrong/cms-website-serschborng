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
                    @addNew="addNew"
                    @confirmMultipleDeleteSelected="
                        confirmMultipleDeleteSelected
                    "
                    @deleteBtnStatus="deleteBtnStatus"
                >
                    <Column
                        v-if="can.delete"
                        selectionMode="multiple"
                        headerStyle="width: 3em"
                    ></Column>
                    <Column
                        field="id"
                        header="ID"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #body="{ data }">
                            {{ data.id }}
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
                </DataTable>
            </div>
        </div>
        <Toast />
    </MenuSideBar>
</template>

<script>
import route from "ziggy-js";
import DataTable from "../../../components/DataTable.vue";
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
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
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
