<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Models\Category;

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

        // Get active portfolios grouped by slides (2 items per slide)
        $portfolioSlides = Portfolio::getPortfolioSlides();

        // Ambil kategori aktif
        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->get();

        // PERBAIKAN: Tambahkan $portfolioSlides ke compact()
        return view('pages.welcome', compact('products', 'categories', 'portfolioSlides'));
    }
}
