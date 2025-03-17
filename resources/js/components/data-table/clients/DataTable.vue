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
import type { ColumnDef, VisibilityState } from '@tanstack/vue-table';
import { FlexRender, getCoreRowModel, getExpandedRowModel, getFilteredRowModel, getSortedRowModel, useVueTable } from '@tanstack/vue-table';
import { refDebounced } from '@vueuse/core';
import { Search, UserPlus } from 'lucide-vue-next';
import { ref, shallowRef, watch } from 'vue';

const props = defineProps<{
    columns: ColumnDef<any>[];
    data: Pagination;
}>();

const columnFilters = shallowRef<any | undefined>(undefined);
const debouncedColumnFilters = refDebounced(columnFilters, 1000);

const columnVisibility = ref<VisibilityState>({
    Currency: false,
    'Billing Method': false,
});
const rowSelection = ref({});
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
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onPaginationChange: (updateOrValue) => valueUpdater(updateOrValue, pagination),
    manualPagination: true,
    rowCount: props.data.total,

    state: {
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get pagination() {
            return pagination.value;
        },
    },
});

watch(pagination, (val) => {
    eventBus.emit('client-table-pagination-change', val);
});
watch(debouncedColumnFilters, (val) => {
    eventBus.emit('client-table-search', val);
});
</script>

<template>
    <div class="w-full">
        <div class="flex items-center gap-2 py-4">
            <div class="relative w-full max-w-sm items-center">
                <Input class="max-w-[250px] pl-9" placeholder="Search Company or name..." v-model:model-value="columnFilters" />
                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-2">
                    <Search class="size-6 text-muted-foreground" />
                </span>
            </div>
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
                            <TableRow
                                :data-state="row.getIsSelected() ? 'selected' : undefined"
                                @click.stop="router.visit(route('clients.show', row.original.id))"
                            >
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
