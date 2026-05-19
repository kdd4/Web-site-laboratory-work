<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        return response()->json(
            Blog::all()
                ->toArray()
            );
    }

    public function image(string $id) {
        $blog = Blog::find($id);

        if ($blog === null) {
            abort(404, 'Blog not found');
        }

        if ($blog->image === null) {
            abort(404, 'Image not found');
        }

        $image = $blog->image;

        return response($image)
                ->header('Content-Type', $blog->imgtype)
                ->header('Content-Length', \strlen($image));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fio'    => ['required', 'string', 'regex:/^[\p{L}-]+([\s][\p{L}-]+){1,2}$/u'],
            'theme'  => ['required', 'string', 'min:1'],
            'text'   => ['required', 'string', 'min:1'],
            'image'  => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false, 'error' => implode(', ', $validator->errors()->all()), 
                ], 400);
        }

        $blog = new Blog;

        $blog->fio = $request->input('fio');
        $blog->theme = $request->input('theme');
        $blog->text = $request->input('text');
        $blog->time = date('Y-m-d H:i:s');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            $binaryData = file_get_contents($file->getRealPath());
            $hexData = '\\x' . bin2hex($binaryData);

            $blog->image = $hexData;
            $blog->imgtype = $file->getMimeType() || $file->getClientMimeType();
        }
        
        $blog->save();

        return response()->json(['result' => true]);
    }
    
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'     => ['required', 'integer'],
            'text'   => ['required', 'string', 'min:1'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false, 'error' => implode(', ', $validator->errors()->all()), 
                ], 400);
        }

        $id = $request->input('id');
        $text = $request->input('text');

        $blog = Blog::find($id);

        if ($blog === null) {
            response()->json(['result' => false, 'error' => 'Blog not found']);
        }

        $blog->text = $text;

        $blog->save();

        return response()->json(['result' => true]);
    }

    public function loadFromFile(Request $request) {
        $file = $request->file('posts');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');

        if ($handle === false) {
            return response()->json(['result' => false, 'error' => 'Error while opening file'], 400);
        }

        $fields = fgetcsv($handle, separator:";", escape:"\\");

        // For files starts with BOM
        if ($fields !== false) {
            $fields[0] = ltrim($fields[0], "\xEF\xBB\xBF");
        }

        while (($row = fgetcsv($handle, separator:";", escape:"\\")) !== false) {
            $model = new Blog;

            foreach ($fields as $key => $field) {
                $model->$field = $row[$key];
            }

            $model->save();
        }

        fclose($handle);

        return response()->json(['result' => true]);
    }

}
