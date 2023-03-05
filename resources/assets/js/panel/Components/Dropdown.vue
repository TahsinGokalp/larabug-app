<template>
    <div class="relative">
        <div @click="optionListOpen = !optionListOpen">
            <slot name="button" />
        </div>

        <div class="absolute z-10 mt-2 shadow-xl w-52 rounded-lg top-full"
             v-if="optionListOpen">
            <ul class="py-1 space-y-1 overflow-hidden bg-white shadow rounded-lg">
                <slot name="options" />
            </ul>
        </div>
    </div>
</template>

<script>
import Button from "./Button.vue";
export default {
    name: "Dropdown",
    components: {
        Button
    },
    data() {
        return {
            optionListOpen: false,
        }
    },
}
</script>