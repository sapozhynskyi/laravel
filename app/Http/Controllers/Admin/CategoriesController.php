<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::with('products')->paginate(5);
        return view('admin/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin/categories/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
        $data = $request->validated();
        $category = Category::create($data);
            DB::commit();
        return redirect()->route('admin.categories.index')
            ->with('status', "The category #{$category->id} was successfully created!");
        } catch (\Exception $e) {
            DB::rollBack();
            logs()->warning($e);
            return redirect()->back()->with('warn', 'Oops smth wrong. See logs')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        return view('admin/categories/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            DB::beginTransaction();
            $category->update($request->validated());
            DB::commit();
            return redirect()->route('admin.categories.index')
                ->with('status', "The category #{$category->id} was successfully updated!");
        } catch (\Exception $e) {
            DB::rollBack();
            logs()->warning($e);
            return redirect()->back()->with('warn', 'Oops smth wrong. See logs')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->products()->delete();
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('status', "The category #{$category->id} was successfully deleted!");
    }
}
