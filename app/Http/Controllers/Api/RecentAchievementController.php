<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecentAchievement;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecentAchievementController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $RecentAchievements = RecentAchievement::all();
            return response()->json(
                $RecentAchievements
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $RecentAchievement = new RecentAchievement();
            $RecentAchievement->name = $request->name;
            $RecentAchievement->description = $request->description;
            $RecentAchievement->save();

            return response()->json([
                'message' => 'RecentAchievement created successfully',
                'RecentAchievement' => $RecentAchievement
//            $RecentAchievement
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $RecentAchievement = RecentAchievement::find($id);
            if (!$RecentAchievement) {
                return $this->returnError('E004', 'this Id not found');
            }
            $RecentAchievement->name = $request->name;
            $RecentAchievement->description = $request->description;
            $RecentAchievement->save();
            return response()->json([
                'message' => 'notification Updated successfully',
                'RecentAchievement' => $RecentAchievement
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $RecentAchievement = RecentAchievement::find($id);
            if (!$RecentAchievement) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'notification' => $RecentAchievement
                $RecentAchievement
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $RecentAchievement = RecentAchievement::find($id);
            if (!$RecentAchievement) {
                return $this->returnError('E004', 'this Id not found');
            }
            $RecentAchievement->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
