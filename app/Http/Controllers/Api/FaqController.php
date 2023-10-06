<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\FaqRequest;
use App\Models\Faq;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    use GeneralTrait;
    use ImageTrait;
    public function index():  JsonResponse
    {
        try {
            $faqs = Faq::all();

            return response()->json(
                $faqs
                ,200);

        }catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(FaqRequest $request):  JsonResponse
    {
        try {
            $faq = new Faq();
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();

            return response()->json([
//                'message' => 'Faq created successfully',
//                'Faq' => $faq
            $faq
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function update(FaqRequest $request, $id):  JsonResponse
    {
        try {
            $faq =Faq::find($id);
            if (!$faq){
                return $this->returnError('E004','this Id not found');
            }
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();

            return response()->json([
                'message' => 'faq Updated successfully',
                'faq' => $faq
//            $faq
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show( $id):  JsonResponse
    {
        try {
            $faq =Faq::findOrFail($id);
            if (!$faq){
                return $this->returnError('E004','this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'faq' => $faq
                $faq
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id):  JsonResponse
    {
        try {
            $faq = Faq::find($id);
            if (!$faq){
                return $this->returnError('E004','this Id not found');
            }
            $this->deleteFile('faqs',$faq->id);
            $faq->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}

