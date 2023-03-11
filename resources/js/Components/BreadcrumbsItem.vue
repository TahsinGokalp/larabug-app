<template>
    <li>
        <div class="flex items-center">
            <InertiaLink
                v-bind="$attrs"
                :class="[
        'ml-1',
        'text-sm',
        'font-medium',
        'text-gray-700',
        'hover:text-blue-600',
        'md:ml-2'
      ]"
            >
                <slot></slot>
            </InertiaLink>
        </div>
    </li>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>
