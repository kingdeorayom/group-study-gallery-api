<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $filesOnly = $request->query('filesOnly');

        $query = $request->query('gallery');

        $directories = [];
        $files = [];

        if ($query) {

            try {

                $currentDirectory = scandir('./gallery/' . $query);

                foreach ($currentDirectory as $directory) {
                    if ($directory == '.' || $directory == "..") continue;
                    $directories[] = [
                        'folderName' => basename($directory),
                    ];
                }

                if ($filesOnly == true) {

                    $currentFilesInDir = File::allFiles('./gallery/' . $query);

                    $page = $request->query('page', 1);
                    $perPage = 9;

                    $paginator = new LengthAwarePaginator(
                        array_slice($currentFilesInDir, ($page - 1) * $perPage, $perPage),
                        count($currentFilesInDir),
                        $perPage,
                        $page,
                        ['path' => $request->url()]
                    );

                    foreach ($paginator->items() as $file) {
                        $files[] = [
                            'fileName' => basename($file),
                            'relativePathName' => asset('gallery/' . $query . '/' .  $file->getRelativePathname()),
                        ];
                    }

                    return response()->json([
                        // 'directories' => $directories,
                        'files' => $files,
                        'pagination' => [
                            'total' => $paginator->total(),
                            'current_page' => $paginator->currentPage(),
                            'per_page' => $paginator->perPage(),
                        ],
                    ]);
                }

                return response()->json([
                    'directories' => $directories,
                ]);
            } catch (Exception $e) {
                return response('Directory not found. For a more specific error: ' . $e->getMessage(), 404)->header('Content-Type', 'text/plain');
            }
        } else {

            $currentDirectory = scandir('./gallery/' . $query);

            foreach ($currentDirectory as $directory) {
                if ($directory == '.' || $directory == "..") continue;
                $directories[] = [
                    'folderName' => basename($directory),
                ];
            }

            return response()->json([
                'directories' => $directories,
            ]);
        }
    }
}
