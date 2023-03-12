<script setup>
import SectionTitle from './SectionTitle.vue';
</script>

<template>
    <div class="">
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                <SectionTitle>
                    <template #title>
                        <slot name="title" />
                    </template>
                    <template #description>
                        <slot name="description" />
                    </template>
                </SectionTitle>
                <hr class="mb-4"/>
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
