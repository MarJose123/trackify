<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'
import { useForm } from 'vee-validate'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { CreationSharedData } from '@/types/clients';
import { Loader2 } from 'lucide-vue-next'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form'
import {Button} from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: route('clients.list'),
    },
    {
        title: 'Add Client',
        href: route('clients.list'),
    },
];

const formSchema = toTypedSchema(z.object({
    company_name: z.string().min(2).max(225),
    name: z.string().min(2).max(225),
    status: z.string().min(2).max(225)
}))

const { handleSubmit, isSubmitting, isFieldDirty } = useForm({
    validationSchema: formSchema,
})

const onSubmit = handleSubmit((values) => {
    setInterval(() => console.log('release'),500000 )
    console.log('Form submitted!', values)
})

const page = usePage<CreationSharedData>()


</script>

<template>
    <Head title="Add Client" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl px-4 py-6">
            <form @submit="onSubmit" class="grid gap-y-5">
                <div class="grid auto-rows-min gap-3 md:grid-cols-2 gap-y-4">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <FormField name="company_name"  v-slot="{ componentField }" :validate-on-blur="!isFieldDirty">
                            <FormItem>
                                <FormLabel>Company Name</FormLabel>
                                <FormControl>
                                    <Input id="company_name" type="text" v-bind="componentField"  />
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
                                    <Input id="name" type="text" v-bind="componentField"/>
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
                        <Label for="name">Billing Method</Label>
                        <Select class="flex w-full">
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
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="name">Currency</Label>
                        <Select class="flex w-full">
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
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="salary">Rate</Label>
                        <Input id="salary" type="text" />
                    </div>
                </div>
                <div class="flex w-full flex-row-reverse ">
                    <Button type="submit" :disabled="isSubmitting">
                        <Loader2 v-if="isSubmitting" class="w-4 h-4 mr-2 animate-spin" />
                        Save
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
