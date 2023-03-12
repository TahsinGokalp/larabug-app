<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsItemMain from '@/Components/BreadcrumbsItemMain.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        BreadcrumbsItem,
        BreadcrumbsDivider,
        BreadcrumbsItemMain,
        Card,
        Button,
    },
    props: {
        project: Object,
        guide: {
            default: () => false,
        },
    },
    data() {
        return {
            step: 1,
        }
    },
}
</script>

<template>
    <AppLayout title="Installation">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Breadcrumbs>
                <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('projects.index')">Projects</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('projects.show', project.id)">{{ project.title }}</BreadcrumbsItem>
                <BreadcrumbsDivider/>
                <BreadcrumbsItem :href="route('projects.installation', project.id)">Installation Guide</BreadcrumbsItem>
            </Breadcrumbs>
            <Card>
                <template #header>
                    <h2 class="text-xl font-bold">Installation for {{ project.title }} Project</h2>
                </template>
                <div>
                    <header class="sticky top-0 z-10 flex items-center bg-white border-b border-gray-200">
                        <button
                            class="inline-flex items-center justify-center h-12 px-6 text-sm font-medium"
                            :class="{'border-b border-blue-500' : step === 1 }"
                            @click="step = 1"
                        >
                            1. Installation
                        </button>
                        <button
                            class="inline-flex items-center justify-center h-12 px-6 text-sm font-medium"
                            :class="{'border-b border-blue-500' : step === 2 }"
                            @click="step = 2"
                        >
                            2. Usage
                        </button>
                    </header>

                    <div class="relative p-6 overflow-hidden">
                        <TransitionGroup
                            mode="out-in"
                            enter-from-class="-translate-x-6 opacity-0"
                            enter-active-class="transition duration-300 transform"
                            enter-to-class="translate-x-0 opacity-100"
                            leave-from-class="translate-x-0 opacity-100"
                            leave-active-class="absolute transition duration-300 transform"
                            leave-to-class="translate-x-6 opacity-0"
                        >
                            <div key="step-1" v-if="step === 1">
                                <div class="prose">
                                    <h2>Step 1 - Installation</h2>
                                    <p>Install the package in your project:</p>
                                    <pre>composer require tahsingokalp/lett</pre>
                                    <p>Publish the config file:</p>
                                    <pre>php artisan vendor:publish --provider="Lett\ServiceProvider"</pre>
                                    <p>
                                        Next is to add the <code>lett</code> driver to the
                                        <code>logging.php</code> file:
                                    </p>
                                    <pre>
'channels' => [
    // ...
    'lett' => [
        'driver' => 'lett',
    ],
],
                </pre>
                                    <p>
                                        After that you have configured the Lett channel you can add it to the stack
                                        section:
                                    </p>
                                    <pre>
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'lett'],
    ],
    //...
],
                </pre>
                                    <Button primary @click="step = 2">Next</Button>
                                </div>
                            </div>

                            <div v-if="step === 2" class="space-y-4">
                                <div class="prose" key="step-2">
                                    <h2>Step 2 - Usage</h2>
                                    <p>
                                        Now all that is left to do is to add the 2 enviroment variables to your .env file:
                                    </p>
                                    <pre>
LETT_KEY={{ $page.props.auth.user.api_token }}
LETT_PROJECT_KEY={{ project.key }}
</pre>
                                    <p>Now test to see if it works, you can do this in two ways.</p>
                                    <h3>Option 1</h3>
                                    <p>Run this in your terminal:</p>
                                    <pre>php artisan lett:test</pre>
                                    <h3>Option 2</h3>
                                    <p>Run this code in your application to see if the exception is received by Lett.</p>
                                    <pre>throw new \Exception('Testing my application!');</pre>
                                </div>
                                <div class="flex justify-between">
                                    <Button secondary @click="step = 1">Back</Button>
                                    <Button primary as="inertia-link" :href="route('projects.show', project.id)">Finish</Button>
                                </div>
                            </div>
                        </TransitionGroup>
                    </div>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
