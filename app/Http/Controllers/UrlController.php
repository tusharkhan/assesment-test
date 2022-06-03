<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateUrlRequest;
use App\Models\Url;
use AshAllenDesign\ShortURL\Classes\Builder;
use AshAllenDesign\ShortURL\Facades\ShortURL;
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
        $port = $generateUrlRequest->getPort();
        $slug = Str::random(10);
        $insertData = [
            'link' => $generateUrlRequest->get('link')
        ];

        $mainUrl = $insertData['link'];

        if ($generateUrlRequest->has('slug')) {
            $slug = $generateUrlRequest->get('slug');

            $mainUrl = $generateUrlRequest->get('link') . '/' . $slug;
        }

        $insertData['slug'] = $slug;

        $existingUrl = Url::where($insertData)->first();

        if (!$existingUrl) {
            $insertData['created_at'] = date('Y-m-d H:i:s');
            $insertData['updated_at'] = date('Y-m-d H:i:s');

            $shortLink = env('APP_URL') . '/redirect/' . $slug;
            if ( $port ){
                $shortLink = env('APP_URL') . ':' . $port . '/redirect/' . $slug;
            }


            $insertData['shortened_url'] = $shortLink;
            $insertData['main_url']      = $mainUrl;

            insertIntoTable('urls', $insertData);

                return sendResponse(
                    'Generate a short URL',
                    [
                        'link' => $insertData['shortened_url']
                    ],
                    Response::HTTP_CREATED
                );

        } else {
            return sendResponse(
                'Generate a short URL',
                [
                    'link' => $existingUrl->shortened_url
                ],
                Response::HTTP_OK
            );
        }
    }


    public function redirectUrl($slug)
    {
        $url = Url::where('slug', $slug)->first();

        if ($url) {
            return redirect($url->main_url);
        } else {
            return redirect(env('APP_URL'));
        }

    }
}
