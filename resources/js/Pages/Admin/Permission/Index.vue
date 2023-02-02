<template>
    <Head title="Permission" />
    <AuthenticatedLayout>
        <template #header>
            <h4 class="font-black text-2xl">Permission</h4>
        </template>
        <div class="mx-auto flex container items-center justify-center mt-4">
            <div class="rounded w-full p-2 bg-white">
                <Toolbar class="mb-4">
                    <template #start>
                        <FormKit
                            type="button"
                            label="New"
                            @click="addNew"
                            :classes="{
                                outer: 'm-0',
                                input: 'bg-blue-500 rounded-md text-white font-bold px-3 py-2 w-auto mr-2',
                            }"
                        />
                        <FormKit
                            type="button"
                            label="Delete"
                            @click="confirmMultipleDeleteSelected"
                            :disabled="!selectedPermissions || !selectedPermissions.length"
                            :classes="{
                                outer: 'm-0',
                                input: (!selectedPermissions || !selectedPermissions.length) ? 'bg-red-500 rounded-md text-white font-bold px-3 py-2 w-auto mr-2 opacity-50' : 'bg-red-500 rounded-md text-white font-bold px-3 py-2 w-auto mr-2',
                            }"
                        />
                    </template>

                    <template #end>
                        <FormKit
                            type="button"
                            label="Export"
                            @click="exportCSV($event)"
                            :classes="{
                                outer: 'm-0',
                                input: 'bg-green-500 rounded-md text-white font-bold px-3 py-2 w-auto mr-2',
                            }"
                        />
                    </template>
                </Toolbar>
                <DataTable
                    ref="permissionTbl"
                    :apiUrl="apiUrl"
                    :columnFilters="filters"
                    :searchableColumns="searchableCols"
                    :rowHover="true"
                    @deleteBtnStatus="deleteBtnStatus"
                >
                    <Column
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
                        field="status"
                        header="Status"
                        :filterMenuStyle="{ width: '14rem' }"
                        style="min-width: 12rem"
                        :sortable="true"
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
                        v-if="can.edit | can.delete"
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
            v-model:visible="deletePermissionsDialog"
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
                    @click="deletePermissionsDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deletePermissions"
                />
            </template>
        </Dialog>
    </AuthenticatedLayout>
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
            apiUrl: route("permission.getData"),
            searchableCols: ["name", "status"],
            statuses: ["ACT", "DSBL"],
            filters: null,
            deletePermissionsDialog: false,
            selectedPermissions: null,
            isDeleteSinglePermission: false,
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
            Inertia.get(route("permission.create"));
        },
        show(id) {
            Inertia.get(route("permission.show", id));
        },

        edit(id) {
            Inertia.get(route("permission.edit", id), {isTriggeredFromTable: true});
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
                status: {
                    operator: FilterOperator.OR,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.EQUALS },
                    ],
                },
            };
        },
        confirmMultipleDeleteSelected() {
            this.deletePermissionsDialog = true;
        },
        confirmSingleDeleteSelected(id) {
            this.deletePermissionsDialog = true;
            this.isDeleteSinglePermission = true;
            this.deleteId = id;
        },
        deletePermissions() {
            if (this.isDeleteSinglePermission)
                axios
                    .delete(route("permission.destroy", this.deleteId))
                    .then((res) => {
                        if (res.data.success) this.$refs.permissionTbl.loadLazyData();
                    });
            else
                axios
                    .delete(
                        route("permission.deleteMultipleRecord", {
                            permissionList: this.selectedPermissions,
                        })
                    )
                    .then((res) => {
                        if (res.data.success) this.$refs.permissionTbl.loadLazyData();
                    })
                    .catch((err) => console.log(err));

            this.deleteId = null;
            this.selectedPermissions = null;
            this.isDeleteSinglePermission = false;
            this.deletePermissionsDialog = false;
        },
        exportCSV() {
            this.$refs.permissionTbl.exportCSV();
        },
        deleteBtnStatus(val) {
            this.selectedPermissions = val;
        },
    },

    created() {
        this.initFilters();
    },
};
</script>

<style scoped></style>
