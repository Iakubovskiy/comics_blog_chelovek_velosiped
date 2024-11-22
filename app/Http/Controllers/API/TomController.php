<?php
namespace App\Http\Controllers\API;

use App\Models\Tom;
use App\Services\TomService;
use Illuminate\Http\Request;

class TomController extends BaseController
{
    public function __construct(protected TomService $tomService){}

    public function getAllToms()
    {
        try {
            $toms = $this->tomService->getAllToms();
            return $this->sendResponse($toms, 'Toms retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve Toms', ['error' => $e->getMessage()]);
        }
    }

    public function getTomById(int $id)
    {
        try {
            $tom = $this->tomService->getTomById($id);
            return $this->sendResponse($tom, 'Tom retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve Tom', ['error' => $e->getMessage()]);
        }
    }

    public function createTom(Request $request)
    {
        try {
            $tomData = [                
                'name' => $request->input('name'),
                'price' => $request->input('price'),
            ];

            $uploadedFiles = $request->file('images', []);

            $tom = $this->tomService->createTom($tomData, $uploadedFiles);
            return $this->sendResponse($tom, 'Tom created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create Tom', ['error' => $e->getMessage()]);
        }
    }

    public function updateTom(Request $request, int $id)
    {
        try {
            $tomData = [
                'name'=> $request->input('name'),
                'price'=> $request->input('price'),
            ];

            $uploadedFiles = $request->file('images', []);

            $Tom = $this->tomService->updateTom($id, $tomData, $uploadedFiles);
            return $this->sendResponse($Tom, 'Tom updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update Tom', ['error' => $e->getMessage()]);
        }
    }

    public function deleteTom(int $id)
    {
        try {
            $this->tomService->deleteTom($id);
            return $this->sendResponse(null, 'Tom deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete Tom', ['error' => $e->getMessage()]);
        }
    } 
}
