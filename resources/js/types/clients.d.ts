import { SharedData } from '@/types/index';
import { Pagination } from '@/types/pagination';
import type { PageProps } from '@inertiajs/core';

export interface Client {
    id: string;
    name: string;
    currency: string;
    billing_method: string;
    company_name: string;
    status: string;
    rate: number;
}

export interface CreationSharedData extends PageProps {
    fields: {
        status: any[];
        currency: any[];
        billing_method: any[];
    };
}

export interface ClientsData extends SharedData {
    clients: Pagination & { data: Client[] };
}

export interface ClientTableFilter {
    status: any[];
    currency: any[];
}
