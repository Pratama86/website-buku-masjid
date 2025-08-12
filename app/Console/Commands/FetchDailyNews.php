<?php

namespace App\Console\Commands;

use App\Services\NewsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FetchDailyNews extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch daily news and cache them';

    public function handle(NewsService $newsService)
    {
        $this->info('Fetching daily news...');
        try {
            $articles = $newsService->getTopHeadlines();
            Cache::put('top_headlines', $articles, now()->addDay());
            $this->info('Successfully fetched and cached '.count($articles).' news articles.');
            Log::info('Successfully fetched and cached '.count($articles).' news articles.');
        } catch (\Exception $e) {
            $this->error('Failed to fetch news.');
            Log::error('Failed to fetch news.', ['error' => $e->getMessage()]);
        }
    }
}