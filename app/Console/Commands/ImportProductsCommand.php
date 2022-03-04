<?php

namespace App\Console\Commands;

use App\Infrastructure\Services\ProductService;
use App\Jobs\ImportProducts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa todos os produtos do Webservice ALDO para dentro do sistema';

    /**
     * Execute the console command.
     *
     * @param ProductService $productService
     * @return int
     */
    public function handle(ProductService $productService)
    {
        ini_set('memory_limit', '-1');
        try {
            $this->info('Dispatching Job to start products import');
            ImportProducts::dispatchNow();

            return 0;
        } catch (\Exception $t) {
            Log::error($t->getMessage());
        }
    }
}
