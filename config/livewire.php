<?php

return [
    'manifest_path' => base_path('bootstrap/cache/livewire-manifest.json'),

    'middleware_group' => 'web',

    'inject_assets' => true,

    'inject_html' => true,

    'layout' => 'components.layouts.app',

    'morphs' => [
        'message' => \App\Models\Message::class,
    ],

    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => 'file|max:12288',
        'directory' => 'livewire-tmp',
        'cleanup' => true,
    ],

    'render_on_redirect' => false,

    'redirects' => [
        //
    ],

];
