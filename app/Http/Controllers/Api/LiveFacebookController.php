<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveFacebook;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiveFacebookController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $LiveFaceBooks = LiveFacebook::all();
            return response()->json(
                $LiveFaceBooks
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
            $LiveFaceBook = new LiveFacebook();
            $LiveFaceBook->description = $request->description;
            $LiveFaceBook->link = $request->link;
            $LiveFaceBook->save();

            return response()->json([
                'message' => 'LiveFaceBook created successfully',
                'LiveFaceBook' => $LiveFaceBook
//            $LiveFaceBook
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $LiveFaceBook = LiveFacebook::find($id);
            if (!$LiveFaceBook) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveFaceBook->description = $request->description;
            $LiveFaceBook->link = $request->link;
            $LiveFaceBook->save();
            return response()->json([
                'message' => 'LiveFaceBook Updated successfully',
                'LiveFaceBook' => $LiveFaceBook
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $LiveFaceBook = LiveFacebook::find($id);
            if (!$LiveFaceBook) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $LiveFaceBook
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $LiveFaceBook =  LiveFacebook::find($id);
            if (!$LiveFaceBook) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveFaceBook->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
