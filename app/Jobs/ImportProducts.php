<?php

namespace App\Jobs;

use App\Infrastructure\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productService = resolve(ProductService::class);
        $result = $productService->import();

        if ($result === true) {
            Log::info('[aldo_webservice] All products was imported successfull');
            return;
        }

        Log::error('[aldo_webservice] An error occurs while import Aldo products');
    }
}
