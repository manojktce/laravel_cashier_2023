<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic', 
                'slug' => 'basic', 
                'stripe_plan' => 'price_1NUofmKNn8u3628oAW8YhxUJ', 
                'price' => 10, 
                'description' => 'Basic Monthly'
            ],
            [
                'name' => 'Premium', 
                'slug' => 'premium', 
                'stripe_plan' => 'price_1NUogJKNn8u3628omctbb0Ob', 
                'price' => 100, 
                'description' => 'Premium'
            ],
            [
                'name' => 'Basic', 
                'slug' => 'Basic', 
                'stripe_plan' => 'price_1NUpjyKNn8u3628o6HYtwv18', 
                'price' => 25, 
                'description' => 'Basic Quarterly'
            ]
        ];
  
        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
