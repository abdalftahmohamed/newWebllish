<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUpPages;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowUpPagesController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $FollowUpPagess = FollowUpPages::all();
            return response()->json(
                $FollowUpPagess
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $rules = [
                "facebook" => "string|min:5",
                "youtube" => "string",
                "twitter" => "string",
                "linkedin" => "string",
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $FollowUpPages = new FollowUpPages();
            $FollowUpPages->facebook = $request->facebook;
            $FollowUpPages->youtube = $request->youtube;
            $FollowUpPages->instagram = $request->instagram;
            $FollowUpPages->twitter = $request->twitter;
            $FollowUpPages->save();

            return response()->json([
                'message' => 'FollowUpPages created successfully',
                'FollowUpPages' => $FollowUpPages
//            $FollowUpPages
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $FollowUpPages = FollowUpPages::find($id);
            if (!$FollowUpPages) {
                return $this->returnError('E004', 'this Id not found');
            }
            $FollowUpPages->facebook = $request->facebook;
            $FollowUpPages->youtube = $request->youtube;
            $FollowUpPages->instagram = $request->instagram;
            $FollowUpPages->twitter = $request->twitter;
            $FollowUpPages->save();
            return response()->json([
                'message' => 'FollowUpPages Updated successfully',
                'FollowUpPages' => $FollowUpPages
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $FollowUpPages = FollowUpPages::find($id);
            if (!$FollowUpPages) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $FollowUpPages
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $FollowUpPages = FollowUpPages::find($id);
            if (!$FollowUpPages) {
                return $this->returnError('E004', 'this Id not found');
            }
            $FollowUpPages->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
