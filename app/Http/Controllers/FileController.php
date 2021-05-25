<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\EncryptFile;
use App\Jobs\MoveFileToS3;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Files;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request);
        $request->validate([
            'userFile' => 'required|mimes:doc,pdf,docx|max:2048'
        ]);

        if ($request->hasFile('userFile')) {
            $filename = Storage::putFile('files/' . $request->sis_id, $request->file('userFile'));
            $filling = new Files;
            $filling->name = $request->name;
            $filling->path = $filename ;
            $filling->sis_id = $request->sis_id;
            $filling->header_id = $request->header_id;
            $filling->panel_update = $request->panel_update;
            $filling->pic = $request->pic;
            $filling->description = $request->description;
            $filling->user_created = $request->user_created;
            $filling->user_lastmaintain = $request->user_lastmaintain;
            $filling->save();
        }
       

        return back()->with('success', 'Data Your files has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
