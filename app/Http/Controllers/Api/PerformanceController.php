<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\PerformanceRequest;
use App\Http\Resources\MonthResource;
use App\Http\Resources\PerformanceResource;
use App\Models\Month;
use App\Models\Performance;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;

class PerformanceController extends Controller
{

    use GeneralTrait;
    public function index():  JsonResponse
    {
        try {
//            $performances = Performance::all();
          $month=Month::with('performances')->get();
            return response()->json([
                'status'=>true,
                'data'=>MonthResource::collection($month)
//                'data'=>PerformanceResource::collection($performances)
            ]);

        }catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(PerformanceRequest $request):  JsonResponse
    {
        try {
            $month=Month::find($request->month_id);
            if (!$month){
                return response()->json([
                    'status'=>false,
                    'message'=>'this id of month not found'
                ],502);
            }
            $performance = new Performance();
            $performance->sympol = $request->sympol;
            $performance->target = $request->target;
            $performance->reached_min = $request->reached_min;
            $performance->reached_max = $request->reached_max;
            $performance->comment = $request->comment;
            $performance->month_id = $request->month_id;
            $performance->save();

            return response()->json([
                'status'=>true,
                'data' => new PerformanceResource($performance)
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function update(PerformanceRequest $request, $id):  JsonResponse
    {
        try {
            $month=Month::find($request->month_id);
            if (!$month){
                return response()->json([
                    'status'=>false,
                    'message'=>'this id of month not found'
                ],502);
            }
            $performance =Performance::find($id);
            if (!$performance){
                return response()->json([
                    'status'=>false,
                    'message'=>'this id of month not found'
                ],502);
            }

            $performance->sympol = $request->sympol;
            $performance->target = $request->target;
            $performance->reached_min = $request->reached_min;
            $performance->reached_max = $request->reached_max;
            $performance->comment = $request->comment;
            $performance->month_id = $request->month_id;
            $performance->save();
            return response()->json([
                'status'=>true,
                'message' => 'performance Updated successfully',
                'data' => new PerformanceResource($performance)
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($month_id):  JsonResponse
    {
        try {
            $month=Month::find($month_id);
            if (!$month){
                return response()->json([
                    'status'=>false,
                    'message'=>'this id of month not found'
                ],502);
            }
            return response()->json([
                'status'=>true,
                'data'=>new MonthResource($month)
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id):  JsonResponse
    {
        try {
            $performance = Performance::find($id);
            if (!$performance){
                return response()->json([
                    'status'=>false,
                    'message'=>'this id of Performance not found'
                ],502);
            }
            $performance->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}

