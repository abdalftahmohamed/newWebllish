<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveLinkedin;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LiveLinkedinController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $LiveLinkedins = LiveLinkedin::all();
            return response()->json(
                $LiveLinkedins
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
            $LiveLinkedin = new LiveLinkedin();
            $LiveLinkedin->description = $request->description;
            $LiveLinkedin->link = $request->link;
            $LiveLinkedin->save();

            return response()->json([
                'message' => 'LiveLinkedin created successfully',
                'LiveLinkedin' => $LiveLinkedin
//            $LiveLinkedin
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $LiveLinkedin = LiveLinkedin::find($id);
            if (!$LiveLinkedin) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveLinkedin->description = $request->description;
            $LiveLinkedin->link = $request->link;
            $LiveLinkedin->save();
            return response()->json([
                'message' => 'LiveLinkedin Updated successfully',
                'LiveLinkedin' => $LiveLinkedin
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $LiveLinkedin = LiveLinkedin::find($id);
            if (!$LiveLinkedin) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $LiveLinkedin
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $LiveLinkedin = LiveLinkedin::find($id);
            if (!$LiveLinkedin) {
                return $this->returnError('E004', 'this Id not found');
            }
            $LiveLinkedin->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
