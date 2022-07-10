<?php

namespace App\Http\Controllers\Admin;

use App\ClientImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientImagesRequest;
use Illuminate\Support\Str;

class ClientsController extends Controller
{
    /**
     * @var ClientImage
     */
    protected $model;

    public function __construct(ClientImage $model)
    {
        $this->model = $model;
    }

    public function logos()
    {
        $images = $this->model->orderBy('sort', 'asc')->get();

        $model = $this->model;

        return view('admin.clients.logos', compact('images', 'model'));
    }

    public function store(ClientImagesRequest $request)
    {
        $model = $this->model;

        $model->extra = 'show';

        if ( $save = $model->fill($request->all())->save() ) {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(20) . '.' . $extension;
                $file_path = 'assets/site/client-images/'  . $fileName;
                $destinationPath = 'assets/site/client-images/';
                $file->move($destinationPath, $fileName);
                $model->image = $file_path;
                $model->save();
            }
        }

        return redirect()->back()->with('success', 'Form Data Successfully Saved!');
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
        return redirect()->back();
    }

    public function additional()
    {
        return view('admin.clients.additional');
    }
}
