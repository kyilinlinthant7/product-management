<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRegistrationRequest;
use App\Http\Requests\ProductEditRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRegistrationRequest $request)
    {
        $imagePath = "";

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageExtension = $image->getClientOriginalExtension();
			$imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME). '_' . time() . '.' . $imageExtension;
			$image->move(public_path('storage/product_images'), $imageName);
			$imagePath = 'storage/product_images/' . $imageName;

			$product = new Product;
			$product->name = $request->name;
			$product->description = $request->description;
			$product->category_id = $request->category;
			$product->price = $request->price;
			$product->received_date = $request->received_date;
			$product->image = $imagePath;
			$product->save();

			$products = Product::get();
			return redirect()->route('products.index', ['products' => $products])->with('success', 'A new product was created successfully.');
		}
		return redirect()->back()->with('error', 'Saving category failed! Please try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$product = Product::find($id);
        $categories = Category::all();

		return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductEditRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
			return redirect()->route('products.edit', ['id' => $id])->with('error', 'Sorry! The product was already deleted.');
		}

		$currentImagePath = $product->image;

		$imagesDirectory = public_path('storage/product_images');
        if (!File::exists($imagesDirectory)) {
            File::makeDirectory($imagesDirectory, 0755, true);
        }

		if ($request->hasFile('image')) {

			$newImageFile = $request->file('image'); 
			$newImageName = $newImageFile->getClientOriginalName(); 
			$newImageExtension = $newImageFile->getClientOriginalExtension();  
			$newImageBaseName = pathinfo($newImageName, PATHINFO_FILENAME); 
			$newImageFullName = $newImageBaseName . '_' . time() . '.' . $newImageExtension; 

			$newImageFile->move($imagesDirectory, $newImageFullName);

			if (File::exists($currentImagePath)) {
				File::delete($currentImagePath);
			}

			$imagePath = "storage/product_images/" . $newImageFullName;

		} else {	
			$imagePath = $currentImagePath;
		}

		$product->name = $request->name;
		$product->description = $request->description;
		$product->category_id = $request->category;
		$product->price = $request->price;
		$product->received_date = $request->received_date;
		$product->image = $imagePath;
		$product->save();

		$products = Product::get();
		return redirect()->route('products.index', ['products' => $products])->with('success', 'The product was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
			$product = Product::findOrFail($id);
	
			if (!empty($product->image)) {
				File::delete($product->image);
			}
	
			$product->delete();

			return redirect()->back()->with('success', 'The product was deleted successfully.');

		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return redirect()->back()->with('error', 'Sorry! The product is already deleted or not found.');
		}
    }
}
