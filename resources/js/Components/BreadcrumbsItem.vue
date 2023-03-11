<template>
    <li>
        <InertiaLink
            v-bind="$attrs"
            :class="[
        'text-base text-gray-600 font-medium transition',
        'focus:outline-none',
        'hover:text-gray-800',
        'focus:underline',
      ]"
        >
            <slot></slot>
        </InertiaLink>
    </li>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>
