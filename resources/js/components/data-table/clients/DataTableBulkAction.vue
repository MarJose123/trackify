<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button, buttonVariants } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { api } from '@/lib/axios';
import { router } from '@inertiajs/vue3';
import type { Table } from '@tanstack/vue-table';
import { EllipsisVertical } from 'lucide-vue-next';
import { computed, watch } from 'vue';

interface DataTableViewOptionsProps {
    table: Table<any[]>;
}

const props = defineProps<DataTableViewOptionsProps>();

const selectedRows = computed(() => props.table.getFilteredSelectedRowModel().rows);

const deleteRecord = async () => {
    const ids: any[] = [];
    selectedRows.value.forEach((data: any) => {
        ids.push(data.original.id);
    });
    await api().delete(
        route('clients.bulk.destroy', {
            _query: { ids: ids },
        }),
        { headers: { accept: '*/*' } },
    );
    router.visit(route('clients.list'));
};

watch(selectedRows, (val) => {
    console.log(val);
});
</script>

<template>
    <DropdownMenu :modal="false">
        <DropdownMenuTrigger as-child>
            <Button variant="outline" @click.stop>
                <span class="sr-only">Open menu</span>
                <EllipsisVertical class="h-4 w-4" />
                Bulk Action
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem>
                <AlertDialog>
                    <AlertDialogTrigger @click.stop>Delete {{ selectedRows.length > 1 ? 'Clients' : 'Client' }}</AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                            <AlertDialogDescription>
                                This action cannot be undone. This will permanently delete the record and its related record.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                            <AlertDialogAction :class="buttonVariants({ variant: 'destructive' })" @click="deleteRecord">Continue </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
