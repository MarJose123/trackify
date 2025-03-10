<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Client, ClientsData } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

import DataTable from '@/components/DataTable.vue';
import { clientColumns } from '@/pages/clients/columns';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
];

const page = usePage<ClientsData>();
const clients = page.props.clients.data as Client[];
console.log(clients);
</script>

<template>
    <Head title="Clients" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <DataTable :columns="clientColumns" :data="clients" />
        </div>
    </AppLayout>
</template>
