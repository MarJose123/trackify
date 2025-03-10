import ClientsDataTableDropDown from '@/components/ClientsDataTableDropDown.vue';
import { Client } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

export const clientColumns: ColumnDef<Client>[] = [
    {
        accessorKey: 'company_name',
        header: () => h('div', {}, 'Company Name'),
        cell: ({ row }) => h('div', {}, row.getValue('company_name')),
    },
    {
        accessorKey: 'name',
        header: () => h('div', {}, 'Name'),
        cell: ({ row }) => h('div', {}, row.getValue('name')),
    },
    {
        accessorKey: 'status',
        header: () => h('div', {}, 'Status'),
        cell: ({ row }) => h('div', {}, row.getValue('status')),
    },
    {
        accessorKey: 'currency',
        header: () => h('div', {}, 'Currency'),
        cell: ({ row }) => h('div', {}, row.getValue('currency')),
    },
    {
        accessorKey: 'actions',
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
