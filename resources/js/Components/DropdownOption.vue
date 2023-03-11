<template>
  <li>
    <button
        @click="$emit('click', $event)"
        class="flex items-center w-full h-8 px-3 text-sm font-medium focus:outline-none hover:bg-primary-600 hover:text-white focus:bg-primary-700 focus:text-white group"
        type="button">
      <span><slot /></span>
    </button>
  </li>
</template>

<script>
export default {
  name: "DropdownOption",
  emits: [
      'click',
  ],
}
</script>

<style scoped>

</style>