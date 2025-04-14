
<?php

use app\models\Libro;
use yii\console\Application;

// Cargar el entorno de Yii2
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// Cargar configuración de consola
$config = require(__DIR__ . '/../config/console.php');

// Crear la aplicación de consola (para poder usar los modelos)
new Application($config);

// Datos reales a insertar
$libros = [
    ['titulo' => 'PHP', 'imagen' => 'imagen.png'],
    ['titulo' => 'Iniciando a Programar con Python', 'imagen' => 'uploads/1744556018_python.jpg'],
    ['titulo' => 'Eloquent Javascript', 'imagen' => 'uploads/1744612373_js.jpg'],
];

// Insertar los registros
foreach ($libros as $i => $data) {
    $libro = new Libro();
    $libro->titulo = $data['titulo'];
    $libro->imagen = $data['imagen'];

    if ($libro->save(false)) {
        echo "✅ Libro '{$libro->titulo}' insertado correctamente.\n";
    } else {
        echo "❌ Error al insertar '{$libro->titulo}'.\n";
    }
}
