<template>
    <Head title="My Appointments" />
    <MenuSideBar>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <div
                    class="bg-white shadow sm:rounded-lg px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                >
                    <header>
                        <h2 class="text-2xl font-bold text-gray-900">
                            My Appointments
                        </h2>
                    </header>
                </div>
                <DataTable
                    ref="myAppointmentTbl"
                    :apiUrl="apiUrl"
                    :columnFilters="filters"
                    :searchableColumns="searchableCols"
                >
                    <Column
                        selectionMode="multiple"
                        headerStyle="width: 3em"
                    ></Column>
                    <Column
                        field="mentee_id"
                        header="Mentee"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #body="slotProps">
                            <span>{{
                                slotProps.data.mentee
                                    ? slotProps.data.mentee.name
                                    : ""
                            }}</span>
                        </template>
                    </Column>
                    <Column
                        field="mentor_id"
                        header="Mentor"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #body="slotProps">
                            <span>{{
                                slotProps.data.mentor
                                    ? slotProps.data.mentor.name
                                    : ""
                            }}</span>
                        </template>
                    </Column>
                    <Column
                        field="method"
                        header="Method"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="methods"
                                placeholder="Any"
                                class="p-column-filter"
                                :showClear="true"
                            >
                            </Dropdown>
                        </template>
                    </Column>
                    <Column
                        field="opportunity_id"
                        header="Opportunity"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                        <template #body="slotProps">
                            <span>{{
                                slotProps.data.opportunity
                                    ? slotProps.data.opportunity.title
                                    : ""
                            }}</span>
                        </template>
                    </Column>
                    <Column
                        field="appointment_datetime"
                        header="Appointment Datetime"
                        :sortable="true"
                        style="min-width: 12rem"
                    >
                    </Column>
                    <Column
                        field="status"
                        header="Status"
                        :filterMenuStyle="{ width: '14rem' }"
                        style="min-width: 12rem"
                    >
                        <template #body="slotProps">
                            <span
                                :class="
                                    'text-white p-2 rounded-md ' +
                                    (slotProps.data.status === 'ACP'
                                        ? 'bg-green-500'
                                        : 'bg-red-500')
                                "
                                >{{ slotProps.data.status }}</span
                            >
                        </template>
                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="statuses"
                                placeholder="Any"
                                class="p-column-filter"
                                :showClear="true"
                            >
                            </Dropdown>
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
                                class="p-button-rounded bg-[#0078d4]"
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
import { Inertia } from "@inertiajs/inertia";
import DataTable from "../../../components/DataTable.vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";

export default {
    components: {
        DataTable,
    },
    data() {
        return {
            apiUrl: route("my-appointment.getData"),
            searchableCols: [
                "mentee_id",
                "mentor_id",
                "method",
                "opportunity_id",
                "appointment_datetime",
            ],
            statuses: ["ACP", "PND", "DSBL"],
            methods: ["ZOOM", "EMAIL", "IN_PERSON"],
            filters: null,
        };
    },
    methods: {
        show(id) {
            Inertia.get(route("my-appointment.show", id));
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                method: {
                    operator: FilterOperator.OR,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                status: {
                    operator: FilterOperator.OR,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.EQUALS },
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
