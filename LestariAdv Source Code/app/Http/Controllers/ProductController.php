<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->ordered()->get();

        // Query builder untuk products
        $query = Product::with(['variants' => function ($q) {
            $q->active()->ordered();
        }])
            ->active()
            ->ordered();

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $products = $query->get();

        // Get selected category untuk highlight di sidebar
        $selectedCategory = $request->category;
        $searchTerm = $request->search;

        return view('pages.product', compact('categories', 'products', 'selectedCategory', 'searchTerm'));
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
