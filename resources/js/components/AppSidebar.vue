<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { CalendarRange, Clock, FolderKanban, LayoutGrid, Users } from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Clock',
        href: '/clocks',
        icon: Clock,
    },
    {
        title: 'Timesheets',
        href: '#',
        icon: CalendarRange,
    },
    {
        title: 'Projects',
        href: '/projects',
        icon: FolderKanban,
    },
    {
        title: 'Clients',
        href: '/clients',
        icon: Users,
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/MarJose123/Trackify',
    //     icon: Folder,
    // }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
