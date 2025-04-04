import { Client } from '@/types/clients';
import { Project } from '@/types/projects';

export interface Clock {
    clients: Client;
    projects: Project;
}
