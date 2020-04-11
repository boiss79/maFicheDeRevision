<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\ProductRating;
use App\ProductComment;
use App\ProductPurchased;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductComment;

class ProductCommentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $productPurchased = ProductPurchased::where(['buyer_id' => Auth::id(), 'product_id' => $product->id])->first();

        if (!$productPurchased) {
            return redirect()->back()->with('red', 'Vous devez acheter ce produit pour pouvoir laisser un commentaire.');
        }

        $isCommented = ProductComment::where(['user_id' => Auth::id(), 'product_id' => $productPurchased->product_id])->first();

        if ($isCommented) {
            return redirect()->back()->with('red', 'Vous avez déjà donné votre avis sur ce produit.');
        }

        return view('products.comments.create', [
            'product' => $productPurchased
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductComment $request)
    {
        $validated = $request->validated();

        ProductComment::create([
            'content' => $validated['content'],
            'product_id' => intval($validated['product_id']),
            'user_id' => Auth::id()
        ]);
        ProductRating::create([
            'rating' => intval($validated['rating']),
            'product_id' => intval($validated['product_id']),
            'user_id' => Auth::id()
        ]);

        return redirect()->route('orders.index')->with('green', 'Merci d\'avoir donner votre avis.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function show(ProductComment $productComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductComment $productComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductComment $productComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductComment  $productComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductComment $productComment)
    {
        //
    }
}
