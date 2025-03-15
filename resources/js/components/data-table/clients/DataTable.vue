<script setup lang="ts" generic="TData, TValue">
import DataTableFilterOption from '@/components/data-table/clients/DataTableFilterOption.vue';
import DataTablePagination from '@/components/data-table/clients/DataTablePagination.vue';
import DataTableViewOptions from '@/components/data-table/clients/DataTableViewOptions.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import eventBus from '@/lib/eventBus';
import { cn, valueUpdater } from '@/lib/utils';
import { Pagination } from '@/types/pagination';
import { router } from '@inertiajs/vue3';
import type { ColumnDef, ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@tanstack/vue-table';
import { FlexRender, getCoreRowModel, getExpandedRowModel, getFilteredRowModel, getSortedRowModel, useVueTable } from '@tanstack/vue-table';
import { UserPlus } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps<{
    columns: ColumnDef<any>[];
    data: Pagination;
}>();

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({
    Currency: false,
    'Billing Method': false,
});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});
const pagination = ref({
    pageIndex: 0,
    pageSize: 5,
});

const table = useVueTable({
    get data() {
        return props.data.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    // getPaginationRowModel: getPaginationRowModel(), //not needed for server-side pagination
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) => valueUpdater(updaterOrValue, expanded),
    onPaginationChange: (updateOrValue) => valueUpdater(updateOrValue, pagination),
    manualPagination: true,
    rowCount: props.data.total,

    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
        get pagination() {
            return pagination.value;
        },
    },
});

watch(pagination, (val) => {
    eventBus.emit('client-table-pagination-change', val);
});
</script>

<template>
    <div class="w-full">
        <div class="flex items-center gap-2 py-4">
            <Input
                class="max-w-[250px]"
                placeholder="Search Company..."
                :model-value="table.getColumn('company_name')?.getFilterValue() as string"
                @update:model-value="table.getColumn('company_name')?.setFilterValue($event)"
            />
            <div class="ml-auto flex-row flex-wrap space-x-1">
                <Button variant="outline" @click.prevent="router.visit(route('clients.create'))">
                    <UserPlus class="mr-1 h-4 w-4" />
                    Add
                </Button>
                <DataTableFilterOption />
                <DataTableViewOptions :table="table" />
            </div>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead
                            v-for="header in headerGroup.headers"
                            :key="header.id"
                            :data-pinned="header.column.getIsPinned()"
                            :class="
                                cn(
                                    { 'sticky bg-background/95': header.column.getIsPinned() },
                                    header.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
                                )
                            "
                        >
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() ? 'selected' : undefined">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="row.getIsExpanded()">
                                <TableCell :colspan="row.getAllCells().length">
                                    {{ JSON.stringify(row.original) }}
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>

                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center"> No results. </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <DataTablePagination :table="table" />
    </div>
</template>

<style scoped></style>
