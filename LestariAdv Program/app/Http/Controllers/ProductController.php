<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->get();

        $products = Product::with(['variants' => function ($q) {
            $q->active()->ordered();
        }])
            ->active()
            ->ordered()
            ->get();

        return view('pages.product', compact('categories', 'products'));
    }

    public function show($slug)
    {
        // Ambil product dengan relasi variants yang aktif dan category
        $product = Product::with(['variants' => function ($query) {
            $query->active()->ordered();
        }, 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Ambil variant pertama sebagai default
        $defaultVariant = $product->variants->first();

        // Ambil semua ukuran unik dari price_data semua variants
        $allSizes = $product->variants->flatMap(function ($variant) {
            return collect($variant->price_data ?? [])->pluck('ukuran');
        })->unique()->values();

        return view('pages.detail-product', compact('product', 'defaultVariant', 'allSizes'));
    }
}
