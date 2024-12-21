<?php
return [

    'backup' => [
        'name' => env('APP_NAME', 'default_name'),  // Utiliza el nombre de la aplicación

        // Qué base de datos respaldar
        'database' => [
            'mysql' => [
                'host' => env('DB_HOST', '127.0.0.1'),         // Obtiene la IP del host de la base de datos
                'port' => env('DB_PORT', '3306'),               // Obtiene el puerto de la base de datos
                'database' => env('DB_DATABASE'),               // Obtiene el nombre de la base de datos desde .env
                'username' => env('DB_USERNAME'),               // Obtiene el nombre de usuario desde .env
                'password' => env('DB_PASSWORD', ''),           // Obtiene la contraseña desde .env
            ],
        ],

        // Archivos que deseas respaldar
        'files' => [
            base_path(), // Raíz del proyecto (incluye todo el código fuente y assets)
            storage_path('app'), // Archivos de usuarios subidos
        ],

        // Excluir ciertas carpetas o archivos
        'exclude_files' => [
            base_path('.git'),
            base_path('node_modules'),
            base_path('vendor'),
        ],

        'exclude_database_tables' => [
            // Si quieres excluir alguna tabla específica
        ],

        // Fuente del respaldo
        'source' => [
            'database' => [
                'mysql' => [
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => env('DB_DATABASE'),
                    'username' => env('DB_USERNAME'),
                    'password' => env('DB_PASSWORD', ''),
                ],
            ],
            'files' => [
                base_path(),
                storage_path('app'),
            ],
        ],

        // Otros ajustes para el respaldo
        'disable_notifications' => false,
        'notifications' => [
            // Notificaciones que quieras agregar
        ],
    ],
];
