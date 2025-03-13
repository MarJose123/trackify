import ClientsDataTableDropDown from '@/components/ClientsDataTableDropDown.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Client } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

export const clientColumns: ColumnDef<Client>[] = [
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
                'onUpdate:checked': (value) => row.toggleSelected(!!value),
                ariaLabel: 'Select row',
            }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'company_name',
        enableHiding: false,
        header: () => h('div', {}, 'Company Name'),
        cell: ({ row }) => h('div', {}, row.getValue('company_name')),
    },
    {
        accessorKey: 'name',
        enableHiding: false,
        header: () => h('div', {}, 'Name'),
        cell: ({ row }) => h('div', {}, row.getValue('name')),
    },
    {
        accessorKey: 'status',
        enableHiding: true,
        header: () => h('div', {}, 'Status'),
        cell: ({ row }) => h('div', {}, row.getValue('status')),
    },
    {
        accessorKey: 'currency',
        enableHiding: true,
        header: () => h('div', {}, 'Currency'),
        cell: ({ row }) => h('div', {}, row.getValue('currency')),
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
                h(ClientsDataTableDropDown, {
                    client,
                    onExpand: row.toggleExpanded,
                }),
            );
        },
    },
];
