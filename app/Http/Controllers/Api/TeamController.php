<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\User;
use App\Notifications\TeamNotification;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Models\Team;
use Illuminate\Support\Facades\Notification;

class TeamController extends Controller
{
    use GeneralTrait;
    use ImageTrait;
    public function index()
    {
        try {
            $teams = Team::all();
            return response(
                TeamResource::collection($teams)
            );
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(TeamRequest $request)
    {
        try {
            $team = new Team();
            $team->name = $request->name;
            $team->description = $request->description;
            $team->namesection = $request->namesection;
            $team->save();
            $team_image = $this->saveImage($request->image,'attachments/teams/'.$team->id);
            $team->image = $team_image;
            $team->save();

//            $users=User::where('id','!=',auth('api')->user()->id)->where('status','1')->get();
//            return $users;
//            $user_create=auth('api')->user()->name;
//            return $user_create;
//            Notification::send($users,new TeamNotification($team->id,$user_create,$request->name,$team_image));

//            $team->notify(new TeamNotification($team->id,$user_create,$request->name));
            return response()->json([
                'message' => 'Team created successfully',
                'team' =>new TeamResource(Team::find($team->id))
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function update(TeamRequest $request, $id)
    {
        try {
            $team =Team::find($id);
            if (!$team){
                return $this->returnError('E004','this Id not found');
            }
            $team->name = $request->name;
            $team->description = $request->description;
            $team->namesection = $request->namesection;
            $team->save();
            if ($request->hasFile('image')) {
                $this->deleteFile('teams',$id);
                $team_image = $this->saveImage($request->image,'attachments/teams/'.$team->id);
                $team->image = $team_image;
                $team->save();
            }
            return response()->json([
                'message' => 'Team Updated successfully',
                'team' => new TeamResource(Team::find($team->id))
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show( $id)
    {
        try {
            $team =Team::find($id);
            if (!$team){
                return $this->returnError('E004','this Id not found');
            }
                return response()->json([
                    'message' => 'Team Show successfully',
                    'team' => new TeamResource(Team::find($id))
                ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id)
    {
        try {
            $team = Team::find($id);
            if (!$team){
                return $this->returnError('E004','this Id not found');
            }
            $this->deleteFile('teams',$id);
            $team->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}

