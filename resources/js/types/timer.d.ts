import { TimerStatus } from '@/enums/Timer';
import { Client } from '@/types/clients';
import { flashNotification } from '@/types/index';
import { Pagination } from '@/types/pagination';
import { Project } from '@/types/projects';
import type { PageProps } from '@inertiajs/core';
import { TimerOptions } from 'timer-node';

export interface Timer {
    id: number;
    duration: number;
    status: string;
    timer: TimerOption;
    clients: Client;
    projects: Project;
}

export interface TimerOption extends TimerOptions {
    status: typeof TimerStatus;
}

export interface timerData extends PageProps {
    timer: Pagination & { data: Timer[] };
    fields: {
        clients: Client[];
        projects: Project[];
    };
    notification?: flashNotification['notification'];
}
