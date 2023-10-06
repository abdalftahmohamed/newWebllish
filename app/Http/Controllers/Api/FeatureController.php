<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    use GeneralTrait;
    use ImageTrait;
    public function index(): JsonResponse
    {
        try {
            $Features = Feature::all();
            $featuresWithUrls = $Features->map(function ($feature) {
                $feature->icon = url('attachments/feature/' .$feature->id.'/'. $feature->icon);
                return $feature;
            });
            return response()->json([
                'message' => 'Feature data retrieved successfully',
                'features' => $featuresWithUrls,
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $Feature = new Feature();
            $Feature->name = $request->name;
            $Feature->description = $request->description;
            $Feature->save();

            if ($request->hasfile('icon')) {
                $icon_image = $this->saveImage($request->icon, 'attachments/feature/'.$Feature->id);
                $Feature->icon = $icon_image;
                $Feature->save();
            }

            $Feature->icon = url('attachments/feature/' .$Feature->id.'/'. $Feature->icon);

            return response()->json([
                'message' => 'Feature created successfully',
                'Feature' => $Feature
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $Feature = Feature::find($id);
            if (!$Feature) {
                return $this->returnError('E004', 'this Id not found');
            }
            $Feature->name = $request->name;
            $Feature->description = $request->description;
            $Feature->icon = $request->icon;
            $Feature->save();
            if ($request->hasfile('icon')) {
                $this->deleteFile('feature',$id);
                $icon_image = $this->saveImage($request->icon, 'attachments/feature/'.$Feature->id);
                $Feature->icon = $icon_image;
                $Feature->save();
            }
            $Feature->icon = url('attachments/feature/' .$Feature->id.'/'. $Feature->icon);
            return response()->json([
                'message' => 'notification Updated successfully',
                'Feature' => $Feature
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $Feature = Feature::find($id);
            if (!$Feature) {
                return $this->returnError('E004', 'this Id not found');
            }
            $Feature->icon = url('attachments/feature/' .$Feature->id.'/'. $Feature->icon);
            return response()->json([
                $Feature
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $Feature = Feature::find($id);
            if (!$Feature) {
                return $this->returnError('E004', 'this Id not found');
            }
            $this->deleteFile('feature',$id);
            $Feature->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
