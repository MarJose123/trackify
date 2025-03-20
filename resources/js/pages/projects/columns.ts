import DataTableSingleRowAction from '@/components/data-table/projects/DataTableSingleRowAction.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Client } from '@/types/clients';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

export const projectColumns: ColumnDef<Client>[] = [
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                checked: table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
                'onUpdate:checked': (value) => table.toggleAllRowsSelected(!!value),
                ariaLabel: 'Select all',
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                checked: row.getIsSelected(),
                onClick: (e: any) => e.stopPropagation(),
                'onUpdate:checked': (value) => row.toggleSelected(!!value),
                ariaLabel: 'Select row',
            }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'client.name',
        enableHiding: false,
        header: () => h('div', {}, 'client.name'),
        cell: ({ row }) => h('div', {}, row.getValue('client.name')),
    },
    {
        accessorKey: 'name',
        enableHiding: false,
        header: () => h('div', {}, 'Name'),
        cell: ({ row }) => h('div', {}, row.getValue('name')),
    },
    {
        accessorKey: 'status',
        enableHiding: false,
        header: () => h('div', {}, 'Status'),
        cell: ({ row }) => h('div', {}, row.getValue('status')),
    },
    {
        accessorKey: 'actions',
        enableHiding: false,
        header: () => h('div', { class: '' }, ''),
        cell: ({ row }) => {
            const client = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DataTableSingleRowAction, {
                    client,
                    onExpand: row.toggleExpanded,
                }),
            );
        },
    },
];
