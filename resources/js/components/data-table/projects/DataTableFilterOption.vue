<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { api } from '@/lib/axios';
import eventBus from '@/lib/eventBus';
import { Client } from '@/types/clients';
import { ProjectTableFilter } from '@/types/projects';
import { Filter } from 'lucide-vue-next';
import { onMounted, reactive, ref, watch } from 'vue';

const availableFilter = ref<ProjectTableFilter>();
const clientFilter = ref<Client[]>();

const filter = reactive({
    status: undefined,
    client: undefined,
});

const resetFilter = () => {
    filter.status = undefined;
    filter.client = undefined;
};

onMounted(() => {
    api()
        .get(route('projects.table-filter-status'))
        .then((resp) => (availableFilter.value = resp.data));
    api()
        .get(route('clients.list'))
        .then((resp) => {
            console.info(resp.data);
            clientFilter.value = resp.data.data;
        });
});

watch(filter, (value) => {
    eventBus.emit('project-table-filter', value);
});
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline">
                <Filter class="mr-1 h-4 w-4" />
                Filter
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-80" align="end">
            <div class="grid gap-4">
                <div class="space-y-2">
                    <h4 class="font-medium leading-none">Table Filter</h4>
                    <p class="text-sm text-muted-foreground">Set filter to the record.</p>
                </div>
                <div class="grid gap-2">
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="width">Status</Label>
                        <Select v-model:model-value="filter.status">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Select Status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Status</SelectLabel>
                                    <SelectItem v-for="status in availableFilter?.status" :key="status" :value="status">
                                        {{ status }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Label for="maxWidth">Client</Label>
                        <Select v-model:model-value="filter.client">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Select Client" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Clients</SelectLabel>
                                    <SelectItem v-for="client in clientFilter" :key="client.id" :value="client.id">
                                        {{ client.company_name }} - {{ client.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <Button variant="outline" class="col-end-3" @click.prevent="resetFilter"> Reset Filter</Button>
                    </div>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>
