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
import Checkbox from '@/Components/Checkbox.vue'
import { useForm } from '@inertiajs/vue3'

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        BreadcrumbsItemMain,
        Checkbox,
        Card,
        Button,
        FormInputGroup,
        FormTextareaGroup,
    },
    data() {
        return {
            sending: false,
            form: useForm ({
                name: null,
                email: null,
                receive_email: false,
            }),
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('users.store'), {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false
            })
        },
    },
}
</script>

<template>
    <AppLayout title="Create User">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.index')">Users</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('users.create')">Create User</BreadcrumbsItem>
            </Breadcrumbs>
            <Card contained>
                <template #header>
                    <h2 class="text-xl font-bold">New user</h2>
                </template>

                <form class="space-y-6" action="">
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
                        <Button @click="submit" primary :disabled="sending">Create user</Button>
                        <Button as="inertia-link" :href="route('users.index')" secondary>Cancel</Button>
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
