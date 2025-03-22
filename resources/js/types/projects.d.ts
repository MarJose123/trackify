import { Client } from '@/types/clients';
import { flashNotification, SharedData } from '@/types/index';
import { Pagination } from '@/types/pagination';
import type { PageProps } from '@inertiajs/core';

export interface Project {
    id: string;
    name: string;
    status: string;
    created_at: string;
    updated_at: string;
    user_id: string;
    client: Client;
}

export interface ShowSharedData extends PageProps {
    project?: {
        data?: Project;
    };
    notification?: flashNotification['notification'];
}
export interface EditSharedData extends PageProps {
    project: Project;
    fields: CreationSharedData['fields'];
    notification?: flashNotification['notification'];
}

export interface CreationSharedData extends PageProps {
    notification?: flashNotification['notification'];
    fields: {
        clients: Client[];
        status: any[];
    };
}

export interface ProjectsData extends SharedData {
    notification?: flashNotification['notification'];
    projects: Pagination & { data: Project[] };
}

export interface ProjectTableFilter {
    status: any[];
}
