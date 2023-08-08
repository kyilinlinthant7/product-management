<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRegistrationRequest;
use App\Http\Requests\CategoryEditRequest;
use Illuminate\Support\Facades\File;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRegistrationRequest $request)
    {
		$imagePath = "";

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageExtension = $image->getClientOriginalExtension();
			$imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME). '_' . time() . '.' . $imageExtension;
			$image->move(public_path('storage/category_images'), $imageName);
			$imagePath = 'storage/category_images/' . $imageName;

			$category = new Category;
			$category->name = $request->name;
			$category->image = $imagePath;
			$category->save();

			$categories = Category::get();
			return redirect()->route('categories.index', ['categories' => $categories])->with('success', 'A new category was created successfully.');
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
        $category = Category::findOrFail($id);
        $products = $category->products;

        return view('categories.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$category = Category::find($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryEditRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
			$categories = Category::get();
			return redirect()->route('categories', ['categories' => $categories])->with('error', 'Sorry! The category was already deleted.');
        }

		$currentImagePath = $category->image;

		$imagesDirectory = public_path('storage/category_images');
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

			$imagePath = "storage/category_images/" . $newImageFullName;

		} else {	
			$imagePath = $currentImagePath;
		}

		$category->name = $request->name;
		$category->image = $imagePath;
		$category->update();

		$categories = Category::get();
		return redirect()->route('categories.index', ['categories' => $categories])->with('success', 'The category was updated successfully.');
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
			$category = Category::findOrFail($id);
	
			if (!empty($category->image)) {
				File::delete($category->image);
			}
	
			$category->delete();

			return redirect()->back()->with('success', 'The category was deleted successfully.');

		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return redirect()->back()->with('error', 'Sorry! The category is already deleted or not found.');
		}
    }
}
