<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    public function getTopHeadlines(string $country = 'id', string $category = 'general')
    {
        if (!$this->apiKey) {
            Log::error('News API key is not set.');
            return [];
        }

        try {
            $response = Http::get('https://newsapi.org/v2/top-headlines', [
                'apiKey' => $this->apiKey,
                // 'country' => $country,
                // 'category' => $category,
                'sources' => 'bbc-news',
            ]);

            if ($response->successful()) {
                return $response->json('articles', []);
            }

            Log::error('Failed to fetch news from API.', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching news.', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }
}
