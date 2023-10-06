<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveYoutube;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiveYoutubeController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $LiveYoutubes = LiveYoutube::all();
            return response()->json(
                $LiveYoutubes
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $rules = [
                "link" => "string",
                "description" => "string|min:7",
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $LiveYoutube = new LiveYoutube();
            $LiveYoutube->description = $request->description;
            $LiveYoutube->link = $request->link;
            $LiveYoutube->save();

            return response()->json([
                'message' => 'LiveYoutube created successfully',
                'LiveYoutube' => $LiveYoutube
//            $LiveYoutube
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $LiveYoutube = LiveYoutube::find($id);
            if (!$LiveYoutube) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveYoutube->description = $request->description;
            $LiveYoutube->link = $request->link;
            $LiveYoutube->save();
            return response()->json([
                'message' => 'LiveYoutube Updated successfully',
                'LiveYoutube' => $LiveYoutube
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $LiveYoutube = LiveYoutube::find($id);
            if (!$LiveYoutube) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $LiveYoutube
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $LiveYoutube = LiveYoutube::find($id);
            if (!$LiveYoutube) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveYoutube->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
