<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import Button from '@/Components/Button.vue';
import Paginator from '@/Components/Paginator.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsItemMain from '@/Components/BreadcrumbsItemMain.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        BreadcrumbsItemMain,
        Card,
        Button,
        Paginator,
    },

    props: {
        projects: Object,
        filters: Object,
    },

    data() {
        return {
            form: {
                search: this.filters.search,
            },
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form)
                this.$inertia.replace(this.route('projects.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 500),
            deep: true,
        },
    },
}
</script>

<template>
    <AppLayout title="Projects">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider></BreadcrumbsDivider>
                <BreadcrumbsItem :href="route('projects.index')">Projects</BreadcrumbsItem>
            </Breadcrumbs>
            <Card>
                <template #header>
                    <h2 class="text-xl font-bold">Projects</h2>
                    <Button as="InertiaLink" :href="route('projects.create')" :primary="true">Create project</Button>
                </template>
                <header class="flex items-center px-6 py-4 space-x-4 bg-primary-50">
                    <input
                            placeholder="Search projects..."
                            class="flex-1 placeholder-gray-400 rounded-lg border-gray-300 shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300"
                            type="text"
                            v-model="form.search"
                    />
                </header>
                <ul class="divide-y divide-gray-200">
                    <li v-for="project in projects.data" :key="project.id">
                        <inertia-link :href="route('projects.show', project.id)" class="flex items-center px-6 py-4 space-x-6 hover:bg-gray-100">
                            <div class="w-2 h-2 rounded-full" :class="{'bg-red-600' : project.unread_exceptions_count, 'bg-gray-300' : !project.unread_exceptions_count }"></div>
                            <div class="flex-1">
                                <p class="font-medium text-bold">{{ project.title }}</p>
                                <p class="text-sm text-gray-600">{{ project.unread_exceptions_count }} unread exceptions &centerdot; {{  project.total_exceptions }} total exceptions</p>
                            </div>

                            <svg
                                    class="w-6 h-6 text-gray-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                ></path>
                            </svg>
                        </inertia-link>
                    </li>
                </ul>

                <template #footer>
                    <Paginator :paginated="projects"/>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
