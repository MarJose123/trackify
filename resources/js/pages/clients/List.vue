<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { type ClientsData } from '@/types/clients';
import { Head, usePage } from '@inertiajs/vue3';

import DataTable from '@/components/data-table/clients/DataTable.vue';
import { useToast } from '@/components/ui/toast';
import { api } from '@/lib/axios';
import eventBus from '@/lib/eventBus';
import { clientColumns } from '@/pages/clients/columns';
import { onMounted, ref } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
];

const page = usePage<ClientsData>();
const clientsPagination = ref(page.props.clients);

onMounted(() => {
    const flashNotification = page.props.notification?.success;

    if (flashNotification) {
        toast(flashNotification.title, {
            description: flashNotification.description,
        });
    }
});

eventBus.on('*', (type, filter) => {
    console.log(type, filter);

    // Table search field
    if (type.toString().includes('client-table-search')) {
        api()
            .get(
                route('clients.list', {
                    ...((filter !== undefined || filter !== '') && { search: filter }),
                }),
            )
            .then((resp) => {
                clientsPagination.value = resp.data;
            })
            .catch(() => {
                useToast().toast({
                    title: 'Uh oh! Something went wrong.',
                    description: 'There was a problem with your request when applying filters.',
                    variant: 'destructive',
                });
            });
    }

    // Table Filter
    if (type.toString().includes('client-table-filter')) {
        api()
            .get(
                route('clients.list', {
                    ...(filter?.status !== undefined && { status: filter?.status }),
                    ...(filter?.currency !== undefined && { currency: filter?.currency }),
                }),
            )
            .then((resp) => {
                clientsPagination.value = resp.data;
            })
            .catch(() => {
                useToast().toast({
                    title: 'Uh oh! Something went wrong.',
                    description: 'There was a problem with your request when applying filters.',
                    variant: 'destructive',
                });
            });
    }

    // Table pagination
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
            })
            .catch(() => {
                useToast().toast({
                    title: 'Uh oh! Something went wrong.',
                    description: 'There was a problem with your request when updating the table.',
                    variant: 'destructive',
                });
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
