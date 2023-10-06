<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopNotification;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopNotificationController extends Controller
{
    use GeneralTrait;

    public function index(): JsonResponse
    {
        try {
            $TopNotifications = TopNotification::all();
            return response()->json(
                $TopNotifications
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $TopNotification = new TopNotification();
            $TopNotification->name = $request->name;
            $TopNotification->description = $request->description;
            $TopNotification->save();

            return response()->json([
                'message' => 'TopNotification created successfully',
                'TopNotification' => $TopNotification
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $TopNotification = TopNotification::find($id);
            if (!$TopNotification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $TopNotification->name = $request->name;
            $TopNotification->description = $request->description;
            $TopNotification->save();
            return response()->json([
                'message' => 'notification Updated successfully',
                'TopNotification' => $TopNotification
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $TopNotification = TopNotification::find($id);
            if (!$TopNotification) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                    'message' => 'top_notification Show successfully',
                    'top_notification' => $TopNotification
//                $TopNotification
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $TopNotification = TopNotification::find($id);
            if (!$TopNotification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $TopNotification->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
