<template>
    <Modal :is-open="editOpen" close-link="/projects/show">
        <Card contained>
            <template #header>
                <h2 class="text-xl font-bold">New project</h2>
            </template>

            <form class="space-y-6" action="">
                <FormInputGroup
                        v-model="test"
                        :error="error"
                        helper-text="The project's title"
                        label="Title"
                        id="title"
                        required
                />
                <FormInputGroup v-model="test" label="App URL" id="app_url" required/>

                <div class="grid grid-cols-2 gap-4">
                    <FormInputGroup
                            v-model="test"
                            label="Slack Webhook URL"
                            id="slack_webhook_url"
                            required
                    />
                    <FormInputGroup
                            v-model="test"
                            label="Discord Webhook URL"
                            id="discord_webhook_url"
                            required
                    />
                </div>

                <FormTextareaGroup v-model="test" label="Description" id="description"/>
            </form>

            <template #footer>
                <div class="flex items-center space-x-3">
                    <Button primary>Create project</Button>
                    <Button secondary>Cancel</Button>
                </div>
            </template>
        </Card>
    </Modal>
</template>

<script>
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'
import FormInputGroup from '@/Components/FormInputGroup.vue'
import FormTextareaGroup from '@/Components/FormTextareaGroup.vue'
import Modal from '@/Components/Modal.vue'

export default {
    components: {
        Card,
        Button,
        FormInputGroup,
        FormTextareaGroup,
        Modal,
    },
    data() {
        return {
            error: false,
            test: 'test',
        }
    },
    props: {
        project: {
            // type: Object,
            required: false,
        },
        editOpen: {
            default: false,
        }
    },
}
</script>
