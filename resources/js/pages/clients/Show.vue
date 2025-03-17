<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ShowSharedData } from '@/types/clients';
import { Head, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const page = usePage<ShowSharedData>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: route('clients.list'),
    },
    {
        title: `Client - ${page.props.client.company_name}`,
        href: route('clients.show', page.props.client.id),
    },
];

const client = page.props.client;
</script>

<template>
    <Head title="Client" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl px-4 py-6">
            <div class="grid gap-y-5">
                <div class="grid auto-rows-min gap-3 gap-y-4 md:grid-cols-2">
                    <div />
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <div class="flex flex-row-reverse w-full">
                            <Button variant="outline" class="max-w-sm" @click.stop="router.visit(route('clients.edit', client.id))">
                                Edit
                            </Button>
                        </div>
                    </div>
                </div>
                <div class="grid auto-rows-min gap-3 gap-y-4 md:grid-cols-2">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="company_name">Company Name</Label>
                        <Input id="company_name" type="text" disabled v-bind:model-value="client.company_name" />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="name">Contact Name</Label>
                        <Input id="name" type="text" disabled v-bind:model-value="client.name" />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="status">Status</Label>
                        <Input id="status" type="text" disabled v-bind:model-value="client.status" />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="billing_method">Billing Method</Label>
                        <Input id="billing_method" type="text" disabled v-bind:model-value="client.billing_method" />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="currency">Currency</Label>
                        <Input id="currency" type="text" disabled v-bind:model-value="client.currency" />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="rate">Rate</Label>
                        <Input id="rate" type="text" disabled v-bind:model-value="client.rate" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
