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
import { Loader2 } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { computed, h, ref } from 'vue';
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
import { Check, ChevronsUpDown } from 'lucide-vue-next';

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

const clientDisplayValue = computed((val) => {
    const client = page.props.fields.clients.find((client) => client.id === val);
    return `${client?.company_name} - ${client?.name}`;
});

const formSchema = toTypedSchema(
    z.object({
        client: z.string({
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
        billing_method: z.string({
            required_error: 'This field required to have a value.',
        }),
        currency: z.string({
            required_error: 'This field required to have a value.',
        }),
        rate: z.coerce
            .number({
                required_error: 'This field required to have a value.',
                invalid_type_error: 'Field value must be a number',
            })
            .positive(),
    }),
);

const { handleSubmit, isSubmitting, isFieldDirty, setFieldValue, resetForm } = useForm({
    validationSchema: formSchema,
    initialValues: {
        status: 'Active',
    },
});

const onSubmit = handleSubmit(async (values) => {
    await api()
        .post(route('clients.store'), values, {
            headers: {
                accept: canCreateAnother.value === true ? 'application/json' : '*/*',
            },
        })
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
                router.visit(route('clients.list'));
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
    <Head title="Add Client" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl px-4 py-6">
            <form @submit="onSubmit" class="grid gap-y-5">
                <div class="grid auto-rows-min gap-3 gap-y-4 md:grid-cols-2">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="client" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Client</FormLabel>
                                <Combobox by="label">
                                    <FormControl>
                                        <ComboboxAnchor class="w-full">
                                            <div class="relative items-center">
                                                <ComboboxInput
                                                    :display-value="(val) => (val ? clientDisplayValue(val) : '')"
                                                    placeholder="Select Client"
                                                />
                                                <ComboboxTrigger class="absolute inset-y-0 end-0 flex items-center justify-center px-3">
                                                    <ChevronsUpDown class="size-4 text-muted-foreground" />
                                                </ComboboxTrigger>
                                            </div>
                                        </ComboboxAnchor>
                                    </FormControl>

                                    <ComboboxList>
                                        <ComboboxEmpty> Nothing found. </ComboboxEmpty>

                                        <ComboboxGroup>
                                            <ComboboxItem
                                                v-for="client in page.props.fields.clients"
                                                :key="client.id"
                                                :value="client.id"
                                                @select="() => setFieldValue('client', client.id)"
                                            >
                                                {{ client.company_name }} - {{ client.name }}

                                                <ComboboxItemIndicator>
                                                    <Check :class="cn('ml-auto h-4 w-4')" />
                                                </ComboboxItemIndicator>
                                            </ComboboxItem>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
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
                </div>
                <div class="grid auto-rows-min gap-3 gap-y-4 md:grid-cols-2">
                    <div />
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <div class="flex w-full flex-row-reverse gap-2">
                            <Button type="button" :disabled="isSubmitting" variant="outline" @click.prevent="router.visit(route('clients.list'))">
                                <Loader2 v-if="isSubmitting" class="mr-2 h-4 w-4 animate-spin" />
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
