<template>
    <InertiaHead title="Profile" />

    <div class="flex flex-col space-y-8">
        <Breadcrumbs>
            <BreadcrumbsItem href="/panel/profile">Profile settings</BreadcrumbsItem>
        </Breadcrumbs>

        <Card contained>
            <template #header>
                <h2 class="text-xl font-bold">Profile</h2>
            </template>

            <form class="space-y-6" action="">
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
                    type="email"
                    label="E-mail"
                    id="email"
                    required
                />
            </form>

            <template #footer>
                <div class="flex items-center space-x-3">
                    <Button @click="update" primary :disabled="form.processing">Save profile</Button>
                </div>
            </template>
        </Card>

        <Card contained>
          <template #header>
            <h2 class="text-xl font-bold">Password</h2>
          </template>

          <form class="space-y-6" action="">
            <FormInputGroup
                v-model="password.current"
                :error="password.errors.current"
                type="password"
                label="Current Password"
                id="current_password"
                required
            />

            <FormInputGroup
                v-model="password.password"
                :error="password.errors.password"
                type="password"
                label="New Password"
                id="new_password"
                required
            />

            <FormInputGroup
                v-model="password.password_confirmation"
                :error="password.errors.password_confirmation"
                type="password"
                label="Confirm New Password"
                id="confirm_new_password"
                required
            />
          </form>

          <template #footer>
            <div class="flex items-center space-x-3">
              <Button @click="changePassword" primary :disabled="password.processing">Change password</Button>
            </div>
          </template>
        </Card>

    </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

import Breadcrumbs from '@/Components/Breadcrumbs'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider'
import Card from '@/Components/Card'
import Button from '@/Components/Button'
import FormInputGroup from '@/Components/FormInputGroup'
import FormTextareaGroup from '@/Components/FormTextareaGroup'
import Checkbox from '@/Components/Checkbox'
import { useToast } from "vue-toastification";
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    layout: AppLayout,
    components: {
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        Card,
        Button,
        FormInputGroup,
        FormTextareaGroup,
        Checkbox,
    },
    data() {
        return {
            sending: false,
            form: useForm ({
                name: this.user.name,
                email: this.user.email,
                password: this.user.password,
                settings: this.settings
            }, {
              key: 'form'
            }),
            password: useForm ({
              current: null,
              password: null,
              password_confirmation: null
            }, {
              key: 'password',
              remember: false,
            }),
        }
    },
    props: {
        user: Object,
        settings: Object
    },
    methods: {
        update() {
            this.form.patch(this.route('panel.profile.update'), {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false
            });
        },
        changePassword() {
            this.password.patch(this.route('panel.profile.changePassword'), {
                onStart: () => this.sending = true,
                onSuccess: () => this.password.reset(),
                onFinish: () => {
                    this.sending = false
                    this.password.reset()
                }
            });
        },
        updateSettings() {
            this.sending = true

            this.form.patch(this.route('panel.profile.settings'), {
                onFinish: () => this.sending = false
            })
        }
    },

    setup() {
        const toast = useToast();
        return { toast }
    },
}
</script>
