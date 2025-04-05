import { Client } from '@/types/clients';
import { flashNotification } from '@/types/index';
import { Pagination } from '@/types/pagination';
import { Project } from '@/types/projects';
import { TimerOptions } from 'timer-node';

export interface Clock {
    id: number;
    duration: number;
    status: string;
    timer: TimerOption;
    clients: Client;
    projects: Project;
}

type TimerStatus = 'running' | 'stopped' | 'initiated' | 'paused';

export interface TimerOption extends TimerOptions {
    status: TimerStatus;
}

export interface clockData extends ShareData {
    clock: Pagination & { data: Clock[] };
    notification?: flashNotification['notification'];
}
