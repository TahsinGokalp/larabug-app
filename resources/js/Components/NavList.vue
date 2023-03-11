<template>
  <ul class="flex-1" v-bind="$attrs" :class="
    [
      big ? 'my-2' : '',
      isopen ? 'block' : 'hidden'
    ]
  ">
    <slot></slot>
  </ul>
</template>

<script>
export default {
    props: {
        big: {
            default: true,
            type: Boolean
        },
        isopen: {
            default: false,
            type: Boolean
        }
    }
}
</script>