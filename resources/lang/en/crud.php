<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CRUD Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in CRUD operations throughout the
    | system.
    | Regardless where it is placed, a CRUD label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'actions' => 'Actions',
    'permissions' => [
        'name' => 'Name',
        'permission' => 'Permission',
        'dependencies' => 'Dependencies',
        'roles' => 'Roles',
        'system' => 'System?',
        'total' => 'permission(s) total',
        'users' => 'Users',
        'group' => 'Group',
        'group-sort' => 'Group Sort',
        'groups' => [
            'name' => 'Group Name',
        ],
    ],
    'roles' => [
        'number_of_users' => '# Users',
        'permissions' => 'Permissions',
        'role' => 'Role',
        'total' => 'role(s) total',
        'sort' => 'Sort',
    ],
    'users' => [
        'confirmed' => 'Confirmed',
        'created' => 'Created',
        'delete_permanently' => 'Delete Permanently',
        'email' => 'E-mail',
        'id' => 'ID',
        'last_updated' => 'Last Updated',
        'name' => 'Name',
        'nickname' => 'Nickname',
        'no_banned_users' => 'No Banned Users',
        'no_deactivated_users' => 'No Deactivated Users',
        'no_deleted_users' => 'No Deleted Users',
        'other_permissions' => 'Other Permissions',
        'certified' => 'Certified',
        'restore_user' => 'Restore User',
        'roles' => 'Roles',
        'total' => 'user(s) total',
        'comment' => 'Comment',
        'approved' => 'Status',
        'Created' => 'Created',
        

    ],

    'pages' => [
        'confirmed' => 'Confirmed',
        'created' => 'Created',
        'delete_permanently' => 'Delete Permanently',
        'email' => 'E-mail',
        'id' => 'ID',
        'last_updated' => 'Last Updated',
        'title' => 'Title',
        'total' => 'page(s) total',
        'name' => 'Uploaded By',
        'gname' => 'Added By',
        'caption' => 'Caption',
        'user' => 'Place',
        'image' => 'Image',
        'image_type' => 'Type',
        'status' =>'Status',
        'created' => 'Created',
    ],

    

     "datatables" => [               // DataTables, files can be found @ https://datatables.net/plug-ins/i18n/
        "sInfo"                     => "Showing _START_ to _END_ of _TOTAL_ entries",
        "sInfoEmpty"                => "Showing 0 to 0 of 0 entries",
        "sInfoFiltered"             => "(filtered from _MAX_ total entries)",
        "sInfoPostFix"              => "",
        "sLengthMenu"               => "Show _MENU_ entries",
        "sProcessing"               => "Processing...",
        "sSearch"                   => "Search:",
        "sUrl"                      => "",
        "sZeroRecords"              => "No matching records found",
        "oPaginate" => [
            "sFirst"                => "First",
            "sLast"                 => "Last",
            "sNext"                 => "Next",
            "sPrevious"             => "Previous"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | CRUD Language Lines outside view Files
    |--------------------------------------------------------------------------
    |
    | These lines are being marked as obsolete by the localization helper
    | because they will only be found outside view files.
    |
    */
    'activate_user_button' => 'Activate User',
    'ban_user_button' => 'Ban User',
    'change_password_button' => 'Change Password',
    'deactivate_user_button' => 'Deactivate User',
    'delete_button' => 'Delete',
    'edit_button' => 'Edit',

];