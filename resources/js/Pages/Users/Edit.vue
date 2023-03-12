<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'
import FormInputGroup from '@/Components/FormInputGroup.vue'
import FormTextareaGroup from '@/Components/FormTextareaGroup.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsItemMain from '@/Components/BreadcrumbsItemMain.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'
import { useForm } from '@inertiajs/vue3'

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        BreadcrumbsItemMain,
        Card,
        Button,
        FormInputGroup,
        FormTextareaGroup,
    },

    props: {
        user: Object
    },

    data() {
        return {
            sending: false,
            form: useForm ({
                name: this.user.name,
                email: this.user.email,
                receive_email: this.user.receive_email,
            }),
        }
    },

    methods: {
        submit() {
            this.form.put(this.route('users.update', this.user.id), {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false
            })
        },
        destroy() {
            this.form.delete(this.route('users.destroy', this.user.id),{
                onBefore: () => confirm('Are you sure you want to delete this user?'),
            })
        },
    },
}
</script>

<template>
    <AppLayout title="Edit User">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.index')">Users</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.show', user.id)">{{ user.name }}</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.edit', user.id)">Edit User</BreadcrumbsItem>
            </Breadcrumbs>
            <Card contained>
                <template #header>
                    <h2 class="text-xl font-bold">Edit {{ user.name }} User</h2>
                </template>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <FormInputGroup
                            v-model="form.name"
                            :error="form.errors.name"
                            label="Name"
                            id="name"
                            required
                        />
                        <FormInputGroup
                            v-model="form.email"
                            :error="form.errors.email"
                            label="User's email"
                            id="email"
                            required
                        />
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input
                                    :class="[
        'text-primary-600 rounded border-gray-300 transition',
        'focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-offset-0',
      ]"
                                    id="receive_email"
                                    type="checkbox"
                                    v-model="form.receive_email" />
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="receive_email" class="font-medium text-gray-700">Receive email notification</label>
                            </div>
                        </div>
                    </div>
                </form>
                <template #footer>
                    <div class="flex items-center space-x-3">
                        <Button @click="submit" primary :disabled="form.processing">Update user</Button>
                        <Button as="inertia-link" :href="route('users.show', user.id)" secondary>Cancel</Button>
                        <Button @click="destroy" danger>Delete</Button>
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
