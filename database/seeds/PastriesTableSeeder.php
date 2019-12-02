<?php

use Illuminate\Database\Seeder;


class PastriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            mkdir(storage_path().'/app/pastries');
            mkdir(storage_path().'/app/pastries/1');
            mkdir(storage_path().'/app/pastries/2');
            mkdir(storage_path().'/app/pastries/3');
            mkdir(storage_path().'/app/pastries/4');
        }catch (\Exception $e){

        }

        copy(base_path().'/database/seeds/images/pastel-frango.jpg',storage_path().'/app/pastries/1/pastel-frango.jpg');

        \App\Models\Pastry::updateOrCreate(
          [
              'id' => 1
          ],
          [
              'name'  => "Pastel de Frango com Catupiry",
              'price' => 6.00,
              'photo' => 'pastel-frango.jpg'
          ]
        );

        copy(base_path().'/database/seeds/images/pastel-carne.jpeg',storage_path().'/app/pastries/2/pastel-carne.jpeg');

        \App\Models\Pastry::updateOrCreate(
            [
                'id' => 2
            ],
            [
                'name'  => "Pastel de Carne",
                'price' => 5.00,
                'photo' => 'pastel-carne.jpeg'
            ]
        );

        copy(base_path().'/database/seeds/images/pastel-queijo.jpg',storage_path().'/app/pastries/3/pastel-queijo.jpg');

        \App\Models\Pastry::updateOrCreate(
            [
                'id' => 3
            ],
            [
                'name'  => "Pastel de Queijo",
                'price' => 5.00,
                'photo' => 'pastel-queijo.jpg'
            ]
        );

        copy(base_path().'/database/seeds/images/pastel-calabresa-queijo.jpeg',storage_path().'/app/pastries/4/pastel-calabresa-queijo.jpeg');

        \App\Models\Pastry::updateOrCreate(
            [
                'id' => 4
            ],
            [
                'name'  => "Pastel de Calabresa com Queijo",
                'price' => 6.00,
                'photo' => 'pastel-calabresa-queijo.jpeg'
            ]
        );



    }
}
