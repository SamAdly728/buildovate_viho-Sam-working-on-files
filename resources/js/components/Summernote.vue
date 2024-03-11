<template>
    <textarea ref="summernoteArea" style="width: 100%;"></textarea>
</template>

<script setup>
    import { ref, onMounted, onBeforeUnmount, defineProps, watch, defineEmits } from 'vue';
    import $ from 'jquery';
    import 'summernote/dist/summernote-lite.js';
    import 'summernote/dist/summernote-lite.css';

    const props = defineProps(['modelValue', 'disabled']);
    const emit = defineEmits(['update:modelValue']);
    const summernoteArea = ref(null);

    onMounted(() => {
        try {
            $(summernoteArea.value).summernote({
                width: "100%",
                height: "100%",
                callbacks: {
                    onInit: function() {
                        $(summernoteArea.value).summernote('code', props.modelValue);
                        if (props.disabled) {
                            $(summernoteArea.value).summernote('disable');
                        } else {
                            $(summernoteArea.value).summernote('enable');
                        }
                    }
                }
            }).on('summernote.keyup summernote.mouseup', function() {
                const content = $(summernoteArea.value).summernote('code');
                emit('update:modelValue', content);
            });
        } catch (error) {
            console.error("Error initializing Summernote:", error);
        }
    });

    onBeforeUnmount(() => {
        $(summernoteArea.value).summernote('destroy');
    });

    watch(() => props.disabled, (newVal) => {
        if (newVal) {
            $(summernoteArea.value).summernote('disable');
        } else {
            $(summernoteArea.value).summernote('enable');
        }
    });

    watch(() => props.modelValue, (newVal) => {
        if ($(summernoteArea.value).summernote('code') !== newVal) {
            $(summernoteArea.value).summernote('code', newVal);
        }
    });
</script>