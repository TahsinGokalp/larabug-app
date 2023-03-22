<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import BreadcrumbsItem from '@/Components/BreadcrumbsItem.vue'
import BreadcrumbsItemMain from '@/Components/BreadcrumbsItemMain.vue'
import BreadcrumbsDivider from '@/Components/BreadcrumbsDivider.vue'

defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});
</script>

<template>
    <AppLayout title="API Tokens">
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Breadcrumbs>
                    <BreadcrumbsItemMain :href="route('dashboard')">Dashboard</BreadcrumbsItemMain>
                    <BreadcrumbsDivider/>
                    <BreadcrumbsItem :href="route('api-tokens.index')">API Tokens</BreadcrumbsItem>
                </Breadcrumbs>
                <ApiTokenManager
                    :tokens="tokens"
                    :available-permissions="availablePermissions"
                    :default-permissions="defaultPermissions"
                />
            </div>
        </div>
    </AppLayout>
</template>
