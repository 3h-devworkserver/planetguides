<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Table specific configuration options.
    |--------------------------------------------------------------------------
    |
    */

    'table' => array(

        /*
        |--------------------------------------------------------------------------
        | Table class
        |--------------------------------------------------------------------------
        |
        | Class(es) added to the table
        | Supported: string
        |
        */

        'class' => 'table table-bordered',

        /*
        |--------------------------------------------------------------------------
        | Table ID
        |--------------------------------------------------------------------------
        |
        | ID given to the table. Used for connecting the table and the Datatables
        | jQuery plugin. If left empty a random ID will be generated.
        | Supported: string
        |
        */

        'id' => '',

        /*
        |--------------------------------------------------------------------------
        | DataTable options
        |--------------------------------------------------------------------------
        |
        | jQuery dataTable plugin options. The array will be json_encoded and
        | passed through to the plugin. See https://datatables.net/usage/options
        | for more information.
        | Supported: array
        |
        */

        'options' => array(
            
            //"Draw"=>"full-hold",
            //"bResetDisplay" => false ,
            "bStateSave"=> true,
            
            "sPaginationType" => "full_numbers",
            "lengthMenu" =>  [[100, 200, 500], [100, 200, 500]],
            // "bCaseInsensitive" => true,
            // "sort" => {
            //             "caseInsensitive": true
            //           },
            //"astateSave"=> true,
  // "fnDrawCallback"=> "function () {
  //    SetHiddenPageValuesFromState( this.fnPagingInfo().iStart, this.fnPagingInfo().iLength, this.fnSettings().aaSorting[0][0], this.fnSettings().aaSorting[0][1]);
  //    ;}",
            "dom"=>'lfr<"table-responsive"t>ip',
            "bProcessing" => false


        ),

        /*
        |--------------------------------------------------------------------------
        | DataTable callbacks
        |--------------------------------------------------------------------------
        |
        | jQuery dataTable plugin callbacks. The array will be json_encoded and
        | passed through to the plugin. See https://datatables.net/usage/callbacks
        | for more information.
        | Supported: array
        |
        */

        'callbacks' => array(),

        /*
        |--------------------------------------------------------------------------
        | Skip javascript in table template
        |--------------------------------------------------------------------------
        |
        | Determines if the template should echo the javascript
        | Supported: boolean
        |
        */

        'noScript' => false,


        /*
        |--------------------------------------------------------------------------
        | Table view
        |--------------------------------------------------------------------------
        |
        | Template used to render the table
        | Supported: string
        |
        */

        'table_view' => 'chumper.datatable::template',


        /*
        |--------------------------------------------------------------------------
        | Script view
        |--------------------------------------------------------------------------
        |
        | Template used to render the javascript
        | Supported: string
        |
        */

        'script_view' => 'chumper.datatable::javascript',
    ),


    /*
    |--------------------------------------------------------------------------
    | Engine specific configuration options.
    |--------------------------------------------------------------------------
    |
    */

    'engine' => array(

        /*
        |--------------------------------------------------------------------------
        | Search for exact words
        |--------------------------------------------------------------------------
        |
        | If the search should be done with exact matching
        | Supported: boolean
        |
        */

        'exactWordSearch' => false,


    ),
    /*
    |--------------------------------------------------------------------------
    | Allow overrides Datatable core classes
    |--------------------------------------------------------------------------
    |
    */
    'classmap' => array(
        'CollectionEngine' => 'Chumper\Datatable\Engines\CollectionEngine',
        'QueryEngine' => 'Chumper\Datatable\Engines\QueryEngine',
        'Table' => 'Chumper\Datatable\Table',
    )
);
