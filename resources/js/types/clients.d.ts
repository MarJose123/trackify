import { SharedData } from '@/types/index';
import { Pagination } from '@/types/pagination';

export interface Client {
    id: string;
    name: string;
    currency: string;
    billing_method: string;
    company_name: string;
    status: string;
    rate: number;
}

export interface ClientsData extends SharedData {
    clients: Pagination & { data: Client[] };
}

export interface ClientTableFilter {
    status: any[];
    currency: any[];
}
