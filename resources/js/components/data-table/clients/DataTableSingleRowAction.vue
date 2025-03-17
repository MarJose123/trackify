<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button, buttonVariants } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { api } from '@/lib/axios';
import { router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { toast } from 'vue-sonner';

defineProps<{
    client: {
        id: string;
    };
}>();

function copy(id: string) {
    navigator.clipboard.writeText(id);
    toast('Client ID has been copied to clipboard.');
}

const deleteRecord = async (id: string) => {
    await api().delete(route('clients.destroy', id), { headers: { accept: '*/*' } });
    router.visit(route('clients.list'));
};
</script>

<template>
    <DropdownMenu :modal="false">
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0" @click.stop>
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem @click="copy(client.id)"> Copy Client ID</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="router.visit(route('clients.show', client.id))">View Client</DropdownMenuItem>
            <DropdownMenuItem @click="router.visit(route('clients.edit', client.id))">Edit Client</DropdownMenuItem>
            <DropdownMenuItem>
                <AlertDialog>
                    <AlertDialogTrigger @click.stop>Delete Client</AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                            <AlertDialogDescription>
                                This action cannot be undone. This will permanently delete the record and its related record.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                            <AlertDialogAction :class="buttonVariants({ variant: 'destructive' })" @click="deleteRecord(client.id)"
                                >Continue
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>

<style scoped></style>
