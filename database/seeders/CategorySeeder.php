<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $valores=[
            'Divulgacion'=>'#E57373',
            'Literatura'=>'#F06292',
            'Deportes'=>'#BA68C8',
            'Hardware'=>'#9575CD',
            'Software'=>'#64B5F6'
        ];
        foreach($valores as $nombre=>$color){
            Category::create(compact('nombre', 'color'));
            /**
             * Category([
             * 'nombre'=>$nombre,
             * 'color'=>$color
             * ])
             */
        }
    }
}
