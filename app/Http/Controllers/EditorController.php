<?php


namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use App\Http\Classes\Element;
use App\Http\Classes\ElementTrait;
use App\Http\Classes\Page;
use App\Http\Classes\Layout;
use App\Http\Classes\Image;
use App\Http\Classes\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    /**
     * Get configurate of page
     * @param Object Page
     * @return Json
     */
    public function builderLoad($type, $id_page)
    {
        $page = ($type != 'L') ? Page::find((int)$id_page) : Layout::find((int)$id_page);
        if (!empty($page)) {
            return json_encode([
                'gjs-css' => (!is_null($page->css)) ? json_decode($page->css, true) : [],
                'gjs-style' => (!is_null($page->styles)) ? json_decode($page->styles, true) : [],
                'gjs-assets' => (!is_null($page->assets)) ? json_decode($page->assets, true) : [],
                'gjs-components' => (!is_null($page->components)) ? json_decode($page->components, true) : [],
            ]);
        }

        return 'Page not found';

        //Session::flash('flashSession', ['status' => 'danger', 'message' => 'Error, you cannot build this Page!']);
        //return redirect('/');
    }

    /**
     * Save configurate page in db
     * @param Object Page
     * @param Object Request
     * @return Json
     */
    public function builderPost($type, $id_page, Request $request)
    {
        $page = ($type != 'L') ? Page::find((int)$id_page) : Layout::find((int)$id_page);
        if (!empty($page)) {
            $page->css = json_encode($request['gjs-css']);
            $page->styles = json_encode($request['gjs-styles']);
            $page->assets = json_encode($request['gjs-assets']);
            $page->components = json_encode($request['gjs-components']);
            $page->save();

            return ['status' => 'success', 'message' => 'Your Page was successfully saved!'];
        }

        //Session::flash('flashSession', ['status' => 'danger', 'message' => 'Error, you cannot build this Page!']);
        return redirect('/');
    }

    public function loadEditor($type){
        $pages = Page::where('type', $type)->get();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();
        $images = Image::all();
        return view('editor/index', compact('pages', 'elements', 'images'));
    }


    public function loadTest(){
        $pages = Page::all();
        $layouts = Layout::all();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();
        $traits = ElementTrait::all();
        foreach ($traits as $trait) {
            $trait->values = json_decode($trait->values);
        }
        
        $images = Image::all();

        // Create a client with a base URI
        $client = new Client(['base_uri' => 'http://localhost/webx/public/api/']);

        // Send a request to http://localhost/WebServiceApp/public/api/user/tipoprojeto/
        $response = $client->get('list-api');

        // $response contains the data you are trying to get, you can do whatever u want with that data now. However to get the content add the line
        $contents = $response->getBody()->getContents();
        $response = json_decode($contents, true);

        $modules = array();

        $data =  unserialize($this->decodificar($response['functionalities']));
        if (isset($response['functionalities']) && $response['functionalities']) {
            $currently_modules = DB::table('modules')->select('id')->get();
            $ids_modules = array();
            foreach ($currently_modules as $module) {
                array_push($ids_modules, $module->id);
            }
            foreach ($data as $module) {
                $status = 0;
                if (in_array($module['id'], $ids_modules)) {
                    $status = 1;
                }

                array_push($modules, [
                    'id' => $module['id'],
                    'name' => str_replace(' ', '', ucwords(strtolower($module['name']))),
                    'price' => $module['price'],
                    'status' => $status
                ]);
            }
        }
        
        return view('editor/test', compact('pages', 'layouts', 'elements', 'traits', 'images', 'modules'));
    }


    /**
     * Save and remove image in page and storage directory
     * @param Object Request
     * @return Json
     */
    public function builderStorageImage(Request $request)
    {
        if (!empty($request)) {

            switch ($request->action) {
                case 'add':
                    /*
                        This action get and storage image in databese and server
                        return JSON object
                    */
                    if (isset($_FILES)) {
                        $images = array();
                        foreach ( $_FILES as $file){ 
                            $filError = $file['error'][0];
                            $fileName = $file['name'][0];
                            $tmpName = $file['tmp_name'][0];
                            $fileSize = $file['size'][0];
                            $fileType = $file['type'][0];

                            $allowed_image_extension = array("png", "jpg", "jpeg");
                            
                            // Get image file extension
                            $file_extension = pathinfo($fileName, PATHINFO_EXTENSION);

                            //Validate images file

                            if ($filError != UPLOAD_ERR_OK){
                                error_log($filError);
                                echo JSON_encode(null);
                            }elseif (! file_exists($tmpName)) { // Valid if exit file
                                error_log('Choose image file to upload.');
                                echo JSON_encode(null);
                            }elseif (! in_array($file_extension, $allowed_image_extension)) { // Valid that file it is a image
                                error_log('Upload valiid images. Only PNG and JPEG are allowed.');
                                echo JSON_encode(null);
                            }elseif ($fileSize > 2000000) { // Valid size of image
                                error_log('Image size exceeds 2MB');
                                echo JSON_encode(null);
                            } else {
                                // Storage image in the serve 
                                $file_src = Storage::putFile('public/images', new File($tmpName));
                                $file = array(
                                    'name'=> $file['name'],
                                    'type'=>'image',
                                    'src'=> Storage::url($file_src),
                                    'height'=>350,
                                    'width'=>250
                                );
                                
                                DB::table('images')->insert([
                                    'name' => $fileName,
                                    'src' => Storage::url($file_src)
                                ]);
                            
                                // Add file to array images that we return to editor
                                array_push($images, $file);

                            }
                        }
                        $result = array(
                          'data' => $images
                        );

                        return json_encode($result);die;
                        break;
                    }
                    return '{"status":"Error to add image"}';die;
                    break;

                case 'remove':
                    /*
                        This action get and remove image in databese and server
                        return JSON object
                    */
                    $error = false;
                    $message = '';
                    try {
                        $image = Image::where('src', $request->file)->firstOrFail();
                        if ($image->delete()) {
                            Storage::delete($request->file);
                            $message = 'The image was successfully deleted.';
                        }else{
                            $error = true;
                            $message = 'The image is not deleted successfully. Try again later.';
                        }
                    } catch (Exception $e) {
                        $error = true;
                        $message = 'Invalid image.';
                    }
                    $result = array(
                      'error' => $error,
                      'message' => $message
                    );

                    return response()->json($result);
            
                    break;
            }
        }

        //Session::flash('flashSession', ['status' => 'danger', 'message' => 'Error, you cannot build this Page!']);
        return '{"status":"error"}';die;
    }

    /**
     * Get configurate of page
     * @param Object Page
     * @return Json
     */
    public function getElements(Request $request)
    {
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();

        return response()->json($elements);
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
