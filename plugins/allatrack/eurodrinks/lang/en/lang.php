<?php

return [
    'app'                  => [
        'name'    => 'Eurodrinks',
        'tagline' => 'Getting back to basics'
    ],
    'stat'                 => [
        'menu_title' => 'Stastistics',
        'title'      => ':contractor_name\'s stastistics',
    ],
    'presentations'        => 'Presentations',
    'superuser'            => 'Superuser',
    'eurodinks_statistics' => 'Eurodrinks\'s statistics',
    'import_name'          => 'The name used for Excel import proccess',
    'to_top' =>'Up',
    'no_article_data'          => 'No more news to display',
    'brand'                => [
        'new'                     => 'Add brand',
        'edit'                    => 'Edit brand',
        'title'                   => 'Brands',
        'one'                     => 'Brand',
        'contractor'              => 'Contractor(s)',
        'add_contractor'          => '<p>' . link_to('backend/allatrack/eurodrinks/contractors/create', 'Add', ['target' => '_blank']) . ' contractor, if it is not in list</p>',
        'stat_upload'             => 'Statictics upload',
        'stat_upload_description' => 'Upload statistics per brand',
        'title_per_brand'         => 'Statistics for <strong>:brandName</strong>',
        'stat_file_uploaded'      => 'Statistics uploaded successfully',
        'percentage_difference'   => 'Changing in %',
        'upload'                  => 'Upload',
        'how_to_load'             => 'How to upload statistics?',
        'select_file'             => 'Select the file which structure is <b>strictly equal</b> <a href=":link">to this file</a></b> (the number of brands and products may be different)',
        'stat_upload_file'        => 'Select statsitics file',
        'press_load_button'       => 'Press to the <b>Upload button</b>',
        'last_update'             => 'Last time the statistics was updated :last_update',
        'manage'                  => 'Brand management',
        'manage_title'            => 'Add, edit or delete an existing brand',
        'slug_comment'            => 'The internal brand name must match the brand name
         in the imported Excel file. If you imported statistics and at the same time in your profile
          statistics it is not displayed, then most likely the name does not match.',
        'import'                  => 'Import stats',
        'import_all'              => 'Import statistics for all brands',
        'errors'                  => [
            'nothing_to_show'          => 'There are no statistics to display for this brand.',
            'stat_file_is_absent'      => 'No statistics file',
            'no_brand'                 => 'Brand not assigned',
            'user_not_assigned'        => 'Current user is not affiliated with the brand',
            'file_open_error'          => 'Problem with opening file: :error',
            'stat_is_absent_per_brand' => 'You entered the site on behalf of the brand, for which the statistics have not yet been uploaded',
        ],
        'product'                 => 'Product',
    ],
    'product'              => [
        'add'             => 'Add item',
        'view'            => 'View product',
        'edit'            => 'Edit item',
        'remove'          => 'Delete product',
        'manage'          => 'Product Management',
        'title'           => 'Goods',
        'one'             => 'Good',
        'delete_selected' => 'Delete selected?',
        'info'            => 'Product information',
        'capacity'        => 'Volume of l.',
        'manage_title'    => 'Add, remove, or edit product information',
        'image'           => 'Picture',
        'name_ru'         => 'Name (ru)',
        'name_uk'         => 'Name (uk)',
        'name_en'         => 'Name (en)',
        'description_en'  => 'Description (en)',
        'description_ru'  => 'Description (ru)',
        'description_uk'  => 'Description (uk)',
    ],
    'contractor'           => [
        'add_address'                 => '<p>' . link_to('backend/allatrack/eurodrinks/addresses/create', 'Add', ['target' => '_blank']) . ' address, if it is not in list</p>',
        'add_brand'                 => '<p>' . link_to('backend/allatrack/eurodrinks/brands/create', 'Add', ['target' => '_blank']) . ' brand, if it is not in list</p>',
        'add'                         => 'Add contractor',
        'view'                        => 'View contractor',
        'edit'                        => 'Edit contractor',
        'remove'                      => 'Delete contractor',
        'manage'                      => 'Contractor Management',
        'title'                       => 'Contractors',
        'one'                         => 'Contractor',
        'info'                        => 'Contractor info',
        'manage_title'                => 'Add, remove, or edit contractor information',
        'edrpoy'                      => 'ERDPY',
        'is_group'                    => 'Belongs to the group',
        'imported_name'               => 'Name when importing from Excel',
        'imported_name_input_comment' => 'Used when importing',
        'group'                       => 'Company group',
        'select_group'                => 'Select a company',
        'address'                     => 'Address',
        'has_address'                 => 'Link an existing address',
        'new_address'                 => 'Add an address',
        'select_address'              => 'Choose an address',
    ],
    'address'              => [
        'add'           => 'Add an address',
        'view'          => 'View address',
        'edit'          => 'Edit address',
        'remove'        => 'Delete address',
        'manage'        => 'Manage address',
        'title'         => 'Addresses',
        'one'           => 'Address',
        'info'          => 'Address info',
        'manage_title'  => 'Add, remove, or edit address information',
        'edrpoy'        => 'ERDPY',
        'is_group'      => 'Belongs to the group',
        'select_on_map' => 'Select a point on the map',
    ],
    'return_to_list'       => 'Back to the list',
    'delete_selected'      => 'Delete selected?',
    'connect_admin'        => 'Contact the site administrator',
    'error'                => 'Error',
    'error_occurs'         => 'There were difficulties',
    'slug'                 => 'Internal name',
    'slug_required'        => 'Internal name is required',
    'slug_unique'          => 'The internal name must be unique',
    'name_ru'              => 'Name (ru)',
    'name_uk'              => 'Name (uk)',
    'name_en'              => 'Name (en)',
    'description_uk'       => 'Description (uk)',
    'description_ru'       => 'Description (ru)',
    'description_en'       => 'Description (en)',
    'save'                 => '<u>S</u>ave',
    'save_and_close'       => 'Save and Close',
    'create'               => "Create",
    'create_and_close'     => "Create and Close",
    'or'                   => "or",
    'cancel'               => "Cancel",

    'january'   => 'January',
    'february'  => 'February',
    'march'     => 'March',
    'april'     => 'April',
    'may'       => 'May',
    'june'      => 'June',
    'july'      => 'July',
    'august'    => 'August',
    'september' => 'September',
    'october'   => 'October',
    'november'  => 'November',
    'december'  => 'December',
    'total_p'   => 'Total %',
    'total_l'   => 'Total l.',
    'total_g_l' => 'Total g/l',
    'months_by_number'=>[
        1=> 'January :d, :y',
        2=> 'February :d, :y',
        3=> 'March :d, :y',
        4=> 'April :d, :y',
        5=> 'May :d, :y',
        6=> 'June :d, :y',
        7=> 'July :d, :y',
        8=> 'August :d, :y',
        9=> 'September :d, :y',
        10=> 'October :d, :y',
        11=> 'November :d, :y',
        12=> 'December :d, :y',
    ],

];