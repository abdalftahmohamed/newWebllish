<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveTwitter;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiveTwitterController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $LiveTwitters = LiveTwitter::all();
            return response()->json(
                $LiveTwitters
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
            $LiveTwitter = new LiveTwitter();
            $LiveTwitter->description = $request->description;
            $LiveTwitter->link = $request->link;
            $LiveTwitter->save();

            return response()->json([
                'message' => 'LiveTwitter created successfully',
                'LiveTwitter' => $LiveTwitter
//            $LiveTwitter
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $LiveTwitter = LiveTwitter::find($id);
            if (!$LiveTwitter) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveTwitter->description = $request->description;
            $LiveTwitter->link = $request->link;
            $LiveTwitter->save();
            return response()->json([
                'message' => 'LiveTwitter Updated successfully',
                'LiveTwitter' => $LiveTwitter
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $LiveTwitter = LiveTwitter::find($id);
            if (!$LiveTwitter) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $LiveTwitter
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $LiveTwitter = LiveTwitter::find($id);
            if (!$LiveTwitter) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveTwitter->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
