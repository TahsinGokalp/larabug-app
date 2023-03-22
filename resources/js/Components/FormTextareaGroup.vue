<template>
    <div class="space-y-2">
        <Label :error="$attrs.error" :for="$attrs.id">{{ label }}</Label>
        <Textarea v-bind="$attrs"/>

        <Transition
                mode="out-in"
                enter-from-class="-translate-y-2 opacity-0"
                enter-active-class="transition duration-300 transform"
                enter-to-class="translate-y-0 opacity-100"
                leave-from-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-300 transform"
                leave-to-class="translate-y-2 opacity-0"
        >
            <FormErrorText v-if="$attrs.error" key="errorText">
                {{ $attrs.error }}
            </FormErrorText>

            <FormHelperText v-else-if="helperText" key="helperText">
                {{ helperText }}
            </FormHelperText>
        </Transition>
    </div>
</template>

<script>
import Label from '@/Components/Label.vue'
import Textarea from '@/Components/Textarea.vue'
import FormErrorText from '@/Components/FormErrorText.vue'
import FormHelperText from '@/Components/FormHelperText.vue'

export default {
    inheritAttrs: false,
    components: {
        Label,
        Textarea,
        FormErrorText,
        FormHelperText,
    },
    props: {
        label: {
            type: String,
            required: true,
        },
        helperText: {
            default: () => false,
        },
    },
}
</script>
