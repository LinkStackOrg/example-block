<?php

    /*
    |---------------------------------------------------------------------------
    | Best Practices for submitting and validation
    |---------------------------------------------------------------------------
    |
    | This file validates and stores the block form input in the database.
    |
    */
    
    /*
    |--------------------------------------------------------------------------|
    | NOTE:                                                                    |
    | Everything should be handled within the function handleLinkType().       |
    | It replaces the backend controller and ensures data is processed and     |
    | stored correctly.                                                        |
    |--------------------------------------------------------------------------|
    */
    
    /**
     * Function Structure:
     * 
     * function handleLinkType($request, $linkType) {
     *     $rules = [];
     *     $linkData = [];
     * 
     *     return ['rules' => $rules, 'linkData' => $linkData];
     * }
     * 
     * 1. Accessing Submitted Data
     *    - You can access any submitted value via the $request variable.
     *    - Example: If the form field has name="my_value", you can access it with:
     *      $request->my_value
     *    - The same name should be used when validating or storing the input.
     *
     * 2. Validating User Input
     *    - Always validate user input to ensure it's in the expected format.
     *    - It is recommended to set maximum input lengths.
     *    - It is not recommended storing large values or files this way.
     *
     * 3. Storing Values
     *    - After validation succeeds, values can be stored in the database.
     *    - Add any value you want to save to the $linkData array.
     *    - Predefined values include 'title' and 'link' (can be left empty).
     *
     *    Example:
     *    $linkData = [
     *        'title' => $request->title,
     *        'link'  => $request->link
     *    ];
     *
     * 4. Storing Custom Values
     *    - You can store any amount of custom values in $linkData. These values 
     *      can be named however you like.
     *    
     *    Example:
     *    $linkData = [
     *        'title'           => $request->title,
     *        'custom_value_1'  => $request->something,
     *        'custom_value_2'  => 'Some Text',
     *        'custom_value_3'  => $some_var,
     *        // Add more as needed
     *        ...
     *    ];
     *
     * 5. Reusing Variables
     *    - All stored variables can be later accessed on the edit and display pages.
     */

function handleLinkType($request, $linkType) {
    // Define validation rules
    // See: https://laravel.com/docs/11.x/validation#available-validation-rules
    $rules = [
        'title' => [
            'required',
            'string',
            'max:255',
            'regex:/^[a-zA-Z0-9._-]+$/',
        ],
        'snipped' => [
            'required',
            'string',
            'max:50000',
        ],
    ];

    // Prepare the link data
    $linkData = [
        'title' => $request->title,
        'snipped' => $request->snipped,
        'custom_icon' => 'fa-solid fa-code',
    ];

    return ['rules' => $rules, 'linkData' => $linkData];
}