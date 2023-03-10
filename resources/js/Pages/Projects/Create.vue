<script>

import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'
import FormInputGroup from '@/Components/FormInputGroup.vue'
import FormTextareaGroup from '@/Components/FormTextareaGroup.vue'
import { useForm } from '@inertiajs/vue3'

export default {
    layout: AppLayout,
    components: {
        Card,
        Button,
        FormInputGroup,
        FormTextareaGroup,
    },
    data() {
        return {
            sending: false,
            form: useForm ({
                title: null,
                url: null,
                description: null,
                receive_email: true,
                telegram_notification_enabled: true,
                notifications_enabled: true,
            }),
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('projects.store'), {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false
            })
        },
    },
}
</script>

<template>
    <AppLayout title="Create Project">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Card contained>
                <template #header>
                    <h2 class="text-xl font-bold">New project</h2>
                </template>

                <form class="space-y-6" action="">
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

                    <div class="mt-4 space-y-4" :class="{'opacity-25': !form.notifications_enabled}">
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
                                <label for="telegram_notification_enabled" class="font-medium text-gray-700">Receive telegram notification</label>
                            </div>
                        </div>
                    </div>
                </form>

                <template #footer>
                    <div class="flex items-center space-x-3">
                        <Button @click="submit" primary :disabled="sending">Create project</Button>
                        <Button as="inertia-link" :href="route('projects.index')" secondary>Cancel</Button>
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
