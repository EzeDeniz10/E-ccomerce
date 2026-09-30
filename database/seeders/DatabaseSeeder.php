<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Usuario Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'is_admin' => true,
        ]);

        // 2. Crear Usuario Cliente de prueba
        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@gmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => false,
        ]);

        // 3. Crear Categorías de prueba
        $remeras = Category::create([
            'name' => 'Remeras',
            'slug' => 'remeras',
            'description' => 'Remeras de algodón de todos los talles'
        ]);

        $buzos = Category::create([
            'name' => 'Buzos',
            'slug' => 'buzos',
            'description' => 'Buzos frisados para invierno'
        ]);

        // 4. Crear Productos de prueba
        Product::create([
            'category_id' => $remeras->id,
            'supplier_id'  => null,
            'name'        => 'Remera Basica Negra',
            'slug'        => 'remera-basica-negra',
            'description' => 'Remera lisa 100% algodón',
            'price'       => 15000,
            'stock'       => 10,
            'is_active'   => true,
        ]);

        Product::create([
            'category_id' => $buzos->id,
            'supplier_id'  => null,
            'name'        => 'Buzo Oversize',
            'slug'        => 'buzo-oversize',
            'description' => 'Buzo frizado con capucha',
            'price'       => 35000,
            'stock'       => 5,
            'is_active'   => true,
        ]);
    }
}
