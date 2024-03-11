<?php

return [
    'colors' => [
        '#FFF4E6', '#FAF9F6',  // Soft Whites
        '#D3D3D3', '#A9A9A9',  // Greys
        '#D2B48C', '#F5F5DC',  // Beiges and Tans
        '#ADD8E6', '#6CA0DC',  // Blues
        '#90EE90', '#3CB371',  // Greens
        '#FF6347', '#6B8E23',  // Accent Colors
        '#8B4513', '#DEB887',  // Wood Tones
        '#BCC6CC', '#D4AF37',  // Metallic Tones
        '#000000', '#FFFFFF',  // Blacks and Whites
    ],
    'form_builder_fields' => [
        [
            'id' => '', 
            'label' => 'Input Number', 
            'icon' => 'icon-pencil-alt', 
            'data' => [
                'label' => 'Number Field',
                'hideLabel' => false,
                'instruction' => '',
                'hideInstruction' => false,
                'visibility' => 1,
                'rules' => []
            ],
        ],
        [
            'id' => '', 
            'label' => 'Radio Style 1', 
            'icon' => 'icon-control-record',
            'data' => [
                'label' => 'Radio Style 1',
                'hideLabel' => false,
                'instruction' => '',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [],
                'rules' => []
            ],
        ],
        [
            'id' => '', 
            'label' => 'Radio Style 2', 
            'icon' => 'icon-flickr',
            'data' => [
                'label' => 'Radio Style 2',
                'hideLabel' => false,
                'instruction' => '',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [],
                'rules' => []
            ],
        ],
        [
            'id' => '', 
            'label' => 'Color Picker', 
            'icon' => 'icon-hummer',
            'data' => [
                'label' => 'Color Picker',
                'hideLabel' => false,
                'instruction' => '',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [
                    ['label' => '#fcba03', 'value' => '#fcba03'],
                    ['label' => '#24695C', 'value' => '#24695C'],
                    ['label' => '#989a99', 'value' => '#989a99'],
                ],
                'rules' => []
            ],
        ],
        [
            'id' => '', 
            'label' => 'Form Header', 
            'icon' => 'icon-text',
            'data' => [
                'label' => 'Header',
                'hideLabel' => false,
                'instruction' => 'Write a instruction here',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [],
                'rules' => []
            ],
        ],
        [   
            'id' => '', 
            'label' => 'Separator', 
            'icon' => 'icon-line-double',
            'data' => [
                'label' => 'Separator',
                'hideLabel' => false,
                'instruction' => '',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [],
                'rules' => []
            ],
        ],
        [
            'id' => '', 
            'label' => 'Image Picker', 
            'icon' => 'icon-image',
            'data' => [
                'label' => 'Image Picker',
                'hideLabel' => false,
                'instruction' => 'Select sample image of your choice',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [
                    ['label' => 'Option 1', 'value' => 1],
                ],
                'rules' => []
            ],
        ],
        [
            'id' => '', 
            'label' => 'Item Picker', 
            'icon' => 'icon-shopping-cart',
            'data' => [
                'label' => 'Item Picker',
                'hideLabel' => false,
                'instruction' => 'Add items from the catalog to be selected.',
                'hideInstruction' => false,
                'visibility' => 1,
                'options' => [],
                'rules' => []
            ],
        ],
        // [
        //     'id' => '', 
        //     'label' => 'Summary', 
        //     'icon' => 'icon-wand',
        //     'data' => [
        //         'label' => 'Summary',
        //         'hideLabel' => false,
        //         'instruction' => 'This field is not visible on actual form.',
        //         'hideInstruction' => false,
        //         'visibility' => 0,
        //         'options' => [],
        //         'rules' => []
        //     ],
        // ],
    ],
    'conditions' => [
        'single' => [
            'Is',
            'Is Not',
            'Is Empty',
            'Is Not Empty',
            'Starts With',
            'Ends With',
            'Other Choice is'
        ],
        'multiple' => [
            'Contains',
            'Not Contains',
            'Contains Any of',
            'Contains All of',
            'Contains None of',
            'Is Any of',
            'Is None of'
        ],
        'number' => [
            'Is',
            'Is Not',
            'Is Empty',
            'Is Not Empty',
            'Less than',
            'Greater than',
            'Between',
            'Outside'
        ]
    ],
    'asset_link' => 'https://buildovate-development.s3.us-west-1.amazonaws.com/images/'
];
