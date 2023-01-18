<template>
    <Head title="Role" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Role
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Toolbar class="mb-4">
                        <template #start>
                            <Button
                                label="New"
                                icon="pi pi-plus"
                                class="p-button-success"
                                style="margin-right: 5px"
                                @click="addNew"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-trash"
                                class="p-button-danger"
                                @click="confirmDeleteSelected"
                                :disabled="
                                    !selectedProducts ||
                                    !selectedProducts.length
                                "
                            />
                        </template>

                        <template #end>
                            <Button
                                label="Export"
                                icon="pi pi-upload"
                                @click="exportCSV($event)"
                            />
                        </template>
                    </Toolbar>
                    <DataTable
                        ref="roleDataTable"
                        :value="roles.data"
                        dataKey="id"
                        :paginator="true"
                        :rows="5"
                        :filters="filters"
                        removableSort
                        stripedRows
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[5, 10, 25]"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
                        v-model:filters="filters"
                        v-model:selection="selectedProducts"
                        filterDisplay="menu"
                        responsiveLayout="scroll"
                        :globalFilterFields="['name', 'status']"
                    >
                        <template #header>
                            <div class="flex justify-between">
                                <Button
                                    type="button"
                                    icon="pi pi-filter-slash"
                                    label="Clear"
                                    class="p-button-outlined"
                                    @click="clearFilter()"
                                />
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Keyword Search"
                                    />
                                </span>
                            </div>
                        </template>
                        <template #empty> No customers found. </template>
                        <template #loading>
                            Loading customers data. Please wait.
                        </template>
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
                                        'product-badge text-white p-2 ' +
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
                                        <span
                                            :class="
                                                'customer-badge status-' +
                                                slotProps.value
                                            "
                                            v-if="slotProps.value"
                                            >{{ slotProps.value }}</span
                                        >
                                        <span v-else>{{
                                            slotProps.placeholder
                                        }}</span>
                                    </template>
                                    <template #option="slotProps">
                                        <span
                                            :class="
                                                'customer-badge status-' +
                                                slotProps.option
                                            "
                                            >{{ slotProps.option }}</span
                                        >
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
                                    @click="destory(slotProps.data.id)"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
        <Dialog
            v-model:visible="deleteProductsDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="props.roles.data"
                    >Are you sure you want to delete the selected
                    products?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteProductsDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteSelectedProducts"
                />
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { FilterMatchMode, FilterOperator } from "primevue/api";

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
});

function addNew() {
    Inertia.get(route("role.create"));
}

function show(id) {
    Inertia.get(route("role.show", id));
}

function edit(id) {
    Inertia.get(route("role.edit", id));
}

function destory(id) {
    if (confirm("Are you sure you want to Delete")) {
        Inertia.delete(route("role.destroy", id));
    }
}
</script>
<script>
export default {
    data() {
        return {
            filters: null,
            statuses: ["DSLB", "ACT"],
            selectedProducts: null,
            deleteProductsDialog: false,
            // lazyParams: {},
            // loading: false,
        };
    },
    created() {
        this.initFilters();
    },
    // mounted(){
    //     this.loading = true;
    //     this.lazyParams = {
    //         first: 0,
    //         rows: this.$refs.roleDataTable.rows,
    //         sortField: null,
    //         sortOrder: null,
    //         filters: this.filters
    //     };
    // },
    methods: {
        clearFilter() {
            this.initFilters();
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
        exportCSV() {
            this.$refs.roleDataTable.exportCSV();
        },
        confirmDeleteSelected() {
            this.deleteProductsDialog = true;
        },
        deleteSelectedProducts() {
            Inertia.delete(
                route("role.deletemultiple", {
                    roleList: this.selectedProducts,
                })
            );
            this.deleteProductsDialog = false;
            this.selectedProducts = null;
        },
        // onPage(event) {
        //     this.lazyParams = event;
        //     this.loadLazyData();
        // },
        // onSort(event) {
        //     this.lazyParams = event;
        //     this.loadLazyData();
        // },
        // onFilter() {
        //     this.lazyParams.filters = this.filters;
        //     this.loadLazyData();
        // },
        // loadLazyData() {
        //     this.loading = true;

        //     setTimeout(() => {
        //         this.customerService.getCustomers(
        //             {lazyEvent: JSON.stringify( this.lazyParams )})
        //                 .then(data => {
        //                     this.customers = data.customers;
        //                     this.totalRecords = data.totalRecords;
        //                     this.loading = false;
        //             }
        //         );
        //     }, Math.random() * 1000 + 250);
        // },
    },
};
</script>
