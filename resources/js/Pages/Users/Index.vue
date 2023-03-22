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
        users: Object,
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
                this.$inertia.replace(this.route('users.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 500),
            deep: true,
        },
    },
}
</script>

<template>
    <AppLayout title="Users">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider></BreadcrumbsDivider>
                <BreadcrumbsItem :href="route('users.index')">Users</BreadcrumbsItem>
            </Breadcrumbs>
            <Card>
                <template #header>
                    <h2 class="text-xl font-bold">Users</h2>
                    <Button as="InertiaLink" :href="route('users.create')" :primary="true">Create user</Button>
                </template>
                <header class="flex items-center px-6 py-4 space-x-4 bg-primary-50">
                    <input
                            placeholder="Search users..."
                            class="flex-1 placeholder-gray-400 rounded-lg border-gray-300 shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300"
                            type="text"
                            v-model="form.search"
                    />
                </header>
                <ul class="divide-y divide-gray-200">
                    <li v-for="user in users.data" :key="user.id">
                        <inertia-link :href="route('users.show', user.id)" class="flex items-center px-6 py-4 space-x-6 hover:bg-gray-100">
                            <div class="flex-1">
                                <p class="font-medium text-bold">{{ user.name }}</p>
                                <p class="text-muted">{{ user.email }}</p>
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
                    <Paginator :paginated="users"/>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
