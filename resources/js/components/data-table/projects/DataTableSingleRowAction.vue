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
import { Project } from '@/types/projects';
import { router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { toast } from 'vue-sonner';

defineProps<{
    project: Project;
}>();

function copy(id: string) {
    navigator.clipboard.writeText(id);
    toast('Project ID has been copied to clipboard.');
}

const deleteRecord = async (id: string) => {
    await api().delete(route('projects.destroy', id), { headers: { accept: '*/*' } });
    router.visit(route('projects.index'));
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
            <DropdownMenuItem @click="copy(project.id)"> Copy Client ID</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="router.visit(route('projects.show', project.id))">View Project</DropdownMenuItem>
            <DropdownMenuItem @click="router.visit(route('projects.edit', project.id))">Edit Project</DropdownMenuItem>
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
                            <AlertDialogAction :class="buttonVariants({ variant: 'destructive' })" @click="deleteRecord(project.id)"
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
