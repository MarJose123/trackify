import ClientsDataTableDropDown from '@/components/data-table/client/DataTableDropDown.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Client } from '@/types/clients';
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
        enableHiding: false,
        header: () => h('div', {}, 'Status'),
        cell: ({ row }) => h('div', {}, row.getValue('status')),
    },
    {
        accessorKey: 'rate',
        enableHiding: false,
        header: () => h('div', {}, 'Rate'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('rate'));
            const currencyCode = row.getValue('currency') as string;
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currencyCode,
            }).format(amount);
            return h('div', {}, formatted);
        },
    },
    {
        accessorKey: 'currency',
        enableHiding: true,
        meta: {
            displayName: 'Currency',
        },
        header: () => h('div', {}, 'Currency'),
        cell: ({ row }) => h('div', {}, row.getValue('currency')),
    },
    {
        accessorKey: 'billing_method',
        id: 'billing_method',
        enableHiding: true,
        meta: {
            displayName: 'Billing Method',
        },
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
