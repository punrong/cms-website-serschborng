<template>
    <Head title="Appointments" />
    <MenuSideBar>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <div
                    class="bg-white shadow sm:rounded-lg px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                >
                    <header>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Appointments
                        </h2>
                    </header>
                </div>
                <DataTable
                    ref="appointmentTbl"
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
                                class="p-button-rounded"
                                style="margin-right: 5px"
                                @click="show(slotProps.data.id)"
                            />
                            <Button
                                v-if="can.edit"
                                icon="pi pi-pencil"
                                class="p-button-rounded p-button-warning"
                                style="margin-right: 5px"
                                @click="edit(slotProps.data.id)"
                            />
                            <Button
                                v-if="can.delete"
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-danger"
                                @click="
                                    confirmSingleDeleteSelected(
                                        slotProps.data.id
                                    )
                                "
                            />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
        <Dialog
            v-model:visible="deleteAppointmentDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle mr-3"
                    style="font-size: 2rem"
                />
                <span
                    >Are you sure you want to delete the selected
                    record(s)?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteAppointmentDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteAppointments"
                />
            </template>
        </Dialog>
        <Toast />
    </MenuSideBar>
</template>

<script>
import route from "ziggy-js";
import { Inertia } from "@inertiajs/inertia";
import DataTable from "../../../components/DataTable.vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import axios from "axios";

export default {
    components: {
        DataTable,
    },
    data() {
        return {
            apiUrl: route("appointment.getData"),
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
            deleteAppointmentDialog: false,
            selectedAppointments: null,
            isDeleteSingleAppointment: false,
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
        addNew() {
            Inertia.get(route("appointment.create"));
        },
        show(id) {
            Inertia.get(route("appointment.show", id));
        },

        edit(id) {
            Inertia.get(route("appointment.edit", id), {
                isTriggeredFromTable: true,
            });
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
        confirmMultipleDeleteSelected() {
            this.deleteAppointmentDialog = true;
        },
        confirmSingleDeleteSelected(id) {
            this.deleteAppointmentDialog = true;
            this.isDeleteSingleAppointment = true;
            this.deleteId = id;
        },
        deleteAppointments() {
            if (this.isDeleteSingleAppointment)
                axios
                    .delete(route("appointment.destroy", this.deleteId))
                    .then((res) => {
                        if (res.data.success)
                            this.$refs.appointmentTbl.loadLazyData();
                    })
                    .catch((err) => {
                        this.$toast.add({
                            severity: "error",
                            summary: "Error Message",
                            detail: err.response.data.message,
                            life: 3000,
                        });
                    });
            else
                axios
                    .delete(
                        route("appointment.deleteMultipleRecord", {
                            appointmentList: this.selectedAppointments,
                        })
                    )
                    .then((res) => {
                        if (res.data.success)
                            this.$refs.appointmentTbl.loadLazyData();
                    })
                    .catch((err) => {
                        this.$toast.add({
                            severity: "error",
                            summary: "Error Message",
                            detail: err.response.data.message,
                            life: 3000,
                        });
                    });

            this.deleteId = null;
            this.selectedAppointments = null;
            this.isDeleteSingleAppointment = false;
            this.deleteAppointmentDialog = false;
        },
        deleteBtnStatus(val) {
            this.selectedAppointments = val;
        },
    },

    created() {
        this.initFilters();
    },
};
</script>
