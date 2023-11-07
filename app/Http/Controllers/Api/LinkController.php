<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $Links = Link::all();
            return response()->json(
                $Links
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'description_facebook' => 'nullable',
                'name_facebook' => 'nullable',
                'link_facebook' => 'nullable',
                'description_youtube' => 'nullable',
                'name_youtube' => 'nullable',
                'link_youtube' => 'nullable',
                'description_twitter' => 'nullable',
                'name_twitter' => 'nullable',
                'link_twitter' => 'nullable',
                'description_instagram' => 'nullable',
                'name_instagram' => 'nullable',
                'link_instagram' => 'nullable',
                'description_linkedin' => 'nullable',
                'name_linkedin' => 'nullable',
                'link_linkedin' => 'nullable',
            ]);

            // Create a new social media link using the validated data
            $Link= Link::create($validatedData);

            return response()->json([
                'message' => 'Link created successfully',
                'Links' => $Link
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $Link = Link::find($id);
            if (!$Link) {
                return $this->returnError('E004', 'this Id not found');
            }
            // Validate the incoming request data
            $validatedData = $request->validate([
                'description_facebook' => 'nullable',
                'name_facebook' => 'nullable',
                'link_facebook' => 'nullable',
                'description_youtube' => 'nullable',
                'name_youtube' => 'nullable',
                'link_youtube' => 'nullable',
                'description_twitter' => 'nullable',
                'name_twitter' => 'nullable',
                'link_twitter' => 'nullable',
                'description_instagram' => 'nullable',
                'name_instagram' => 'nullable',
                'link_instagram' => 'nullable',
                'description_linkedin' => 'nullable',
                'name_linkedin' => 'nullable',
                'link_linkedin' => 'nullable',
            ]);
            $Link->update($validatedData);

            return response()->json([
                'message' => 'Link Updated successfully',
                'Link' => $Link
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $Link = Link::find($id);
            if (!$Link) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $Link
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $Link = Link::find($id);
            if (!$Link) {
                return $this->returnError('E004', 'this Id not found');
            }
            $Link->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
