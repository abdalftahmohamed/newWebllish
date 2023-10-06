<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\AdvertisementRequest;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AdvertisementController extends Controller
{
    use GeneralTrait;
    use ImageTrait;
    public function index()
    {
        try {
            $advertisements = Advertisement::all();
            return response()->json(
                AdvertisementResource::collection($advertisements)
            );

        }catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function store(AdvertisementRequest $request)
    {
        try {
            $advertisement = new Advertisement();
            $advertisement->name = $request->name;
            $advertisement->description = $request->description;
            $advertisement->save();

            if ($request->hasFile('image')) {
//                $this->deleteFile('advertisements',$id);
                $advertisement_image = $this->saveImage($request->image,'attachments/advertisements/'.$advertisement->id);
                $advertisement->image = $advertisement_image;
                $advertisement->save();
            }



            if ($request->hasFile('video')) {
                $advertisement_video = $this->saveImage($request->video,'attachments/advertisements/'.$advertisement->id);
                $advertisement->video = $advertisement_video;
                $advertisement->save();
            }


            return response()->json([
                'message' => 'Advertisement created successfully',
                'data' => new AdvertisementResource(Advertisement::find($advertisement->id))
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function update(AdvertisementRequest $request, $id)
    {
        try {
            $advertisement =Advertisement::find($id);
            if (!$advertisement){
                return $this->returnError('E004','this Id not found');
            }
            $advertisement->name = $request->name;
            $advertisement->description = $request->description;
            $advertisement->save();

            if ($request->hasFile('image')) {
//                $this->deleteFile('advertisements',$id);
                $advertisement_image = $this->saveImage($request->image,'attachments/advertisements/'.$advertisement->id);
                $advertisement->image = $advertisement_image;
                $advertisement->save();
            }

            if ($request->hasFile('video')) {
//                $this->deleteFile('advertisements',$id);
                $advertisement_video = $this->saveVideo($request->video,'attachments/advertisements/'.$advertisement->id);
                $advertisement->video = $advertisement_video;
                $advertisement->save();
            }
            return response()->json([
                'message' => 'advertisement Updated successfully',
                'data' =>  new AdvertisementResource(Advertisement::find($advertisement->id))
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show( $id)
    {
        try {
            $advertisement =Advertisement::find($id);
            if (!$advertisement){
                return $this->returnError('E004','this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'advertisement' => $advertisement
                new AdvertisementResource(Advertisement::find($advertisement->id))
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id)
    {
        try {
            $advertisement = Advertisement::find($id);
            if (!$advertisement){
                return $this->returnError('E004','this Id not found');
            }
            $this->deleteFile('advertisements',$advertisement->id);
            $advertisement->delete();
            return response()->json([
                'status' => true,
                'message' => 'data Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


}
