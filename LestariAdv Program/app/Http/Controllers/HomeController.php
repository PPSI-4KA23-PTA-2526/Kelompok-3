<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk aktif dengan kategori dan varian
        $products = Product::with(['category', 'variants' => function ($query) {
            $query->active()->ordered();
        }])
            ->active()
            ->ordered()
            ->take(12) // Ambil 12 produk untuk carousel
            ->get();

        // Ambil kategori aktif
        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->get();

        return view('pages.welcome', compact('products', 'categories'));
    }
}
