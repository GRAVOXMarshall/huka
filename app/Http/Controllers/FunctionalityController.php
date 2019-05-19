<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\Http\Classes\Web;
use App\Http\Classes\Functionality;
use Illuminate\Support\Facades\Storage;
use Crypt;
use Auth;
use ZipArchive;

class FunctionalityController extends Controller
{
    //

    public function __invoke(){
    	// Create a client with a base URI
		$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);

		// Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/
		$response = $client->get('list-api');

		// $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
		$contents = $response->getBody()->getContents();
		$response = json_decode($contents, true);
		$functionalities =  unserialize($this->decodificar($response['functionalities']));
		$functionalityWeb =  unserialize($this->decodificar($response['functionalityWeb']));
		if (isset($response['functionalities']) && $response['functionalities']) {
			$data = $functionalities;
			$web = Web::find(1);
			foreach ($functionalityWeb as $key => $value) { 
				if ($value->domain != $web->domain) { 
					unset($functionalityWeb[$key]); 
				} 
			}
			$dataWeb = $functionalityWeb;
			$softwareFunctionality = Functionality::all();
			//dd($data);
			//$dataTransaction = $response['transactionFun'];

		}else{
			$data = "N";
		}
    	return view('back/dashFunctionalities', compact('data', 'dataWeb', 'web','softwareFunctionality'));
    }

    function decodificar($dato) {
            $resultado = base64_decode($dato);
            list($resultado, $letra) = explode('+', $resultado);
            $arrayLetras = array('M', 'A', 'R', 'C', 'O', 'S');
            for ($i = 0; $i < count($arrayLetras); $i++) {
                if ($arrayLetras[$i] == $letra) {
                    for ($j = 1; $j <= $i; $j++) {
                        $resultado = base64_decode($resultado);
                    }
                    break;
                }
            }
            return $resultado;
        }

    public function installFunctionality(Request $request){
    	$web = Web::all()->first();
    	$data = ['id'=> Crypt::decrypt($request->func_id), 'type' => 'functionality', 'web' => $web->domain, 'email' => Auth::guard('admins')->user()->email ];
    	 
    	$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);

    	$response = $client->post('store', [ 'json' => $data]);
		// Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/

				
		//$response = $client->request('POST', 'store', ["hola"=>'compa']);

		// $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
		$contents = $response->getBody()->getContents();
		$response = json_decode($contents, true);
		//dd($response );
        if($response['txt'] === 0){
            $data = explode('/', $response['functionality']['file_route']);
            if (isset($data) && isset($data[1])) {
                //dd($data[1]);
                $functionality = new Functionality;
                $functionality->parent_id = 0;
                $functionality->web_id = Web::find(1)->id;
                $functionality->name = $response['functionality']['name'];
                $functionality->description = $response['functionality']['description'];
                $functionality->route = $response['functionality']['file_route'];
                $tempImage = tempnam(sys_get_temp_dir(), $data[1]);
                copy('http://localhost/webx/storage/app/'.$response['functionality']['file_route'], $tempImage);
                $zip = new ZipArchive;
                //$name = explode(" ",$template->name);
                if($zip->open($tempImage)) {
                    for($i = 0; $i < $zip->numFiles; $i++)
                   {
                    //obtenemos ruta que tendrán los documentos cuando los descomprimamos
                    $nombresFichZIP['tmp_name'][$i] =$zip->getNameIndex($i);
                    //obtenemos nombre del fichero
                    $nombresFichZIP['name'][$i] = $zip->getNameIndex($i);
                   }
                    $functionality->route_module = "Aqui ira la ruta del modulo";
                    $functionality->icon = $response['functionality']['icon'];
                    $functionality->active = 0;
                    //$zip->extractTo('css/template/');
                    $functionality->save();
                    //$zip->close();
                    return back()->with('txt', 'Instalado con exito');
                    //return response()->download($tempImage, 'archivo.rar');
                }else{
                    return back()->with('error', 'mal descomprimiendo!');
                    //dd('mal descomprimiendo!');
                }
            }else{
                return back()->with('error', 'Ruta invalida');
            }

        }else{
            return back()->with('txt','Descargada con exito!');
        }
		/**/
		//Storage::putFile('functionalities', $functionality->route);
		//return back()->with('message','instalado correctamente!');
    }

    public function updateFunctionality(Request $request){
    	$functionality = Functionality::find(Crypt::decrypt($request->func_id));
    	if ($functionality->active === 0) {
    		$functionality->active = 1;
    	}else if ($functionality->active === 1){
    		$functionality->active = 0;	
    	}
    	$functionality->save();
    	return back()->with('txt','Cambio de estado exitoso!');
    }

    public function deleteFunctionality(Request $request )
    {
    	

    	$functionality = Functionality::find(Crypt::decrypt($request->delete_func_id));

    	$functionality->delete();

    	return back()->with('txt','Desintalado con exito!');
    }

    public function test(Request $request){
		
    	$data = ['user'=>$request->email, 'fun'=>$request->fun, 'type' => 'functionality', 'status' => $request->status];
    	 
    	$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);

    	$response = $client->post('store', [ 'json' => $data]);
		// Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/

				
		//$response = $client->request('POST', 'store', ["hola"=>'compa']);

		// $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
		$contents = $response->getBody()->getContents();
		$response = json_decode($contents, true);
		return back();
    	//dd($response);
    }

}
