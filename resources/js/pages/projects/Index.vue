<script setup lang="ts">
import DataTable from '@/components/data-table/projects/DataTable.vue';
import { useToast } from '@/components/ui/toast';
import AppLayout from '@/layouts/AppLayout.vue';
import { api } from '@/lib/axios';
import eventBus from '@/lib/eventBus';
import { projectColumns } from '@/pages/projects/columns';
import { type BreadcrumbItem } from '@/types';
import { ProjectsData } from '@/types/projects';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
];

const page = usePage<ProjectsData>();
const projectsPagination = ref(page.props.projects);

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

    if (type.toString().includes('project-table-filter')) {
        api()
            .get(
                route('projects.index', {
                    ...(filter?.status !== undefined && { status: filter?.status }),
                    ...(filter?.client !== undefined && { client: filter?.client }),
                }),
            )
            .then((resp) => {
                console.info(resp);
                projectsPagination.value = resp.data;
            })
            .catch(() => {
                useToast().toast({
                    title: 'Uh oh! Something went wrong.',
                    description: 'There was a problem with your request when applying filters.',
                    variant: 'destructive',
                });
            });
    }

    // Table search field
    if (type.toString().includes('project-table-search')) {
        api()
            .get(
                route('projects.index', {
                    ...((filter !== undefined || filter !== '') && { search: filter }),
                }),
            )
            .then((resp) => {
                projectsPagination.value = resp.data;
                console.info('resp', resp);
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
    if (type.toString().includes('project-table-pagination-change')) {
        api()
            .get(
                route('projects.index', {
                    page: filter?.pageIndex + 1,
                    per_page: filter?.pageSize,
                }),
            )
            .then((resp) => {
                projectsPagination.value = resp.data;
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
    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <DataTable :columns="projectColumns" :data="projectsPagination" />
        </div>
    </AppLayout>
</template>
