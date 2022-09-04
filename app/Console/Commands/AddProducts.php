<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AddProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //add products from database/product_dataset.json
        //create a user with admin role if no user exits
        $user = User::find(1);
        if (!$user) {
            $user = User::create([
                'name' => 'admin',
                'email' => 'admin@product.com',
                'password' => bcrypt('admin'),
                'phone' => '0123456789',
                'role' => 'admin'
            ]);
        }
        $products = json_decode(file_get_contents(database_path('product_dataset.json')), true);

        //add this products to this user
        $user->product()->createMany($products);


        return 0;
    }
}
