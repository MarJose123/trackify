<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { type ClientsData } from '@/types/clients';
import { Head, usePage } from '@inertiajs/vue3';

import DataTable from '@/components/data-table/clients/DataTable.vue';
import eventBus from '@/lib/eventBus';
import { clientColumns } from '@/pages/clients/columns';
import { ref } from 'vue';
import { api } from '@/lib/axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
];

const page = usePage<ClientsData>();
const clientsPagination = ref(page.props.clients);
console.log('clients', clientsPagination);

eventBus.on('*', (type, filter) => {
    console.log(type, filter);

    if (type.toString().includes('client-table-pagination-change')) {
        api()
            .get(
                route('clients.list', {
                    page: filter?.pageIndex + 1,
                    per_page: filter?.pageSize,
                }),
            )
            .then((resp) => {
                clientsPagination.value = resp.data;
            });
    }
});
</script>

<template>
    <Head title="Clients" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <DataTable :columns="clientColumns" :data="clientsPagination" />
        </div>
    </AppLayout>
</template>
