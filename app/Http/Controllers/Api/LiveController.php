<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\LiveRequest;
use App\Models\Live;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    use GeneralTrait;
    public function index():  JsonResponse
    {
        try {
            $lives = Live::all();
            return response()->json(
                $lives
            );

        }catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(LiveRequest $request):  JsonResponse
    {
        try {
            $live = new Live();
            $live->name = $request->name;
            $live->link = $request->link;
            $live->description = $request->description;
            $live->save();


            return response()->json([
                'message' => 'Live created successfully',
                'client' => $live
//            $live
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function update(LiveRequest $request, $id):  JsonResponse
    {
        try {
            $live =Live::find($id);
            if (!$live){
                return $this->returnError('E004','this Id not found');
            }
            $live->name = $request->name;
            $live->link = $request->link;
            $live->description = $request->description;
            $live->save();

            return response()->json([
                'message' => 'live Updated successfully',
                'live' => $live
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show( $id):  JsonResponse
    {
        try {
            $live =Live::find($id);
            if (!$live){
                return $this->returnError('E004','this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'live' => $live
                $live
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id):  JsonResponse
    {
        try {
            $live = Live::find($id);
            if (!$live){
                return $this->returnError('E004','this Id not found');
            }
            $live->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}
