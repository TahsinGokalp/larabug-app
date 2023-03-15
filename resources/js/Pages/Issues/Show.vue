<script>
import AppLayout from '@/Layouts/AppLayout.vue'

import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'
import BreadcrumbsItemMain from '@/Components/BreadcrumbsItemMain.vue'
import Card from '@/Components/Card.vue'
import Badge from '@/Components/Badge.vue'
import Button from '@/Components/Button.vue'
import ButtonRack from '@/Components/ButtonRack.vue'
import ButtonRackItem from '@/Components/ButtonRackItem.vue'
import Code from '@/Components/Code.vue'
import Paginator from '@/Components/Paginator.vue'
import EditProject from '@/Partials/EditProject.vue'
import Dropdown from "@/Components/Dropdown.vue";
import DropdownOption from "@/Components/DropdownOption.vue";

export default {
    components: {
        AppLayout,
        DropdownOption,
        Dropdown,
        EditProject,
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        BreadcrumbsItemMain,
        Code,
        Card,
        Button,
        ButtonRack,
        ButtonRackItem,
        Paginator,
        Badge,
    },
    props: {
        issue: Object,
        exceptions: Object,
        project: Object,
        filters: Object,
        affected_versions: Array,
        last_occurrence_human: String,
        total_occurrences: Number,
    },
    data() {
        return {
            sending: false,

            selected: [],

            form: {
                issue: this.issue.id,
                status: this.filters.status,
                has_feedback: this.filters.has_feedback
            },
        }
    },
    methods: {
        updateStatus(status) {
            this.$inertia.patch(this.route('issues.update-status', [this.issue.id]), {
                status: status,
            });
        },
    },
}
</script>

<template>
    <AppLayout title="Projects">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('issues.index')">Issues</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('issues.show', issue.id)">{{ issue.exception }}</BreadcrumbsItem>
            </Breadcrumbs>
            <Card>
                <template #header>
                    <h2 class="text-xl font-bold">Issue</h2>

                    <div class="space-x-3">
                        <Button
                            :danger="issue.status === 'Open'"
                            :secondary="issue.status !== 'Open'"
                            @click="updateStatus('Open')">
                            Open
                        </Button>

                        <Button
                            :primary="issue.status === 'Read'"
                            :secondary="issue.status !== 'Read'"
                            @click="updateStatus('Read')">
                            Read
                        </Button>

                        <Button
                            :success="issue.status === 'Fixed'"
                            :secondary="issue.status !== 'Fixed'"
                            @click="updateStatus('Fixed')">
                            Fixed
                        </Button>
                    </div>
                </template>

                <dl class="grid grid-cols-3 gap-px overflow-hidden bg-gray-100 rounded-b-lg">
                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Exception</dt>
                        <dd class="text-base">{{ issue.exception }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Last occurrence</dt>
                        <dd class="text-base">{{ last_occurrence_human }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Affected versions</dt>
                        <dd class="text-base">{{ affected_versions }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Project</dt>
                        <dd class="text-base">{{ project.title }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">Total occurrences</dt>
                        <dd class="text-base">{{ total_occurrences }}</dd>
                    </div>

                    <div class="p-6 space-y-1 bg-white">
                        <dt class="text-sm font-medium">New occurrences</dt>
                        <dd class="text-base">{{ issue.unread_exceptions_count }}</dd>
                    </div>
                </dl>
            </Card>
            <Card class="mt-4">
                <template #buttonheader>
                    <h2 class="text-xl font-bold">Occurrences</h2>
                </template>
                <ul class="divide-y divide-gray-200">
                    <li v-for="exception in exceptions.data" :key="exception.id">
                        <div :href="route('exceptions.show', {id: issue.project_id, exception: exception })"
                             class="flex items-center px-6 py-4 space-x-6 hover:bg-gray-100">
                            <inertia-link class="flex flex-1 items-center"
                                          :href="route('exceptions.show', {id: issue.project_id, exception: exception })">
                                <div class="flex-1">
                                    <p class="font-medium text-bold"
                                       v-bind:class="{'text-gray-500': exception.status === 'Fixed'}">
                                    </p>

                                    <p class="text-sm text-gray-600">
                                        <Badge success v-if="exception.status === 'Fixed'">{{
                                                exception.status_text
                                            }}
                                        </Badge>
                                        <Badge info v-if="exception.status === 'Read'">{{ exception.status_text }}</Badge>
                                        <Badge danger v-if="exception.status === 'Open'">{{ exception.status_text }}</Badge>
                                        <span v-if="exception.snooze_until">&centerdot; </span>
                                        <Badge info v-if="exception.snooze_until">Snoozed until {{
                                                exception.snooze_until
                                            }}
                                        </Badge>
                                        &centerdot; {{ exception.human_date }} &centerdot;
                                        {{ exception.created_at }}
                                        <Badge info v-if="exception.file_type === 'javascript'">&centerdot; Javascript
                                        </Badge>
                                    </p>
                                </div>
                                <div class="flex-1"></div>

                                <span v-if="exception.project_version">
                <Badge gray big>{{
                        exception.project_version
                    }}</Badge>
              </span>

                                <span v-if="exception.environment">
                <Badge gray big>{{
                        exception.environment
                    }}</Badge>
              </span>

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
                        </div>
                    </li>
                </ul>

                <template #footer>
                    <Paginator :paginated="exceptions"/>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>
