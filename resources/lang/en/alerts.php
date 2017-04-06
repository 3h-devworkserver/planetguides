<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'permissions' => [
        'created' => 'Permission successfully created.',
        'updated' => 'Permission successfully updated.',
        'deleted' => 'Permission successfully deleted.',
        'groups'  => [
            'created' => 'Permission group successfully created.',
            'updated' => 'Permission group successfully updated.',
            'deleted' => 'Permission group successfully deleted.',
        ],
    ],

    'roles' => [
        'created' => 'The role was successfully created.',
        'updated' => 'The role was successfully updated.',
        'deleted' => 'The role was successfully deleted.'
    ],

    'users' => [
        'created' => 'The user was successfully created.',
        'updated' => 'The user was successfully updated.',
        'deleted' => 'The user was successfully deleted.',
        'licenceuploaded' => 'Licence was successfully Uploaded.',
        'deleted_permanently' => 'The user was deleted permanently.',
        'restored' => 'The user was successfully restored.',
        'updated_password' => "The user's password was successfully updated.",
        'confirmation_email' => 'A new confirmation e-mail has been sent to the address on file.'

    ],

    'pages' => [
        'created' => 'The page was successfully created.',
        'updated' => 'The page was successfully updated.',
        'deleted' => 'The page was successfully deleted.'
    ],

    "delete" => [
        "fail"                      => "Delete operation on resource has failed.",
        "self"                      => "You can't always get what you want.",
        "success"                   => "Resource has been deleted succesfully.",
        "confirmation"              => "Are you sure want to delete?"
    ],
    "update" => [
        "fail"                      => "Update operation on resource has failed.",
        "success"                   => "Resource has been updated succesfully."
    ],

    'settings' => [
        'success' => 'Settings has been updated succesfully.',
        "fail"    => "Update operation on settings has failed.",
    ],
    'charges' => [
        'success' => 'Service charge has been updated succesfully.',
        "fail"    => "Update operation on service charge has failed.",
    ],
    'booking' => [
        'created' => 'Your booking succesfully created.',
        'deleted' => 'The booking was succesfully deleted.',
        'status_updated' => 'The booking status was succesfully updated.'
    ]

];