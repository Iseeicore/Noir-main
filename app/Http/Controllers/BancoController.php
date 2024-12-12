<?php
namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    // Mostrar lista de bancos
    public function index()
    {
        // Recupera todos los bancos
        $bancos = Banco::all();
        return response()->json($bancos); // Devuelve la lista de bancos en formato JSON
    }

    // Mostrar los detalles de un banco
    public function show($id)
    {
        // Encuentra el banco por su ID
        $banco = Banco::findOrFail($id);
        return response()->json($banco); // Devuelve los detalles del banco en formato JSON
    }

    // Crear un nuevo banco
    public function store(Request $request)
{
    // Validación de los datos
    $validated = $request->validate([
        'nombre_banco' => 'required|string|max:255',
        'tipo_moneda' => 'required|string|in:Soles,Dolares', // Se espera que solo sean Soles o Dolares
        'numero_cuenta' => 'required|string|max:50', // Validación de número de cuenta
        'estado' => 'nullable|boolean', // Estado puede ser null, pero si existe debe ser un booleano
    ]);

    // Crear el banco
    $banco = Banco::create([
        'nombre_banco' => $validated['nombre_banco'],
        'tipo_moneda' => $validated['tipo_moneda'],
        'numero_cuenta' => $validated['numero_cuenta'],
        'estado' => $validated['estado'] ?? false,
    ]);

    // Retornar la respuesta en formato JSON
    return response()->json(['message' => 'Banco creado con éxito.', 'banco' => $banco], 201);
}



    // Actualizar un banco existente
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre_banco' => 'required|string|max:255',
            'tipo_moneda' => 'required|string|in:Soles,Dolares',
            'numero_cuenta' => 'required|string|max:50',
            'estado' => 'nullable|boolean',
        ]);

        // Encuentra el banco por su ID
        $banco = Banco::findOrFail($id);

        // Actualiza los datos del banco con los nuevos datos
        $banco->update($request->all());

        // Devuelve una respuesta JSON con el mensaje de éxito
        return response()->json(['message' => 'Banco actualizado con éxito.', 'banco' => $banco]);
    }

    // Eliminar un banco
    public function destroy($id)
    {
        // Encuentra el banco por su ID
        $banco = Banco::findOrFail($id);

        // Elimina el banco
        $banco->delete();

        // Devuelve una respuesta JSON con el mensaje de éxito
        return response()->json(['message' => 'Banco eliminado con éxito.']);
    }

}
