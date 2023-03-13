<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\File;
use App\Models\Peticione;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="daw13.2022@gmail.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class PeticionesController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() //Con esta función indicamos que en el index y en el show no tenemos que autenticarnos, es decir, usar token
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * @OA\Get(
     *      path="/peticiones",
     *      operationId="getPeticiones",
     *      tags={"getPeticiones"},
     *      summary="Get list of peticiones",
     *      description="Returns list of peticiones",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function index(Request $request)
    {
        $peticiones = Peticione::all();
        return $peticiones;
    }

    /**
     * @OA\Get(
     *      path="/mispeticiones",
     *      operationId="getMispeticiones",
     *      tags={"getMispeticiones"},
     *      summary="Peticiones que ha realizado un usuario",
     *      description="Peticiones que ha realizado un usuario",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function listMine(Request $request)
    {
        // parent::index()
        //$user = Auth::user();
        $id = 1;
        $peticiones = Peticione::all()->where('user_id', $id);
        return $peticiones;
    }

    /**
     * @OA\Get(
     *      path="/peticiones/{peticiones}",
     *      operationId="getShow",
     *      tags={"getShow"},
     *      summary="Mostrar una peticione determinada",
     *      description="Mostrar una peticione determinada",
     *      @OA\Parameter(
     *          name="id",
     *          description="Peticiones id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:peticiones", "read:peticiones"}
     *         }
     *     },
     * )
     */
    public function show(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);
        return $peticion;
    }

    public function update(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
            $peticion->update($request->all());
            return response()->json(['message' => ''], 201);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

    }


    /*public function store(Request $request)
    {
        // return response()->json(["data"=>$request->peticion]);
        $data = json_decode($request->peticion, true);
        $validator = Validator::make($data, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'user_id' => 'required',
            'categoria_id' => 'required',
        ]);


        if ($validator->fails()) {

        }
        $category = Categorie::findOrFail($data['categoria_id']);
        //$user = Auth::user(); //asociarlo al usuario authenticado
        $user = User::findOrFail($data['user_id']);
        $peticion = new Peticione($data);
        $peticion->user()->associate($user);
        $peticion->categoria()->associate($category);
        $peticion->firmantes = 0;
        $peticion->estado = 'pendiente';
        $peticion->save();
        return $peticion;
    }*/

    /**
     * @OA\Post(
     *      path="/peticiones",
     *      operationId="PostaddPeticion",
     *      tags={"store2"},
     *      summary="Store new project",
     *      description="Returns project data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreProjectRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Project")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function store2(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'titulo' => 'required|max:255',
                'descripcion' => 'required',
                'destinatario' => 'required',
                'categoria_id' => 'required',

            ]);

        if ($validator->fails()) {
            return response()->json(['error1' => $validator->errors()], 401);
        }

        $validator = Validator::make($request->all(),
            [
                'file' => 'required|mimes:png,jpg,jpeg|max:4096',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()],
                401);
        }

        $input = $request->all();
        $peticion = new Peticione($input);
        $file=$request->file('file');
        $path = $file->store('public/peticiones');
        $fileName = uniqid() . $file->getClientOriginalName();
        $peticion->image = $path.$fileName;





        $category = Categorie::findOrFail($input['categoria_id']);
        $user = Auth::user(); //asociarlo al usuario authenticado
        //$user = User::findOrFail($data['user_id']);

        $peticion->user()->associate($user);
        $peticion->categoria()->associate($category);
        $peticion->firmantes = 0;
        $peticion->estado = 'pendiente';
        $peticion->save();
        return $peticion;

    }

   /* public function firmar(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);
        //$user = Auth::user();
        $user = 2;
        $user_id = [$user];
        //$user_id = [$user->id];
        $peticion->firmas()->attach($user_id);
        return $peticion;
    }*/

    public function firmar(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
            $user = Auth::user();
            $firmas = $peticion->firmas;
            foreach ($firmas as $firma) {
                if ($firma->id == $user->id) {
                    return response()->json(['message' => 'Ya has firmado esta petición'], 403);
                }
            }
            $user_id = [$user->id];
            $peticion->firmas()->attach($user_id);
            $peticion->firmantes = $peticion->firmantes + 1;
            $peticion->save();
        } catch (\Throwable$th) {
            return response()->json(['message' => 'La petición no se ha podido firmar'], 500);
        }
        return response()->json(['message' => 'Peticion firmada satisfactioriamente', 'peticion' => $peticion], 201);
    }

    public function cambiarEstado(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);

        if ($request->user()->cannot('cambiarEstado', $peticion)) {
            return response()->json(['message' => 'No estás autorizado para realizar esta acción'], 403);
        }
        $peticion->estado = 'aceptada';
        $peticion->save();
        return $peticion;
    }
    public function destroy(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);
        $peticion->delete();
        return $peticion;
    }

    function list(Request $request) {
        $peticiones = Peticione::jsonPaginate();
        return $peticiones;
    }



}
