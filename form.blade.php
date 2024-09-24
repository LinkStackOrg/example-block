<?php

    /*
    |---------------------------------------------------------------------------
    | Best Practices for the block form
    |---------------------------------------------------------------------------
    |
    | This file is used to create AND edit the block on the add/edit link page.
    |
    */

    /**
     * 1. Loading Assets from Block Directory
     *    - Use block_asset($file_path) to generate a dynamic URL for loading 
     *      assets from the block directory.
     * 
     *    Example:
     *    <link rel="stylesheet" href="{{ block_asset('assets/style.css') }}">
     *
     * 2. Fetching File Contents from Block Directory
     *    - Use get_block_file_contents($file_path) to load the contents of a 
     *      file from the block directory.
     * 
     *    Example:
     *    @php
     *        $json_data = get_block_file_contents('values.json');
     *    @endphp
     *
     * 3. Handling Translated Text
     *    - Always use block_text($text) or the shorthand bt($text) for text.
     *      It uses the translated value if available, otherwise defaults to 
     *      the input string.
     * 
     *    Example:
     *    <h1>{{ block_text('Text to translate.') }}</h1>
     *
     * 4. Accessing Stored Variables
     *    - Use $some_value to access stored variables. Common values include:
     *        - $link
     *        - $title
     * 
     *    Example:
     *    <div class="form-group">
     *        <input type="text" name="title" value="{{ $title }}">
     *        <input type="url" name="link" value="{{ $link }}">
     *        <input type="email" name="custom_value" value="{{ $custom_value ?? null }}">
     *    </div>
     *
     * 5. Setting Default Values
     *    - To allow an input field to be filled when editing a saved block, 
     *      use the ?? operator to set default values and avoid errors.
     *      Set `null` if no value is required.
     *
     * 6. Styling
     *    - This page is styled using Bootstrap 5.
     */

?>

<script src="{{block_asset('assets/highlight.min.js')}}"></script>
<link rel="stylesheet" href="{{block_asset('assets/style.css')}}">

<label for='title' class='form-label'>{{block_text('File name')}}</label>
<input type='text' name='title' placeholder="example.html" pattern="[a-zA-Z0-9._\-]+" value='{{ $title }}' class='form-control' required />

<br>

<label class='form-label'>{{block_text('Snipped')}}</label>
<span class='small text-muted'>{{block_text('Enter code in any language')}}</span>

<figure style="margin:0!important;">
    <figcaption>
        {{block_text('Snipped')}}
        <div class="cs-button-container">
            <div onclick="csHighlight()" class="cs-download"><i class="fa-solid fa-magnifying-glass"></i> {{block_text('Detect language')}}</div>
        </div>
    </figcaption>
    <?php
    // Use "??" operator to avoid variable not defined errors for custom variables
    // Example:
    // {{ $custom_variable ?? null }}
    ?>
    <pre><code id="cshljs" contenteditable="true" tabindex="0" spellcheck="false">{{ $snipped ?? null }}</code></pre>
</figure>

<script>
function csHighlight() {
    hljs.initHighlighting.called = false;
    hljs.initHighlighting();
}

// Custom event
document.addEventListener('contentLoaded', (event) => {
    csHighlight();
});

$(document).ready(function() {
    $('form').on('submit', function(e) {
        var codeElement = $('#cshljs');
        var plainText = codeElement.text();
        
        // Create a new input element
        var snippedInput = $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'snipped')
            .val(plainText);
        
        // Append the input element to the form
        $(this).append(snippedInput);
    });
});
</script>