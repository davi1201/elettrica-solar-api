<?php 

namespace App\Infrastructure\Services;

use App\Entities\Product;
use App\Model\Agent;
use App\Model\Client;
use App\Model\Project;
use App\Model\ProjectDiscount;
use App\Model\ProjectProduct;
use App\Model\ProjectTransformer;
use App\ProductCuston;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Support\Facades\Http;

class ProjectService
{
    public function create(Array $data)
    {
        $project = new Project($data);
        
        DB::transaction(function () use ($project, $data) {            
            $project->save();

            // foreach ($data['transformers'] as $code => $quantity) {
            //     $project_transformer_data = [
            //         'project_id' => $project->id,
            //         'product_code' => $code,
            //         'quantity' => $quantity,
            //     ];

            //     $project_transformer = new ProjectTransformer($project_transformer_data);
            //     $project_transformer->save();
            // }

            if ($data['agent_percentage'] < 5) {
                $data['project_discount']['project_id'] = $project->id;
                $project_discount = new ProjectDiscount($data['project_discount']);
                $project_discount->save();

                $data['price'] = $data['project_discount']['price_with_discount'];
            }
            
            
            $project_product_data = [
                'project_id' => $project->id,
                'product_code' => $data['code'],
                'quantity' => 1,
                'price' => $data['price_cost'],
                'panel_count' => $data['panel_count'],
                'power' => $data['kwp'],
                'estimate_power' => $data['estimate_power']
            ];
            $project_product = new ProjectProduct($project_product_data);
            $project_product->save();            
        });
        return $project;
    }

    public function update(Project $project, Array $data):Project
    {
        $project_discount = new ProjectDiscount($data['project_discount']);
        $project_discount->save();

        $project->price = $project_discount->price_with_discount;
        $project->save();
        return $project;
    }

    public function updateKit(Project $project, ProductCuston $productCuston)
    {
        $project->projectProduct->product_custon_id = $productCuston->id;
        $project->projectProduct->save();
    }    

    public function findById($sku)
    {        
        $url = env('SOLFACIL_URL') .'?page=1&page_size=1&skus[0]=' . $sku;
        // dd($url);
        $response = Http::withHeaders([
                            'api-access-key' => env('SOLFACIL_KEY'),
                            'api-secret-key' => env('SOLFACIL_PASSWORD')
                        ])
                        ->acceptJson()
                        ->get($url);

        $kit = $response->json();
        return $kit['data'];
    }
}
