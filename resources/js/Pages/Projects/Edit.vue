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
        project: Object
    },

    data() {
        return {
            sending: false,
            form: useForm ({
                title: this.project.title,
                url: this.project.url,
                description: this.project.description,
                receive_email: this.project.receive_email,
                telegram_notification_enabled: this.project.telegram_notification_enabled,
                notifications_enabled: this.project.notifications_enabled,
            }),
        }
    },

    methods: {
        submit() {
            this.form.put(this.route('projects.update', this.project.id), {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false
            })
        },
        destroy() {
            this.form.delete(this.route('projects.destroy', this.project.id),{
                onBefore: () => confirm('Are you sure you want to delete this project?'),
            })
        },
    },
}
</script>

<template>
    <AppLayout title="Edit Project">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('projects.index')">Projects</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('projects.show', project.id)">{{ project.title }}</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('projects.edit', project.id)">Edit Project</BreadcrumbsItem>
            </Breadcrumbs>
            <Card contained>
                <template #header>
                    <h2 class="text-xl font-bold">Edit {{ project.title }} Project</h2>
                </template>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <FormInputGroup
                            v-model="form.title"
                            :error="form.errors.title"
                            helper-text="The project's title"
                            label="Title"
                            id="title"
                            required
                        />
                        <FormInputGroup
                            v-model="form.url"
                            :error="form.errors.url"
                            label="App URL"
                            id="app_url"
                            required
                        />
                        <FormTextareaGroup v-model="form.description" label="Description" id="description"/>
                    </div>
                    <div class="sm:col-span-6 border-t pt-4">
                        <div class="-ml-4 -mt-2 flex items-center justify-between">
                            <div class="ml-4 mt-2">
                                <h2 class="text-xl font-medium text-blue-gray-900">Notifications</h2>
                                <p class="mt-1 text-sm text-blue-gray-500">Here you can change the notification settings for this project.</p>
                            </div>
                            <div class="ml-4 mt-2 flex-shrink-0">
                                <input
                                    :class="[
        'text-primary-600 rounded border-gray-300 transition',
        'focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-offset-0',
      ]"
                                    id="notifications_enabled"
                                    type="checkbox"
                                    v-model="form.notifications_enabled" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-6" :class="{'opacity-25': !form.notifications_enabled}">
                        <div class="space-y-4">
                            <label class="text-base font-medium">On new exceptions</label>
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
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        :class="[
          'text-primary-600 rounded border-gray-300 transition',
          'focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-offset-0',
        ]"
                                        id="telegram_notification_enabled"
                                        type="checkbox"
                                        v-model="form.telegram_notification_enabled" />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="telegram_notification_enabled" class="font-medium text-gray-700">Receive Telegram notification</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <template #footer>
                    <div class="flex items-center space-x-3">
                        <Button @click="submit" primary :disabled="form.processing">Update project</Button>
                        <Button as="inertia-link" :href="route('projects.show', project.id)" secondary>Cancel</Button>
                        <Button @click="destroy" danger>Delete</Button>
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
