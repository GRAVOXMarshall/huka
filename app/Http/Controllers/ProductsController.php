<?php

namespace App\Http\Controllers;

use Auth;
use Crypt;
use Validator;
use ZipArchive;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\Http\Classes\Web;
use App\Http\Classes\Module;
use App\Http\Classes\Template;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
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

    	if (request()->is('admin/dashboard/products/modules')) {
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
				$softwareFunctionality = Module::all();
				//dd($data);
				//$dataTransaction = $response['transactionFun'];

			}else{
				$data = "N";
			}
    		return view('back/products', compact('data', 'dataWeb', 'web','softwareFunctionality'));
    		 
    	}

    	if (request()->is('admin/dashboard/products/templates')) {
    		$templates =  unserialize($this->decodificar($response['template']));
			$templateWeb =  unserialize($this->decodificar($response['templateWeb']));
			if (isset($response['template']) && $response['template']) {
				$data = $templates;
				$web = Web::find(1);
				foreach ($templateWeb as $key => $value) { 
					if ($value->domain != $web->domain) { 
						unset($templateWeb[$key]); 
					} 
				}
				$dataWeb = $templateWeb;
				$softwareTemplate = Template::all();
			}else{
				$data = "N";
			}
    		return view('back/products', compact('data', 'dataWeb', 'web', 'softwareTemplate'));
    		 
    	}
    }

    public function installProduct(Request $request){

    	$validator = Validator::make($request->all(), [
            'product_id' => 'required|string',
            'type' => 'required|string|in:functionality,template',
        ]);

        if (!$validator->fails()) {
        	$web = Web::all()->first();
	    	$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);
	    	$type = $request->type;
	    	$data = ['id'=> Crypt::decrypt($request->product_id), 'type' => $type, 'web' => $web->domain, 'email' => Auth::guard('admins')->user()->email ];
	    	// Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/
	    	$response = $client->post('store', [ 'json' => $data]);
	    	
	    	// $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
	    	$contents = json_decode($response->getBody()->getContents(), true);
	    	if ($contents['txt'] == 0) {
	    		switch ($type) {
		    		case 'functionality':
		    			$result = [
		    				'error' => false,
		    				'menssage' => '',
		    			];
		    			$name = str_replace(' ', '', ucwords(strtolower($contents['functionality']['name'])));
		    			if (!file_exists('../modules/'.$name.'/')) {
		    				$data = $this->extractZipFile($name, '../modules');
		    				if ($data['error']) {
		    					$result['error'] = true;
		    					$result['menssage'] = $data['menssage'];
		    				}
		    			}
		    			$className = 'Modules\\'.$name.'\\'.$name;
		                $module = new $className;
		                if (!$module->install()) {
		                	$result['error'] = true;
		    				$result['menssage'] = $module->error;
		                }else{
		                	$result['menssage'] = 'Instalado con exito';
		                	$result['configuration'] = route(strtolower($name).'.configuration');
		                }
	                    return json_encode($result);
		    		break;
		    		
		    		case 'template':

		    			$result = $this->extractZipFile($contents['template']['file_route'], 'css/template/');
	    				if ($result['error']) {
	    					return back()->with('error', $result['menssage']);
	    				}
		    			$template = new Template;
						$template->web_id = Web::find(1)->id;
						$template->name = $contents['template']['name'];
						$template->route = $contents['template']['file_route'];

		    		break;
		    	}
	    	}else{
				return back()->with('txt', 'Descargada con exito');
			}
        }

        /*
    	if (request()->is('admin/dashboard/module/install')) {

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
	                $module = new Module;
	                $module->parent_id = 0;
	                $module->name = $response['functionality']['name'];
	                $module->description = $response['functionality']['description'];
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
	                    $module->icon = $response['functionality']['icon'];
	                    $module->active = 0;
	                    //$zip->extractTo('css/template/');
	                    $module->save();
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

    	}
    	if (request()->is('admin/dashboard/template/install')) {
    		$web = Web::all()->first();
	    	$data = ['id'=> Crypt::decrypt($request->tem_id), 'type' => 'template', 'web' => $web->domain, 'email' => Auth::guard('admins')->user()->email ];
	    	 
	    	$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);

	    	$response = $client->post('store', [ 'json' => $data]);
			// Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/

					
			//$response = $client->request('POST', 'store', ["hola"=>'compa']);

			// $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
			$contents = $response->getBody()->getContents();
			$response = json_decode($contents, true);
			if ($response['txt'] === 0) {
				//dd(storage_path());
				$data = explode('/', $response['template']['file_route']);
				if (isset($data) && isset($data[1])) {
					$template = new Template;
					$template->web_id = Web::find(1)->id;
					$template->name = $response['template']['name'];
					$template->route = $response['template']['file_route'];
					$tempImage = tempnam(sys_get_temp_dir(), $data[1]);
					copy('http://localhost/webx/storage/app/'.$response['template']['file_route'], $tempImage);
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

					   	$template->route_css = $nombresFichZIP['name'][0];
						$template->active = 1;
						$res = Template::where('active', 1)->first();
						if (Template::where('active', 1)->exists()) {
				    		$res->active = 0;
				    		$res->save();
				    		$template->active = 1;
				    		
				    	}else{
				    		 $template->active = 1;
				    	}
						$zip->extractTo('css/template/');
						$template->save();
						$zip->close();
						return back()->with('txt', 'Instalado con exito');
					}else{
						return back()->with('error', 'mal descomprimiendo!');
						//dd('mal descomprimiendo!');
					}
				}else{
					return back()->with('error', 'Ruta invalida');
					//dd("Ruta invalida");
				}
			}else{
				return back()->with('txt', 'Descargada con exito');
			}

    	}
    	*/
    }

    public function updateProduct(Request $request){
    	if (request()->is('admin/dashboard/module/update')) {
    		
    		$module = Module::find(Crypt::decrypt($request->func_id));
	    	if ($module->active === 0) {
	    		$module->active = 1;
	    	}else if ($module->active === 1){
	    		$module->active = 0;	
	    	}
	    	$module->save();
	    	return back()->with('txt','Cambio de estado exitoso!');

    	}
    	if (request()->is('admin/dashboard/template/update')) {
    		
    		$template = Template::find(Crypt::decrypt($request->tem_id));
	    	$res = Template::where('active', 1)->first();
	    	if (Template::where('active', 1)->exists()) {
	    		$res->active = 0;
	    		$res->save();
	    		$template->active = 1;
	    		
	    	}else{
	    		 $template->active = 1;
	    	}
	    	$template->save();
	    	return back();

    	}
    }

    public function deleteProduct(Request $request){
    	if (request()->is('admin/dashboard/module/delete')) {
    		$module = Module::find(Crypt::decrypt($request->delete_func_id));
    		if ($module->uninstall()) {
    			return back()->with('txt','Desintalado con exito!');
    		}
    		return back()->with('error','Error al desinalar el modulo.');
	    	
    	}
    	if (request()->is('admin/dashboard/template/delete')) {
    		$template = Template::find(Crypt::decrypt($request->delete_tem_id));
	    	if(file_exists(public_path('css/template/'.$template->route_css))){
			  unlink(public_path('css/template/'.$template->route_css));
			 
			}
			$template->delete();
			return back()->with('txt', 'Eliminado con exito!');
    	}
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

	/**
     * Extract zip file
     * @param string
     * @return array
     */
	public function extractZipFile($routeFile, $destination)
	{
		$error = false;
		$menssage = '';
		if (!empty($routeFile) && !empty($destination)) {
			$data = explode('/', $routeFile);
			if (isset($data) && isset($data[1])) {
				$tempImage = tempnam(sys_get_temp_dir(), $data[1]);
				copy('http://localhost/webx/storage/app/'.$routeFile, $tempImage);
				$zip = new ZipArchive;
				if($zip->open($tempImage)) {
					for($i = 0; $i < $zip->numFiles; $i++){
						//we get the route that the documents will have when we unzip them
						$nameFichZip['tmp_name'][$i] =$zip->getNameIndex($i);
						//we get name of the file
						$nameFichZip['name'][$i] = $zip->getNameIndex($i);
					}
					$zip->extractTo($destination);
					$zip->close();
				}else{
					$error = true;
					$menssage = 'The file could not be decompressed correctly.';
				}
			}else{
				$error = true;
				$menssage = 'Route invalid.';
			}
		}else{
			$error = true;
			$menssage = 'Route o destination empty.';
		}

		return ['error' => $error, 'menssage' => $menssage];
	}

}
