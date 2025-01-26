<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Backup;
use ZipArchive;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    // Controlador para obtener la lista de copias de seguridad (JSON)
    public function index()
{
    try {
        $backups = Storage::disk('backups')->files();
        return response()->json(['backups' => $backups]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener las copias de seguridad: ' . $e->getMessage()], 500);
    }
}


    // Controlador para crear una copia de seguridad

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            if (!$request->has('nombre') || !$request->has('fecha')) {
                return response()->json(['error' => 'Falta de información para crear el backup'], 400);
            }
            try {
                $backupFileName = $request->input('nombre') . '_' . $request->input('fecha') . '.zip';
                $backupFilePath = storage_path('app/backups/' . $backupFileName);

                // Crear el archivo ZIP
                $zip = new ZipArchive();
                if ($zip->open($backupFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                    // Agregar todos los archivos del proyecto
                    $this->addFilesToZip($zip, base_path());

                    // Agregar datos de las tablas
                    $this->addTableDataToZip($zip);

                    // Cerrar el archivo ZIP
                    if (!$zip->close()) {
                        throw new \Exception('Error al cerrar el archivo ZIP');
                    }
                } else {
                    return response()->json(['error' => 'No se pudo crear el archivo ZIP'], 500);
                }

                return response()->json(['success' => 'Backup creado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al crear el backup: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Método de solicitud no admitido'], 405);
        }
    }

    private function addFilesToZip(ZipArchive $zip, $path)
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {
            if (!$file->isDir() && $file->getFilename() != '.gitignore' && $file->getFilename() != 'node_modules') {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen(base_path()) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    private function addTableDataToZip(ZipArchive $zip)
    {
        $zip->addEmptyDir('bd');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $data = DB::table($tableName)->get();
            $sql = $this->generateSql($tableName, $data);
            $zip->addFromString('bd/' . $tableName . '.sql', $sql);
        }
    }

    private function generateSql($tableName, $data)
    {
        $sql = '';
        $sql .= '-- ' . $tableName . "\n";
        $sql .= 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' (' . "\n";
        $columns = DB::select('SHOW COLUMNS FROM ' . $tableName);
        foreach ($columns as $column) {
            $sql .= $column->Field . ' ' . $column->Type . ', ' . "\n";
        }
        $sql = substr($sql, 0, -3) . ');' . "\n\n";
        foreach ($data as $row) {
            $sql .= 'INSERT INTO ' . $tableName . ' (' . implode(', ', array_keys((array)$row)) . ') VALUES (' . implode(', ', array_map(function($value) {
                return "'" . $value . "'";
            }, (array)$row)) . ');' . "\n";
        }
        return $sql;
    }

    // Controlador para descargar una copia de seguridad
    public function download($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'El archivo de backup no existe'], 404);
        }

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/zip', // Cambia según el tipo de archivo
        ]);
    }

    public function delete($file)
    {
        $ruta = storage_path('app/backups/' . $file);
        if (file_exists($ruta)) {
            unlink($ruta);
            return response()->json(['success' => 'Copia de seguridad eliminada con éxito']);
        } else {
            return response()->json(['error' => 'No se encontró la copia de seguridad']);
        }
    }

}
