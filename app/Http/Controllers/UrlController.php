<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateUrlRequest;
use App\Models\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UrlController extends Controller
{
    public function unAuthUrl()
    {
        return sendResponse(
            'Generate a short URL',
            env('APP_URL') . '/' . Str::random(10)
        );
    }


    public function generateUrl(GenerateUrlRequest $generateUrlRequest)
    {
        $slug = Str::random(10);
        $insertData = [
            'link' => $generateUrlRequest->get('link')
        ];

        if ($generateUrlRequest->has('slug')) {
            $slug = $generateUrlRequest->get('slug');

            $insertData['slug'] = $slug;
        }

        $existingUrl = Url::where($insertData)->first();

        if (!$existingUrl) {
            $insertData['created_at'] = date('Y-m-d H:i:s');
            $insertData['updated_at'] = date('Y-m-d H:i:s');

            if ( ! Auth::check() ){
                $insertData['shortened_url'] = $insertData['link'] . '/' . $slug;

                insertIntoTable('urls', $insertData);

                return sendResponse(
                    'Generate a short URL',
                    $insertData,
                    Response::HTTP_CREATED
                );
            }
        } else {
            return sendResponse(
                'Generate a short URL',
                $existingUrl,
                Response::HTTP_OK
            );
        }

        return null;
    }


    private function storeIntoUrlTable($slug)
    {
        $insertData = [
            'slug' => $slug,
            'link' => request()->query('link'),
            'user_id' => Auth::id(),
        ];
    }
}
