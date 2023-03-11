<template>
  <div
    :class="[
      'flex items-center border border-gray-300 divide-x divide-gray-200 rounded-md shadow-sm sm:h-7 overflow-hidden transition',
      'focus-within:ring focus-within:ring-blue-100',
    ]"
  >
    <slot></slot>
  </div>
</template>
