import eventBus from '@/lib/eventBus.js';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export function setupAxios() {
    const instance = axios.create();

    instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    const token: HTMLMetaElement = document?.head?.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;
    instance.defaults.headers.common['X-CSRF-TOKEN'] = token?.content;

    instance.interceptors.response.use(
        (response) => response,
        (error) => {
            if (axios.isCancel(error)) {
                return Promise.reject(error);
            }

            const response = error.response;
            const {
                status,
                data: { redirect },
            } = response;

            // Show the user a 500 error
            if (status >= 500) {
                eventBus.emit('error', error.response.data.message);
            }

            // Handle Session Timeouts (Unauthorized)
            if (status === 401) {
                // Use redirect if being specified by the response
                if (redirect != null) {
                    location.href = redirect;
                    return;
                }
                router.visit(route('login'));
            }

            // Handle Forbidden
            if (status === 403) {
                location.href = '/403';
            }

            // Handle Token Timeouts
            if (status === 419) {
                eventBus.emit('token-expired');
            }

            return Promise.reject(error);
        },
    );

    return instance;
}

export function api() {
    return setupAxios();
}
