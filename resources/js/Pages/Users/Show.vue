<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/Card.vue'
import Badge from '@/Components/Badge.vue'
import Button from '@/Components/Button.vue'
import ButtonRack from '@/Components/ButtonRack.vue'
import ButtonRackItem from '@/Components/ButtonRackItem.vue'
import Code from '@/Components/Code.vue'
import Paginator from '@/Components/Paginator.vue'
import EditProject from '@/Partials/EditProject.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsItemMain from '@/Components/BreadcrumbsItemMain.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        BreadcrumbsItemMain,
        EditProject,
        Code,
        Card,
        Button,
        ButtonRack,
        ButtonRackItem,
        Paginator,
        Badge,
    },
    props: {
        user: Object,
    },
    data() {
        return {
            sending: false,

            selected: [],

            form: {
                user: this.user.id,
            },
        }
    },
    watch: {
        form: {
            handler: throttle(function () {
                let query = pickBy(this.form)
                this.$inertia.replace(this.route('users.show', Object.keys(query).length ? query : {remember: 'forget'}))
            }, 500),
            deep: true,
        },
    },
    methods: {

        reset() {
            this.form = mapValues(this.form, (item, key) => {
                // We have to remember the project key, because the route parameter requires this
                if (key == 'user') {
                    return item;
                }

                return null;
            })
        },

        deleteSelected() {
            this.$inertia.post(this.route('exceptions.delete-selected', this.project.id), {
                exceptions: this.selected,
            }, {
                onSuccess: () => {
                    this.selected = [];
                },
            });
        },

    }
}
</script>

<template>
    <AppLayout title="Users">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.index')">Users</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.show', user.id)">{{ user.name }}</BreadcrumbsItem>
            </Breadcrumbs>
            <Card>
                <template #header>
                    <h2 class="text-xl font-bold">User {{ user.name }}</h2>

                    <ButtonRack>
                        <ButtonRackItem as="inertia-link" :href="route('users.edit', user.id)">Edit user
                        </ButtonRackItem>
                    </ButtonRack>
                </template>

                <dl class="grid grid-cols-3 gap-px overflow-hidden bg-gray-100 rounded-b-lg">
                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Name</dt>
                        <dd class="text-base">{{ user.name }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">E-mail Address</dt>
                        <dd class="text-base">{{ user.email }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Receive email</dt>
                        <dd class="text-base">{{ user.receive_email_text }}</dd>
                    </div>
                </dl>
            </Card>

        </div>
    </AppLayout>
</template>
