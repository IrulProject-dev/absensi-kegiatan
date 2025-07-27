@php
    // Definisikan path SVG dalam array mapping
    // Anda bisa memindahkan ini ke file config/svg_icons.php jika ingin lebih modular
    // Contoh: 'clipboard' => '<path d="M3.5 2a.5..."/><path d="M10 .5a.5..."/>'
    $svgIcons = [
        'clipboard_initial' => '
            <path d="M3.5 2a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-12a.5.5 0 0 0-.5-.5H12a.5.5 0 0 1 0-1h.5A1.5 1.5 0 0 1 14 2.5v12a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-12A1.5 1.5 0 0 1 3.5 1H4a.5.5 0 0 1 0 1z"/>
            <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5"/>
        ',
        'clipboard_check_transformed' => '
            <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z"/>
            <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
            <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
        ',
        // Tambahkan ikon lain di sini jika diperlukan
        'another_icon_initial' => '<path d="M..."/>',
        'another_icon_transformed' => '<path d="M..."/>',
    ];

    // Atur default jika props tidak diberikan
    $initialIconKey = $initialIconKey ?? 'clipboard_initial';
    $transformedIconKey = $transformedIconKey ?? 'clipboard_check_transformed';

    // Pastikan kunci yang diminta ada di array
    $initialSvgContent = $svgIcons[$initialIconKey] ?? '';
    $transformedSvgContent = $svgIcons[$transformedIconKey] ?? '';
@endphp

<div class="icon-container" id="iconContainer">
    <svg class="icon-initial" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        {!! $initialSvgContent !!}
    </svg>

    <svg class="icon-transformed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        {!! $transformedSvgContent !!}
    </svg>
</div>
