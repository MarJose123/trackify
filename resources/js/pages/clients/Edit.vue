<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { NumberField, NumberFieldContent, NumberFieldInput } from '@/components/ui/number-field';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { ToastAction, useToast } from '@/components/ui/toast';
import AppLayout from '@/layouts/AppLayout.vue';
import { api } from '@/lib/axios';
import { type BreadcrumbItem } from '@/types';
import { EditSharedData } from '@/types/clients';
import { Head, router, usePage } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { Loader2 } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { h } from 'vue';
import * as z from 'zod';

const page = usePage<EditSharedData>();
const client = page.props.client;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: route('clients.list'),
    },
    {
        title: `${client.company_name}`,
        href: route('clients.show', client.id),
    },
    {
        title: `Update Client`,
        href: route('clients.edit', client.id),
    },
];

const formSchema = toTypedSchema(
    z.object({
        company_name: z
            .string({
                required_error: 'This field required to have a value.',
            })
            .min(2)
            .max(225),
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

const { handleSubmit, isSubmitting, isFieldDirty, setFieldValue } = useForm({
    validationSchema: formSchema,
    initialValues: {
        company_name: client.company_name,
        name: client.name,
        status: 'Active',
        billing_method: client.billing_method,
        currency: client.currency,
        rate: client.rate,
    },
});

const onSubmit = handleSubmit(async (values) => {
    await api()
        .put(route('clients.update', client.id), values, {
            headers: {
                accept: '*/*',
            },
        })
        .then(() => {
            router.visit(route('clients.show', client.id));
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
                        <FormField name="company_name" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Company Name</FormLabel>
                                <FormControl>
                                    <Input id="company_name" type="text" v-bind="componentField" />
                                </FormControl>
                                <FormDescription />
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="name" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Contact Name</FormLabel>
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
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="billing_method" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Billing Method</FormLabel>
                                <FormControl>
                                    <Select class="flex w-full" v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select Billing Method" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Billing Method</SelectLabel>
                                                <SelectItem v-for="method in page?.props.fields.billing_method" :value="method" :key="method">
                                                    {{ method }}
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
                        <FormField name="currency" v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Currency</FormLabel>
                                <FormControl>
                                    <Select class="flex w-full" v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Select Currency" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Currency</SelectLabel>
                                                <SelectItem v-for="currency in page?.props.fields.currency" :value="currency" :key="currency">
                                                    {{ currency }}
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
                        <FormField name="rate" v-slot="{ value }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Rate</FormLabel>
                                <FormControl>
                                    <NumberField
                                        :model-value="value"
                                        @update:model-value="
                                            (v: number | undefined) => {
                                                if (v && typeof v !== undefined) {
                                                    setFieldValue('rate', v as number);
                                                } else {
                                                    setFieldValue('rate', undefined);
                                                }
                                            }
                                        "
                                    >
                                        <NumberFieldContent>
                                            <NumberFieldInput />
                                        </NumberFieldContent>
                                    </NumberField>
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
                        <div class="flex w-full flex-row-reverse gap-4">
                            <Button type="submit" :disabled="isSubmitting">
                                <Loader2 v-if="isSubmitting" class="mr-2 h-4 w-4 animate-spin" />
                                {{ isSubmitting ? 'Saving..' : 'Save' }}
                            </Button>
                            <Button
                                type="button"
                                variant="outline"
                                :disabled="isSubmitting"
                                @click.prevent="router.visit(route('clients.show', client.id))"
                            >
                                Cancel
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
