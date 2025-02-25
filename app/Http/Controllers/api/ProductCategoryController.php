<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = ProductCategory::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve categories', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'count' => 'nullable|integer',
                'image' => 'nullable|image',
                'icon' => 'nullable|string',
                'color' => 'nullable|string',
                'type' => 'nullable|in:category,location,feature',
                'has_child' => 'nullable|boolean',
                'category_image' => 'nullable|string',
            ]);

            $data = $request->all();
            if ($request->hasFile('image')) {
                $data['image'] = $this->handleImageUpload($request->file('image'));
            }

            $category = ProductCategory::create($data);
            return response()->json($category, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation Error', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve category', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            /* $request->validate([
            'title' => 'string|max:255',
            'category_image' => 'nullable|image',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'type' => 'nullable|in:category,location,feature',
            ]);
 */
            $category = ProductCategory::findOrFail($id);
            $data = $request->only([
            'title', 'category_image', 'color', 'icon', 'type'
            ]);

            if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
            }

            $category->update(array_filter($data));
            return response()->json($category, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation Error', 'message' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category', 'message' => $e->getMessage()], 500);
        }
    }

    private function handleImageUpload($image)
    {
        $path = $image->store('images', 'public');
        return Storage::url($path);
    }
}
