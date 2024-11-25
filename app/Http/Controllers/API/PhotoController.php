<?php
namespace App\Http\Controllers\API;

use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PhotoController extends BaseController
{
    protected PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $file = $request->file('file');
            $photo = $this->photoService->createPhoto($file);

            return $this->sendResponse($photo, 'Photo uploaded successfully.');
        } catch (ValidationException $e) {
            return $this->sendError('Validation error.', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->photoService->deletePhoto($id);

            return $this->sendResponse([], 'Photo deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroyMany(Request $request)
    {
        try {
            $request->validate([
                'photo_ids' => 'required|array',
                'photo_ids.*' => 'integer',
            ]);

            $photoIds = $request->input('photo_ids');
            $this->photoService->deletePhotos($photoIds);

            return $this->sendResponse([], 'Photos deleted successfully.');
        } catch (ValidationException $e) {
            return $this->sendError('Validation error.', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
