<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveInstagram;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiveInstagramController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $LiveInstagrams = LiveInstagram::all();
            return response()->json(
                $LiveInstagrams
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
            $LiveInstagram = new LiveInstagram();
            $LiveInstagram->description = $request->description;
            $LiveInstagram->link = $request->link;
            $LiveInstagram->save();

            return response()->json([
                'message' => 'LiveInstagram created successfully',
                'LiveInstagram' => $LiveInstagram
//            $LiveInstagram
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $LiveInstagram = LiveInstagram::find($id);
            if (!$LiveInstagram) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveInstagram->description = $request->description;
            $LiveInstagram->link = $request->link;
            $LiveInstagram->save();
            return response()->json([
                'message' => 'LiveInstagram Updated successfully',
                'LiveInstagram' => $LiveInstagram
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $LiveInstagram = LiveInstagram::find($id);
            if (!$LiveInstagram) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $LiveInstagram
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $LiveInstagram = LiveInstagram::find($id);
            if (!$LiveInstagram) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveInstagram->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
