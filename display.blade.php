<?php
    
    /*
    |---------------------------------------------------------------------------
    | Best Practices for the links page
    |---------------------------------------------------------------------------
    |
    | This file is used to display the block on the user's links page.
    |
    */

    /**
     * 1. Loading Assets Once with @once
     *    - Use the @once directive to load assets only once, even if the block
     *      appears multiple times on the page.
     * 
     *    Example:
     *    @once
     *        <script>
     *            var foo = 'bar';
     *        </script>
     *    @endonce
     *
     * 2. Ensuring Correct Asset Order with @push
     *    - Use the @push directive to ensure assets are loaded in the correct order.
     *      Combine it with @once for better control. Available positions include:
     *        - linkstack-head
     *        - linkstack-head-end
     *        - linkstack-body-start
     *        - linkstack-body-end
     *
     *    Example:
     *    @push('linkstack-head-end')
     *        <style> body { background: green; } </style>
     *    @endpush
     *
     * 3. Loading Assets from Block Directory
     *    - Use block_asset($file_path) to generate a dynamic URL for loading assets 
     *      from the block directory.
     * 
     *    Example:
     *    <link rel="stylesheet" href="{{ block_asset('assets/style.css') }}">
     *
     * 4. Fetching File Contents from Block Directory
     *    - Use get_block_file_contents($file_path) to load contents of a file from the 
     *      block directory.
     * 
     *    Example:
     *    @php
     *        $json_data = get_block_file_contents('values.json');
     *    @endphp
     *
     * 5. Handling Translated Text
     *    - Always use block_text($text) or the shorthand bt($text) function for text.
     *      It uses the translated value if available, otherwise defaults to the input string.
     * 
     *    Example:
     *    <h1>{{ block_text('Text to translate.') }}</h1>
     *
     * 6. Accessing Stored Variables
     *    - Use $link->some_value to access stored variables. Common values include:
     *        - $link->id
     *        - $link->user_id
     *        - $link->button_id
     *        - $link->link
     *        - $link->title
     *        - $link->click_number
     *        - $link->created_at
     *
     *    Example:
     *    <div class="button">
     *        <a id="{{ $link->id }}" href="{{ $link->link }}">{{ $link->title }}</a>
     *        <span>This link has been clicked {{ $link->click_number ?? 0 }} times!</span>
     *    </div>
     */

?>


{{-- Load assets only once and in the correct order using @once and @push directives. --}}
@once
    @push('linkstack-head')
        <script  src="{{block_asset('assets/highlight.min.js')}}"></script>
        <script>hljs.initHighlightingOnLoad();</script>
        <link rel="stylesheet" href="{{block_asset('assets/style.css')}}">
    @endpush
@endonce

<figure>
    <figcaption>
        {{ $link->title }}
        <div class="cs-button-container">
            <div onclick="csDownloadButton('{{ $link->id }}', '{{ $link->title }}')" class="cs-download"><i class="fa-solid fa-file-arrow-down"></i> {{block_text('Download')}}</div>
            <div onclick="csCopyButton('{{ $link->id }}')" class="cs-copy"><i class="fa-solid fa-copy"></i> {{block_text('Copy')}}</div>
        </div>
    </figcaption>
    <pre><code id="{{ $link->id }}" contenteditable="false" tabindex="0" spellcheck="false">{{ $link->snipped }}</code></pre>
</figure>

@once
    @push('linkstack-body-end')
        <script>
            // In order to use translations in JavaScript, the JS either has to be added directly inline or stored as variables.
            // Here as an example, variables that are called in script.js are used:
            const csCopyTitle = '{{block_text('Copied!')}}';
            const csCopyMessage = '{{block_text('The text has been copied to your clipboard.')}}';
        </script>
        <script  src="{{block_asset('assets/script.js')}}"></script>
    @endpush
@endonce
