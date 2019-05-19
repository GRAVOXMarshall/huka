<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Template;
use App\Http\Classes\Web;
use GuzzleHttp\Client;
use Crypt;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Auth;


class TemplateController extends Controller
{
    //

    public function __invoke(){
    	// Create a client with a base URI
		$client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);

		// Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/
		//$response = $client->request('GET', 'list-api');
		$response = $client->get('list-api');

		// $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
		$contents = $response->getBody()->getContents();
		$response = json_decode($contents, true);
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
    	return view('back/dashTemplates', compact('data', 'dataWeb', 'web', 'softwareTemplate'));
    }


    public function installTemplate(Request $request){
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

    public function updateTemplate(Request $request){
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

    public function deleteTemplate(Request $request )
    {
    	

    	$template = Template::find(Crypt::decrypt($request->delete_tem_id));
    	 if(file_exists(public_path('css/template/'.$template->route_css))){
		  unlink(public_path('css/template/'.$template->route_css));
		 
		}
		 $template->delete();
		 return back()->with('txt', 'Eliminado con exito!');

    	
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

}
