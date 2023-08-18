<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'kelas_siswa' => [
        'name' => 'Kelas Siswa',
        'index_title' => 'Daftar Kelas Siswa',
        'new_title' => 'Kelas Siswa Baru',
        'create_title' => 'Buat Kelas Siswa',
        'edit_title' => 'Edit Kelas Siswa',
        'show_title' => 'Tampilkan Kelas Siswa',
        'inputs' => [
            'name' => 'Nama Kelas',
            'code' => 'Kode Kelas',
        ],
    ],

    'kehadiran' => [
        'name' => 'Kehadiran',
        'index_title' => 'Daftar Kehadiran',
        'new_title' => 'Kehadiran Baru',
        'create_title' => 'Buat Kehadiran',
        'edit_title' => 'Edit Kehadiran',
        'show_title' => 'Tampilkan Kehadiran',
        'inputs' => [
            'name' => 'Nama Kehadiran',
        ],
    ],

    'session_akhir' => [
        'name' => 'Session Akhir',
        'index_title' => 'Daftar Session Akhir',
        'new_title' => 'Session Akhir Baru',
        'create_title' => 'Buat Session Akhir',
        'edit_title' => 'Edit Session Akhir',
        'show_title' => 'Tampilkan Session Akhir',
        'inputs' => [
            'date' => 'Tanggal',
            'time' => 'Time',
            'teacher_id' => 'Guru',
            'class_student_id' => 'Class Student',
        ],
    ],

    'session_mulai' => [
        'name' => 'Session Mulai',
        'index_title' => 'Daftar Session Mulai',
        'new_title' => 'Session Mulai Baru',
        'create_title' => 'Buat Session Mulai',
        'edit_title' => 'Edit Session Mulai',
        'show_title' => 'Tampilkan Session Mulai',
        'inputs' => [
            'date' => 'Tanggal',
            'time' => 'Jam',
            'teacher_id' => 'Guru',
            'class_student_id' => 'Kelas Siswa',
        ],
    ],

    'siswa' => [
        'name' => 'Siswa',
        'index_title' => 'Daftar Siswa',
        'new_title' => 'Siswa Baru',
        'create_title' => 'Buat Siswa',
        'edit_title' => 'Edit Siswa',
        'show_title' => 'Tampilkan Siswa',
        'inputs' => [
            'name' => 'Nama',
            'nis' => 'Nis',
            'gender' => 'Gender',
            'password' => 'Password',
            'class_student_id' => 'Kelas Siswa',
        ],
    ],

    'kehadiran_siswa' => [
        'name' => 'Kehadiran Siswa',
        'index_title' => 'Daftar Kehadiran Siswa',
        'new_title' => 'Kehadiran Siswa Baru',
        'create_title' => 'Buat Kehadiran Siswa',
        'edit_title' => 'Edit Kehadiran Siswa',
        'show_title' => 'Tampilkan Kehadiran Siswa',
        'inputs' => [
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'presence_id' => 'Kehadiran',
            'date' => 'Tanggal',
            'time' => 'Jam',
        ],
    ],

    'guru' => [
        'name' => 'Guru',
        'index_title' => 'Daftar Guru',
        'new_title' => 'Guru Baru',
        'create_title' => 'Buat Guru',
        'edit_title' => 'Edit Guru',
        'show_title' => 'Tampilkan Guru',
        'inputs' => [
            'email' => 'Email',
            'name' => 'Nama',
            'gender' => 'Gender',
            'password' => 'Password',
        ],
    ],

    'user' => [
        'name' => 'User',
        'index_title' => 'Daftar User',
        'new_title' => 'User Baru',
        'create_title' => 'Buat User',
        'edit_title' => 'Edit User',
        'show_title' => 'TampilkanUser',
        'inputs' => [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
