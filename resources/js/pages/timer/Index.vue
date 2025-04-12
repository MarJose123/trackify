<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger,
} from '@/components/ui/combobox';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ToastAction, useToast } from '@/components/ui/toast';
import { TimerStatus } from '@/enums/Timer';
import AppLayout from '@/layouts/AppLayout.vue';
import { api } from '@/lib/axios';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem } from '@/types';
import { Client } from '@/types/clients';
import { Project } from '@/types/projects';
import { timerData } from '@/types/timer';
import { Head, usePage } from '@inertiajs/vue3';
import { Check, ChevronsUpDown, CirclePause, CirclePlay, CircleStop, Search, Timer } from 'lucide-vue-next';
import { h, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Project/Task Timer',
        href: '/timer',
    },
];

const page = usePage<timerData>();

const clockPayloadData = ref(page.props.timer);
const clients = ref<Client[]>(page.props.fields.clients);
const projects = ref<Project[]>(page.props.fields.projects);

const clientModelValue = ref<Client>();
const projectModelValue = ref<Project>();

console.log(clockPayloadData);

const invoices = [
    {
        invoice: 'INV001',
        paymentStatus: 'Paid',
        totalAmount: '$250.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV002',
        paymentStatus: 'Pending',
        totalAmount: '$150.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV003',
        paymentStatus: 'Unpaid',
        totalAmount: '$350.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV004',
        paymentStatus: 'Paid',
        totalAmount: '$450.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV005',
        paymentStatus: 'Paid',
        totalAmount: '$550.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV006',
        paymentStatus: 'Pending',
        totalAmount: '$200.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV007',
        paymentStatus: 'Unpaid',
        totalAmount: '$300.00',
        paymentMethod: 'Credit Card',
    },
];

const initiateTimer = async () => {
    // push the option object of the timer to the server
    api()
        .post(route('timer.store'), {
            client_id: clientModelValue.value?.id,
            project_id: projectModelValue.value?.id,
            status: TimerStatus.initiated,
        })
        .catch((error) => {
            console.error(error);
            useToast().toast({
                title: 'Uh oh! Something went wrong.',
                description: 'There was a problem with your request.',
                variant: 'destructive',
                action: h(
                    ToastAction,
                    {
                        altText: 'Try again',
                        onClick: initiateTimer,
                    },
                    {
                        default: () => 'Try again',
                    },
                ),
            });
        })
        .then((resp) => {
            console.log(resp);
            // const TimerId = resp?.response
        });
};
</script>

<template>
    <Head title="Clock - Task Timer" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="flex w-full items-center gap-3">
                    <Label>Client: </Label>
                    <Combobox v-model="clientModelValue" by="label" class="w-full">
                        <ComboboxAnchor as-child>
                            <ComboboxTrigger as-child>
                                <Button variant="outline" class="justify-between">
                                    {{ clientModelValue ? `${clientModelValue?.company_name} - ${clientModelValue?.name}` : 'Select Client' }}

                                    <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </ComboboxTrigger>
                        </ComboboxAnchor>

                        <ComboboxList>
                            <div class="relative w-full max-w-sm items-center">
                                <ComboboxInput class="h-10 rounded-none border-0 border-b pl-9 focus-visible:ring-0" placeholder="Select client..." />
                                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                                    <Search class="text-muted-foreground size-4" />
                                </span>
                            </div>

                            <ComboboxEmpty> No client found.</ComboboxEmpty>

                            <ComboboxGroup>
                                <ComboboxItem v-for="client in clients" :key="client.id" :value="client">
                                    {{ client.company_name }} - {{ client.name }}
                                    <ComboboxItemIndicator v-if="clientModelValue && clientModelValue.id == client.id">
                                        <Check :class="cn('ml-auto h-4 w-4')" />
                                    </ComboboxItemIndicator>
                                </ComboboxItem>
                            </ComboboxGroup>
                        </ComboboxList>
                    </Combobox>
                </div>
                <div class="flex w-full items-center gap-3">
                    <Label>Project: </Label>
                    <Combobox v-model="projectModelValue" by="label">
                        <ComboboxAnchor as-child>
                            <ComboboxTrigger as-child>
                                <Button variant="outline" class="justify-between">
                                    {{ projectModelValue ? `${projectModelValue.name}` : 'Select Project' }}

                                    <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </ComboboxTrigger>
                        </ComboboxAnchor>

                        <ComboboxList>
                            <div class="relative w-full max-w-sm items-center">
                                <ComboboxInput
                                    class="h-10 rounded-none border-0 border-b pl-9 focus-visible:ring-0"
                                    placeholder="Select project..."
                                />
                                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                                    <Search class="text-muted-foreground size-4" />
                                </span>
                            </div>

                            <ComboboxEmpty> No project found.</ComboboxEmpty>

                            <ComboboxGroup>
                                <ComboboxItem v-for="project in projects" :key="project.id" :value="project">
                                    {{ project.name }}

                                    <ComboboxItemIndicator v-if="projectModelValue && projectModelValue.id === project.id">
                                        <Check :class="cn('ml-auto h-4 w-4')" />
                                    </ComboboxItemIndicator>
                                </ComboboxItem>
                            </ComboboxGroup>
                        </ComboboxList>
                    </Combobox>
                </div>
                <div class="flex w-full flex-row-reverse">
                    <Button variant="outline">
                        <Timer />
                        Add
                    </Button>
                </div>
            </div>
            <div class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 rounded-xl border md:min-h-min">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Client</TableHead>
                            <TableHead>Project</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="invoice in invoices" :key="invoice.invoice">
                            <TableCell>{{ invoice.paymentStatus }}</TableCell>
                            <TableCell>{{ invoice.paymentMethod }}</TableCell>
                            <TableCell class="flex w-full flex-row-reverse">
                                <div class="flex flex-wrap space-x-1">
                                    <span
                                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 ring-inset"
                                        >00:30:24</span
                                    >
                                    <Button variant="ghost" class="rounded-full hover:bg-green-600 hover:text-white" size="icon">
                                        <CirclePlay class="size-10 stroke-current" />
                                    </Button>
                                    <Button variant="ghost" class="rounded-full hover:bg-orange-300 hover:text-white" size="icon">
                                        <CirclePause class="size-10 stroke-current" />
                                    </Button>
                                    <Button variant="ghost" class="rounded-full hover:bg-red-500 hover:text-white" size="icon">
                                        <CircleStop class="size-10 stroke-current" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
