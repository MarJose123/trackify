import DataTableSingleRowAction from '@/components/data-table/projects/DataTableSingleRowAction.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Project } from '@/types/projects';
import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

export const projectColumns: ColumnDef<Project>[] = [
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
        accessorKey: 'client_company_name',
        enableHiding: false,
        header: () => h('div', {}, 'Client Company Name'),
        cell: ({ row }) => h('div', {}, row.original.client.company_name),
    },
    {
        accessorKey: 'client_name',
        enableHiding: true,
        meta: {
            displayName: 'Client Name',
        },
        header: () => h('div', {}, 'Client Name'),
        cell: ({ row }) => h('div', {}, row.original.client.name),
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
        accessorKey: 'created_at',
        enableHiding: true,
        meta: {
            displayName: 'Created At',
        },
        header: () => h('div', {}, 'Created At'),
        cell: ({ row }) => {
            return h('div', {}, row.getValue('created_at'));
        },
    },
    {
        accessorKey: 'updated_at',
        enableHiding: true,
        meta: {
            displayName: 'Created At',
        },
        header: () => h('div', {}, 'Updated At'),
        cell: ({ row }) => h('div', {}, row.getValue('updated_at')),
    },
    {
        accessorKey: 'actions',
        enableHiding: false,
        header: () => h('div', { class: '' }, ''),
        cell: ({ row }) => {
            const project = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DataTableSingleRowAction, {
                    project,
                    onExpand: row.toggleExpanded,
                }),
            );
        },
    },
];
