<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ToastAction, useToast } from '@/components/ui/toast';
import AppLayout from '@/layouts/AppLayout.vue';
import { api } from '@/lib/axios';
import { type BreadcrumbItem } from '@/types';
import { CreationSharedData } from '@/types/projects';
import { Head, router, usePage } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { Check, ChevronsUpDown, Loader2, Search } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { h, ref } from 'vue';
import { toast } from 'vue-sonner';
import * as z from 'zod';

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
import { cn } from '@/lib/utils';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: route('projects.index'),
    },
    {
        title: 'Add Project',
        href: route('projects.create'),
    },
];

const page = usePage<CreationSharedData>();
const canCreateAnother = ref<boolean>(false);

const formSchema = toTypedSchema(
    z.object({
        client_id: z.string({
            required_error: 'This field required to have a value.',
        }),
        name: z
            .string({
                required_error: 'This field required to have a value.',
            })
            .min(2)
            .max(225),
        status: z
            .string({
                required_error: 'This field required to have a value.',
            })
            .min(2)
            .max(225),
    }),
);

const { handleSubmit, isSubmitting, isFieldDirty, setFieldValue, resetForm, values } = useForm({
    validationSchema: formSchema,
    initialValues: {
        status: 'Active',
    },
});

const onSubmit = handleSubmit(async (values) => {
    await api()
        .post(
            route('projects.store'),
            {
                clients_id: values.client_id,
                ...values,
            },
            {
                headers: {
                    accept: canCreateAnother.value === true ? 'application/json' : '*/*',
                },
            },
        )
        .then((resp) => {
            if (canCreateAnother.value) {
                resetForm();
                canCreateAnother.value = false;
                if (resp.status === 201) {
                    toast(resp.data.message, {
                        description: resp.data.description,
                    });
                }
            } else {
                router.visit(route('projects.index'));
            }
        })
        .catch((resp) => {
            console.log(resp);
            if (resp.status === 422) {
                useToast().toast({
                    title: 'Uh oh! Something went wrong.',
                    description: resp.response.data.message,
                    variant: 'destructive',
                });
            } else {
                useToast().toast({
                    title: 'Uh oh! Something went wrong.',
                    description: 'There was a problem with your request.',
                    variant: 'destructive',
                    action: h(
                        ToastAction,
                        {
                            altText: 'Try again',
                            onClick: onSubmit,
                        },
                        {
                            default: () => 'Try again',
                        },
                    ),
                });
            }
        });
});
</script>

<template>
    <Head title="Add Record" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl px-4 py-6">
            <form @submit="onSubmit" class="grid gap-y-5">
                <div class="grid auto-rows-min gap-3 gap-y-4 md:grid-cols-2">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="client_id" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Client</FormLabel>
                                <FormDescription class="italic"> Only Active Client will be showing.</FormDescription>
                                <FormControl>
                                    <Combobox by="label" v-bind="componentField">
                                        <ComboboxAnchor as-child class="w-full">
                                            <ComboboxTrigger as-child>
                                                <Button variant="outline" class="justify-between">
                                                    {{
                                                        values?.client_id
                                                            ? `${page.props.fields.clients.find((client) => client.id === values.client_id)?.company_name} - ${page.props.fields.clients.find((client) => client.id === values.client_id)?.name}`
                                                            : 'Select Client'
                                                    }}

                                                    <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                                </Button>
                                            </ComboboxTrigger>
                                        </ComboboxAnchor>
                                        <ComboboxList class="w-[370px] p-0" align="start" side="bottom">
                                            <div class="relative w-full max-w-sm items-center">
                                                <ComboboxInput
                                                    :display-value="(val) => ''"
                                                    class="h-9 rounded-none border-0 border-b pl-9 focus-visible:ring-0"
                                                    placeholder="Search Client..."
                                                />
                                                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                                                    <Search class="size-4 text-muted-foreground" />
                                                </span>
                                            </div>
                                            <ComboboxEmpty> Nothing found.</ComboboxEmpty>

                                            <ComboboxGroup>
                                                <ComboboxItem
                                                    v-for="client in page.props.fields.clients"
                                                    :key="client.id"
                                                    :value="client.id"
                                                    @select="() => setFieldValue('client_id', client.id)"
                                                >
                                                    {{ client.company_name }} - {{ client.name }}

                                                    <ComboboxItemIndicator>
                                                        <Check :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ComboboxGroup>
                                        </ComboboxList>
                                    </Combobox>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="status" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Status</FormLabel>
                                <FormControl>
                                    <Select class="flex w-full" v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select Status" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Status</SelectLabel>
                                                <SelectItem v-for="status in page?.props.fields.status" :value="status" :key="status">
                                                    {{ status }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormDescription />
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="name" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Project Name</FormLabel>
                                <FormControl>
                                    <Input id="name" type="text" v-bind="componentField" />
                                </FormControl>
                                <FormDescription />
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                </div>
                <div class="grid auto-rows-min gap-3 gap-y-4 md:grid-cols-2">
                    <div />
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <div class="flex w-full flex-row-reverse gap-2">
                            <Button type="button" :disabled="isSubmitting" variant="outline" @click.prevent="router.visit(route('projects.index'))">
                                Cancel
                            </Button>
                            <Button type="submit" :disabled="isSubmitting" variant="outline" @click="canCreateAnother = false">
                                <Loader2 v-if="isSubmitting" class="mr-2 h-4 w-4 animate-spin" />
                                {{ isSubmitting ? 'Creating..' : 'Create' }}
                            </Button>
                            <Button type="submit" :disabled="isSubmitting" variant="outline" @click="canCreateAnother = true">
                                <Loader2 v-if="isSubmitting" class="mr-2 h-4 w-4 animate-spin" />
                                {{ isSubmitting ? 'Creating..' : 'Create & Another' }}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
