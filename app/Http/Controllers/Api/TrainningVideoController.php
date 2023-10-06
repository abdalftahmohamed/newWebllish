<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\TrainningVideoRequest;
use App\Http\Resources\TrainingVideoResource;
use App\Models\TrainningVideo;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;

class TrainningVideoController extends Controller
{
    use GeneralTrait;
    use ImageTrait;

    public function index(): JsonResponse
    {
        try {
            $trainningVideos = TrainningVideo::all();
            return response()->json(
                TrainingVideoResource::collection($trainningVideos)
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(TrainningVideoRequest $request): JsonResponse
    {
        try {
            $trainningVideo = new TrainningVideo();
            $trainningVideo->video_title = $request->video_title;
            $trainningVideo->video_description = $request->video_description;
            $trainningVideo->simple_description = $request->simple_description;
            $trainningVideo->save();
            if ($request->hasFile('image')) {
                //image save
                $trainningVideo_image = $this->saveImage($request->image,'attachments/trainningVideo/'.$trainningVideo->id);
                $trainningVideo->image = $trainningVideo_image;
                $trainningVideo->save();
            }
            if ($request->hasFile('video')) {
                //video save
                $trainningVideo_video = $this->saveImage($request->video,'attachments/trainningVideo/'.$trainningVideo->id);
                $trainningVideo->video = $trainningVideo_video;
                $trainningVideo->save();
            }

            return response()->json([
                'message' => 'TrainningVideo created successfully',
                'TrainningVideo' =>  new TrainingVideoResource(TrainningVideo::find($trainningVideo->id))
//            $trainningVideo
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(TrainningVideoRequest $request, $id): JsonResponse
    {
        try {
            $trainningVideo = TrainningVideo::find($id);
            if (!$trainningVideo) {
                return $this->returnError('E004', 'this Id not found');
            }
            $trainningVideo->video_title = $request->video_title;
            $trainningVideo->video_description = $request->video_description;
            $trainningVideo->simple_description = $request->simple_description;
            $trainningVideo->save();
            if ($request->hasFile('image')) {
                //image save
                $trainningVideo_image = $this->saveImage($request->image,'attachments/trainningVideo/'.$trainningVideo->id);
                $trainningVideo->image = $trainningVideo_image;
                $trainningVideo->save();
            }
            if ($request->hasFile('video')) {
                //video save
                $trainningVideo_video = $this->saveVideo($request->video,'attachments/trainningVideo/'.$trainningVideo->id);
                $trainningVideo->video = $trainningVideo_video;
                $trainningVideo->save();
            }
            return response()->json([
                'message' => 'trainningVideo Updated successfully',
                'trainningVideo' =>  new TrainingVideoResource(TrainningVideo::find($trainningVideo->id))
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $trainningVideo = TrainningVideo::find($id);
            if (!$trainningVideo) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'trainningVideo' => $trainningVideo
                new TrainingVideoResource(TrainningVideo::find($trainningVideo->id))
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $trainningVideo = TrainningVideo::find($id);
            if (!$trainningVideo) {
                return $this->returnError('E004', 'this Id not found');
            }
            $this->deleteFile('trainningVideo', $trainningVideo->id);
            $trainningVideo->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}
