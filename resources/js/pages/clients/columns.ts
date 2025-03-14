import ClientsDataTableDropDown from '@/components/client/DataTableDropDown.vue';
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
        id: 'Name',
        enableHiding: false,
        header: () => h('div', {}, 'Name'),
        cell: ({ row }) => h('div', {}, row.getValue('name')),
    },
    {
        accessorKey: 'status',
        id: 'Status',
        enableHiding: false,
        header: () => h('div', {}, 'Status'),
        cell: ({ row }) => h('div', {}, row.getValue('status')),
    },
    {
        accessorKey: 'rate',
        id: 'Rate',
        enableHiding: false,
        header: () => h('div', {}, 'Rate'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('rate'));
            const currency = row.getValue('currency') as string;
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency,
            }).format(amount);
            return h('div', {}, formatted);
        },
    },
    {
        accessorKey: 'currency',
        id: 'Currency',
        enableHiding: true,
        header: () => h('div', {}, 'Currency'),
        cell: ({ row }) => h('div', {}, row.getValue('currency')),
    },
    {
        accessorKey: 'billing_method',
        id: 'Billing Method',
        enableHiding: true,
        header: () => h('div', {}, 'Billing'),
        cell: ({ row }) => h('div', {}, row.getValue('billing_method')),
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
