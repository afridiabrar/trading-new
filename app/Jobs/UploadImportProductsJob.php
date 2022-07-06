<?php

namespace App\Jobs;

use App\CPU\ImageManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $rows = [];

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            foreach ($this->rows as $chunk){
                $contents = file_get_contents($chunk[4]);
                if($contents){
                    $images = ImageManager::upload('product/', 'png', $chunk[4]);
                    $thumbnail = ImageManager::upload('product/thumbnail/', 'png',$chunk[4]);

                    $category = \App\Model\Category::where('parent_id',0)
                        ->where('home_status',1)->inRandomOrder()->first();

                    $x = \App\Model\Product::create([
                        'added_by' => 'admin',
                        'user_id'=>1,
                        'name' => $chunk[1],
                        'slug' => str_replace(' ','',$chunk[1]),
                        'category_ids' => json_encode($category),
                        'unit' => 'pc',
                        'images' => json_encode([$images]),
                        'thumbnail' => $thumbnail,
                        'colors' => json_encode([]),
                        'choice_options' => json_encode([]),
                        'variation' => json_encode([]),
                        'unit_price' => $chunk[2],
                        'purchase_price' => $chunk[2],
                        'discount_type' => 'percent',
                        'current_stock' => 10,
                        'details' => $chunk[1],
                        'status' => 1,
                        'meta_title' => $chunk[1],
                        'meta_description' => $chunk[1],
                        'meta_image' => $thumbnail,
                        'is_trade' => rand(0,1),
                        'trade_qty' => 1,
                    ]);
                }
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
//            Log::($e->getMessage());
        }
    }
}
