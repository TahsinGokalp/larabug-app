<template>
    <div class="space-y-2">
        <Label :error="error" :for="$attrs.id">{{ label }}</Label>
        <Input v-bind="$attrs"/>

        <Transition
                mode="out-in"
                enter-from-class="-translate-y-2 opacity-0"
                enter-active-class="transition duration-300 transform"
                enter-to-class="translate-y-0 opacity-100"
                leave-from-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-300 transform"
                leave-to-class="translate-y-2 opacity-0"
        >
            <FormErrorText v-if="error" key="errorText">
                {{ error[0] }}
            </FormErrorText>

            <FormHelperText v-else-if="helperText" key="helperText">
                {{ helperText }}
            </FormHelperText>
        </Transition>
    </div>
</template>

<script>
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import FormErrorText from '@/Components/FormErrorText.vue'
import FormHelperText from '@/Components/FormHelperText.vue'

export default {
    inheritAttrs: false,
    components: {
        Label,
        Input,
        FormErrorText,
        FormHelperText,
    },
    props: {
        label: {
            type: String,
            required: true,
        },
        error: Array,
        helperText: {
            default: () => false,
        },
    },
}
</script>
