<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Classes\Page;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('contact::index');
    }

    public function sendMails(Request $request){
        $page = Page::find(3);
        $components = json_decode(json_decode($page->components, true));
        $result = $components;
        $css = $page->css;
        $data = ['firstname' => 'Sebastian', 'page' => $page, 'components' => $result, 'css' => $css, 'template' => 'css/bootstrap-new.css'];
        
         return view('mail', ['message' => $request->Message,'page' => $page, 'components' => $result, 'css' => $css, 'template' => 'css/bootstrap-new.css']);
         
        \Mail::send('mail', $data, function ($message) {

            $message->from('email@styde.net', 'Styde.Net');

            $message->to('user@example.com')->subject('Notificación');

        });

        return "Se envío el email";
         
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('contact::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('contact::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('contact::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
