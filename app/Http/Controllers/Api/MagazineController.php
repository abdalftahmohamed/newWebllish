<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\MagazineRequest;
use App\Http\Resources\MagazineResource;
use App\Models\User;
use App\Notifications\MagazineFirebaseNotification;
use App\Notifications\MagazineNotification;
use App\Notifications\TeamNotification;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Models\Magazine;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class MagazineController extends Controller
{
    use GeneralTrait;
    use ImageTrait;
    public function index():  JsonResponse
    {
        try {
            $magazines = Magazine::all();
            return response()->json(
                MagazineResource::collection($magazines)
            );

        }catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(MagazineRequest $request):  JsonResponse
    {
        try {
            $magazine = new Magazine();
            $magazine->name = $request->name;
            $magazine->author = $request->author;
            $magazine->title = $request->title;
            $magazine->datesend = $request->datesend;
            $magazine->description = $request->description;
            $magazine->save();
            $magazine_image = $this->saveImage($request->image,'attachments/magazines/'.$magazine->id);
            $magazine->image = $magazine_image;
            $magazine->save();

            $user = User::find(auth('api')->user()->id);
            $getUsers=User::where('id','!=', $user->id)->get();
            if ($getUsers) {
                foreach ($getUsers as $getUser) {
                    $getUser->notify(new MagazineFirebaseNotification($user));
                }
            }
            return response()->json([
                'message' => 'Magazine created successfully',
                'client' => new MagazineResource(Magazine::find($magazine->id))
//            $magazine
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function update(MagazineRequest $request, $id):  JsonResponse
    {
        try {
            $magazine =Magazine::find($id);
            if (!$magazine){
                return $this->returnError('E004','this Id not found');
            }
                $magazine->name = $request->name;
                $magazine->author = $request->author;
                $magazine->title = $request->title;
                $magazine->datesend = $request->datesend;
                $magazine->description = $request->description;
                $magazine->save();
                if ($request->hasFile('image')) {
                    $this->deleteFile('magazines',$id);
                    $magazine_image = $this->saveImage($request->image,'attachments/magazines/'.$magazine->id);
                    $magazine->image = $magazine_image;
                    $magazine->save();
                }
                return response()->json([
                    'message' => 'magazine Updated successfully',
                    'magazine' => new MagazineResource(Magazine::find($magazine->id))
                ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show( $id):  JsonResponse
    {
        try {
            $magazine =Magazine::find($id);
            if (!$magazine){
                return $this->returnError('E004','this Id not found');
            }
            return response()->json([
//                    'status' => true,
//                    'data' =>
                new MagazineResource(Magazine::find($magazine->id))
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id):  JsonResponse
    {
        try {
            $magazine = Magazine::find($id);
            if (!$magazine){
                return $this->returnError('E004','this Id not found');
            }
            $this->deleteFile('magazines',$magazine->id);
            $magazine->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}

