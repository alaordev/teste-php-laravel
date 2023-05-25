<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class DocumentController extends Controller
{
    /**
     * Handle the import process
     */
    public function __invoke()
    {
        $fileName = '2023-03-28.json';

        $disk = Storage::build([
            'driver' => 'local',
            'root' => storage_path('data'),
        ]);

        $contents = $disk->get($fileName);

        $data = json_decode($contents);

        foreach ($data->documentos as $document) {
            $category = Category::firstOrCreate([
                'name' => $document->categoria
            ]);

            $contentKey = 'conteúdo';

            $category->documents()->create([
                'title' => $document->titulo,
                'contents' => $document->$contentKey
            ]);
        }

        return $data;
    }
}
