<template>
  <textarea
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :class="[
      'block w-full max-w-lg border border-gray-300 rounded bg-gray-50 transition',
      { 'hover:border-gray-200': !error },
      { 'focus:bg-white focus:border-primary-500': !error },

      { 'border-red-600 bg-red-50 text-red-600': error },
      { 'hover:border-red-500': error },
      { 'focus:ring-red-600 focus:border-red-600': error },
    ]"
  ></textarea>
</template>

<script>
export default {
    props: {
        modelValue: {
            required: true,
        },
        error: {
            default: () => false,
        },
    },
}
</script>
