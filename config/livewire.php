<?php

return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'directory' => 'livewire-tmp',
        'rules' => 'file|max:102400', // 100MB
        'directory_visibility' => 'private',
        'delete_uploaded_base_temporary_files_after_hours' => 24,
    ],

    'render_javascript_payload' => true,

    'layout' => 'components.layouts.app',

    'legacy_model_binding' => false,

    'morphed_relationships' => true,
];
