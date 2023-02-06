<template>
    <DataTable
        class="p-datatable-sm"
        :value="records"
        :lazy="true"
        :auto-layout="true"
        :paginator="true"
        :rows="10"
        :filters="filters"
        v-model:filters="filters"
        v-model:selection="selectedRecords"
        ref="dt"
        :loading="loading"
        :total-records="totalRecords"
        :globalFilterFields="searchableColumns"
        removableSort
        stripedRows
        showClearButton
        @page="onPage"
        @sort="onSort"
        @filter="onFilter"
        filter-display="menu"
        responsive-layout="scroll"
        breakpoint="960px"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} records"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[10, 20, 25, 50, 100]"
    >
        <template #loading> Loading... </template>
        <template #header>
            <div class="flex flex-wrap gap-2 justify-between items-center">
                <div>
                    <div class="flex items-center gap-2">
                        <Button
                            @click="loadLazyData"
                            class="p-button-text p-button-plain"
                            icon="pi pi-refresh"
                        />
                        <slot name="header">
                            <h5 class="font-semibold">{{ title }}</h5>
                        </slot>
                    </div>
                </div>
                <div class="p-input-icon-left max-w-[360px]">
                    <i v-if="!filters['global'].value" class="pi pi-search" />
                    <i
                        v-else
                        v-if="filters['global'].value"
                        class="pi pi-times"
                        @click="
                            filters['global'].value = null;
                            onFilter();
                        "
                    ></i>
                    <InputText
                        v-model="filters['global'].value"
                        @input="debounce(onFilter, 500)"
                        placeholder="Keyword Search"
                    />
                </div>
            </div>
        </template>
        <template #empty>
            <p class="text-center">No records found.</p>
        </template>
        <slot></slot>
    </DataTable>
</template>

<script lang="ts">
import { defineComponent, onMounted, Ref, ref, toRef, watch } from "vue";
import { useDebounce } from "../debouce";
import axios from "axios";
import DataTable from "primevue/datatable";

export default defineComponent({
    name: "PrimeDatatables",
    components: {
        DataTable,
    },
    props: {
        apiUrl: String,
        title: String,
        refresh: String,
        searchableColumns: {
            type: Array,
            default: [],
        },
        columnFilters: {
            required: true,
            type: Object,
            default: {},
        },
    },
    setup(props, context) {
        onMounted(async () => {
            loading.value = true;

            if (!lazyParams.value) {
                lazyParams.value = {
                    first: 0,
                    filters: filters.value,
                    rows: 10,
                };
            }
            lazyParams.value.page = Math.fround(
                parseInt(lazyParams.value.first) /
                    parseInt(lazyParams.value.rows || 10)
            );

            await loadLazyData();
        });
        const refresh = toRef(props, "refresh");
        watch(refresh, (val) => {
            loadLazyData();
        });
        const dt = ref();
        const debounce = useDebounce();
        const loading = ref(false);
        const totalRecords = ref(0);
        const records = ref();
        const filtersProp = toRef(props, "columnFilters");
        const selectedRecords = ref([]);
        watch(selectedRecords, (val) =>{
            context.emit('deleteBtnStatus', val)
        })
        const filters = ref({});
        filters.value = {
            ...filtersProp.value,
        };
        const searchableColumns = toRef(props, "searchableColumns") as Ref<
            Array<string>
        >;
        const lazyParams: Ref<any> = ref({});
        const apiUrl = toRef(props, "apiUrl") as Ref<string>;
        const loadLazyData = async () => {
            loading.value = true;

            try {
                const res = await axios.get(apiUrl.value, {
                    params: {
                        dt_params: JSON.stringify(lazyParams.value),
                        searchable_columns: JSON.stringify(searchableColumns.value),
                        sortField: lazyParams.value.sortField,
                        sortOrder: lazyParams.value.sortOrder
                    },
                });

                records.value = res.data.payload.data;
                totalRecords.value = res.data.payload.total;
                loading.value = false;
            } catch (e) {
                records.value = [];
                totalRecords.value = 0;
                loading.value = false;
            }
        };
        const onPage = (event) => {
            lazyParams.value = event;
            lazyParams.value.filters = filters.value;
            loadLazyData();
        };
        const onSort = (event) => {
            lazyParams.value = event;
            if(lazyParams.value.sortField)
                if(lazyParams.value.sortOrder == 1)
                    lazyParams.value.sortOrder = 'desc'
                else
                    lazyParams.value.sortOrder = 'asc'
            lazyParams.value.filters = {
                first: 0,
                filters: filters.value,
                rows: 10,
            };
            loadLazyData();
        };
        const onFilter = () => {
            lazyParams.value.filters = filters.value;
            // reset pagination
            lazyParams.value.originalEvent = { first: 0, page: 0 };
            onPage(lazyParams.value);
        };

        const exportCSV = () => {
            dt.value.exportCSV()
        }

        return {
            dt,
            loading,
            totalRecords,
            records,
            filters,
            selectedRecords,
            lazyParams,
            loadLazyData,
            onPage,
            onSort,
            onFilter,
            debounce,
            exportCSV,
        };
    },
});
</script>

<style scoped></style>
