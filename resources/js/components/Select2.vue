<!-- Select2.vue -->
<template>
    <select ref="selectInstance" :id="id" :data-placeholder="placeholder" multiple="multiple">
        <option v-for="item in props.items" :key="item.id" :value="item.id">{{ item.text }}</option>
    </select>
</template>
  
  <script setup>
    import { onMounted, onUnmounted, watch, ref, toRaw } from 'vue';
    import Swal from 'sweetalert2';
    
    defineExpose({
        initialSelect2
    });
    const props = defineProps({
        className: String,
        id: String,
        purpose: String,
        placeholder: {
            type: String,
            default: ''
        },
        isLoading: {
            type: Boolean,
            default: false
        },
        items: {
            type: Array,
            default: () => []
        },
        hasChecks: {
            type: Boolean,
            default: false
        },
        type: {
            type: String,
            default: 'default'
        },
        modelValue: { 
            type: Array,
            default: () => []
        },
        noChipsDisplay: {
            type: Object,
            default: function() {
                return {
                    no_selected: 'Select Item',
                    multi_selected: 'Selected Items',
                    one_selected: 'Selected Item',
                }
            }
        },
    });
    const emit = defineEmits(['update:modelValue']);
    const { className, id, placeholder, purpose, noChipsDisplay } = props;
    const selectionCount = ref(0);
    let selectInstance = ref(null);
    let isProgrammaticChange = false;

    function initialSelect2(){
        $(selectInstance.value).val(props.modelValue);

        $(selectInstance.value).select2({
            data: props.items,
            placeholder: placeholder,
            tags: props.type != 'default',
            tokenSeparators: [',', '\x0b'],
            closeOnSelect: !props.hasChecks,
            templateResult: function (data) {
                if (!data.id) { return data.text; }
                if (props.hasChecks) {
                    return $(`<label class="checkbox_container d-block m-0" for="${data.text}_${data.id}">
                          <input class="checkbox_animated" id="${data.text}_${data.id}" type="checkbox">${data.text}
                        </label>`);
                }

                if(props.type === 'email'){
                    return $(`<div class='d-flex flex-column px-2 py-1'>
                            <label class='m-0 p-0'>${data.text}</label>
                            <small class='text-success'>${data.email ? data.email : 'N/A'}</small>
                        </div>`);
                }
                
                if(props.type === 'phone'){
                    return $(`<div class='d-flex flex-column px-2 py-1'>
                            <label class='m-0 p-0'>${data.text}</label>
                            <small class='text-success'>${data.phone ? formatPhoneNumber(data.phone) : 'N/A'}</small>
                        </div>`);
                }

                return data.text;
            },
            templateSelection: function (data) {
                if (props.type === 'email' && data.email) {
                    return data.email;
                }

                if (props.type === 'phone' && data.phone) {
                    return formatPhoneNumber(data.phone);
                }
                
                return data.text; 
            }
        }).on('select2:opening', function () {
            // Use setTimeout to allow the dropdown to render
            var selectedValues = $(selectInstance.value).val() || [];

            
            if(props.hasChecks){
                setTimeout(function() {
                    $('.select2-results__options').children('li').each(function () {
                        var $li = $(this);
                        var $checkbox = $li.find('.checkbox_animated');
                        var checkboxValue = $checkbox.attr('id').split('_')[1];

                        // Check if the checkbox value is in the selected values array
                        var isSelected = selectedValues.indexOf(checkboxValue) > -1;

                        // Update the checkbox state
                        $checkbox.prop('checked', isSelected);
                    });
                }, 50);
            }
        })
        .on('select2:selecting select2:unselecting', function(e) {
            if (props.type === 'email') {
                let itemEmail = e.params.args.data.email ?  e.params.args.data.email :  e.params.args.data.text;
                if (!isValidEmail(itemEmail)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'INVALID EMAIL!',
                        text: 'Please make sure that its a valid email.',
                    });
                    return;
                }
            }

            if (props.type === 'phone') {
                let itemPhone = e.params.args.data.phone ?  e.params.args.data.phone :  e.params.args.data.text;
                if (!isValidPhone(itemPhone)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'INVALID PHONE NUMBER!',
                        text: 'Please make sure that its a valid phone.',
                    });
                    return;
                }
            }

            let currentData = $(selectInstance.value).select2('data');
            let newCount = e.type === 'select2:selecting'
            ? currentData.length + 1
            : currentData.length - 1;
            selectionCount.value = newCount;

            if(props.hasChecks){
                setTimeout(function() {
                    var itemId = e.params.args.data.id;

                    $('.select2-results__options').children('li').each(function () {
                        var $li = $(this);
                        var $checkbox = $li.find('.checkbox_animated');
                        var checkboxId = $checkbox.attr('id').split('_')[1]; 

                        if (checkboxId === itemId) {
                            $checkbox.prop('checked', e.type === 'select2:selecting');
                        }
                    });
                }, 50);
            }
        })
        .on('change', function () {
            if (!isProgrammaticChange) {
                const value = $(selectInstance.value).val();
                emit('update:modelValue', value);
            }

            if(purpose === 'multiple-select-no-chips'){
                setTimeout(function() {
                    updateSelectionDisplay($(selectInstance.value));
                }, 0);
            }else{
                setTimeout(function() {
                    addMarginIntoChips($(selectInstance.value));
                }, 0);
            }
        });

        const selection = $(selectInstance.value).next('.select2-container').find('.select2-selection');
        selection.addClass(className);


        if(purpose === 'multiple-select-no-chips'){
            setTimeout(function() {
                updateSelectionDisplay($(selectInstance.value));
            }, 0);
        }else{
            if(props.isLoading){
                if(props.type === 'default'){
                    setLoading();
                }
            }else{
                if(props.type === 'default'){
                    const $selectionDisplay = $(selectInstance.value).next('.select2-container').find('.select2-selection__rendered');
                    $selectionDisplay.empty();
                    $selectionDisplay.append('<li class="px-3">' + placeholder + '</li>');
                }
            }
        }
    }

    function destroySelect2(){
        if ((selectInstance.value)) {
            $(selectInstance.value).select2('destroy');
            $(selectInstance.value).select2({
                placeholder: 'Loading...',
                tags: true
            });
        }
    }
  
    onMounted( () => {
        initialSelect2();
    });
  
    onUnmounted(() => {
        destroySelect2();
    });

    function updateSelectionDisplay($select) {
        const $selectionDisplay = $select.next('.select2-container').find('.select2-selection__rendered');
        let displayText = selectionCount.value > 0 ? `${selectionCount.value} ${noChipsDisplay.multi_selected}` : `${noChipsDisplay.no_selected}`;
        if(selectionCount.value == 1){
            displayText = `${selectionCount.value} ${noChipsDisplay.one_selected}`
        }

        if(props.type === 'default'){
            $selectionDisplay.empty();
            $selectionDisplay.append('<li class="px-3">' + displayText + '</li>');
        }
    }

    function addMarginIntoChips($select) {
        const $selectionDisplay = $select.next('.select2-container').find('.select2-selection__rendered');
        const $choices = $selectionDisplay.find('.select2-selection__choice');
        $choices.addClass('m-1');

        if(selectionCount.value === 0 && props.type === 'default'){
            $selectionDisplay.empty();
            $selectionDisplay.append('<li class="px-3">' + placeholder + '</li>');
        }
    }

    function setLoading(){
        const $selectionDisplay = $(selectInstance.value).next('.select2-container').find('.select2-selection__rendered');
        $selectionDisplay.empty();
        $selectionDisplay.append('<li class="px-3"> Loading... </li>');
    }

    function formatPhoneNumber(number) {
        if(number){
            const cleaned = ('' + number).replace(/\D/g, '');
            const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                    return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return number;
        }else{
            return 'N/A';
        }
   }

    watch(() => props.isLoading, (newVal) => {
        if(purpose !== 'multiple-select-no-chips'){
            if(!newVal){
                const $selectionDisplay = $(selectInstance.value).next('.select2-container').find('.select2-selection__rendered');

                if(props.type === 'default'){
                    $selectionDisplay.empty();
                    $selectionDisplay.append('<li class="px-3">' + placeholder + '</li>');
                }
            }else{
                setLoading();
            }
        }
    }, { deep: true });

    watch(() => props.modelValue, (newVal) => {
        isProgrammaticChange = true;
        const newValue = toRaw(newVal);

        if (newValue && newValue.length > 0) {
            selectionCount.value = newValue.length;
            $(selectInstance.value).val(newValue).trigger('change');
        }else{
            $(selectInstance.value).val([]).trigger('change');
            const $selectionDisplay = $(selectInstance.value).next('.select2-container').find('.select2-selection__rendered');
            $selectionDisplay.empty();
            $selectionDisplay.append('<li class="px-3">' + placeholder + '</li>');
        }
        isProgrammaticChange = false;
    }, { deep: true });

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidPhone(phone) {
        var phoneRegex = /^\d{10}$/;
        return phoneRegex.test(phone);
    }

    
</script>