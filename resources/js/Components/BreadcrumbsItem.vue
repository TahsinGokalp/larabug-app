<template>
    <li>
        <div class="flex items-center">
            <InertiaLink
                v-bind="$attrs"
                :class="[
        'text-sm',
        'font-medium',
        'text-gray-700',
        'hover:text-blue-600',
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
