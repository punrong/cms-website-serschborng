<template>
    <Head title="User" />
    <MenuSideBar>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <div
                    class="bg-white shadow sm:rounded-lg px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                >
                    <header>
                        <h2 class="text-2xl font-bold text-gray-900">Users</h2>
                    </header>
                </div>
                <DataTable
                    ref="userTbl"
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
                                placeholder="Search by name"
                            />
                        </template>
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
                                    (slotProps.data.status === 'ACT'
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
                                <template #value="slotProps">
                                    <span v-if="slotProps.value">{{
                                        slotProps.value
                                    }}</span>
                                    <span v-else>{{
                                        slotProps.placeholder
                                    }}</span>
                                </template>
                                <template #option="slotProps">
                                    <span>{{ slotProps.option }}</span>
                                </template>
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
            v-model:visible="deleteUsersDialog"
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
                    @click="deleteUsersDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteUsers"
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
            apiUrl: route("user.getData"),
            searchableCols: ["name", "email"],
            statuses: ["ACT", "PND", "DSBL"],
            filters: null,
            deleteUsersDialog: false,
            selectedUsers: null,
            isDeleteSingleUser: false,
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
            Inertia.get(route("user.create"));
        },
        show(id) {
            Inertia.get(route("user.show", id));
        },

        edit(id) {
            Inertia.get(route("user.edit", id), { isTriggeredFromTable: true });
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
                status: {
                    operator: FilterOperator.OR,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.EQUALS },
                    ],
                },
            };
        },
        confirmMultipleDeleteSelected() {
            this.deleteUsersDialog = true;
        },
        confirmSingleDeleteSelected(id) {
            this.deleteUsersDialog = true;
            this.isDeleteSingleUser = true;
            this.deleteId = id;
        },
        deleteUsers() {
            if (this.isDeleteSingleUser)
                axios
                    .delete(route("user.destroy", this.deleteId))
                    .then((res) => {
                        if (res.data.success) this.$refs.userTbl.loadLazyData();
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
                        route("user.deleteMultipleRecord", {
                            userList: this.selectedUsers,
                        })
                    )
                    .then((res) => {
                        if (res.data.success) this.$refs.userTbl.loadLazyData();
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
            this.selectedUsers = null;
            this.isDeleteSingleUser = false;
            this.deleteUsersDialog = false;
        },
        deleteBtnStatus(val) {
            this.selectedUsers = val;
        },
    },

    created() {
        this.initFilters();
    },
};
</script>

<style scoped></style>
