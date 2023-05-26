<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\Import\ProcessDocument;

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

        if (!$data) {
            return response()->json([
                'message' => 'Arquivo nāo reconhecido!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        foreach ($data->documentos as $document) {
            ProcessDocument::dispatch($document)->onQueue('import:documents');
        }

        return response()->json([
            'year' => $data->exercicio,
            'processed' => count($data->documentos),
        ]);
    }
}
