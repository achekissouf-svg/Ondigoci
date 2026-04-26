<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::withCount('produits')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libel_categorie' => 'required|string|max:50|unique:categories,libel_categorie',
        ]);

        Categorie::create([
            'id_categorie'    => 'CAT' . strtoupper(substr(md5(time()), 0, 6)),
            'libel_categorie' => $request->libel_categorie,
            'slug_categorie'  => \Illuminate\Support\Str::slug($request->libel_categorie),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée !');
    }

    public function edit(string $id)
    {
        $categorie = Categorie::where('id_categorie', $id)->firstOrFail();
        return view('admin.categories.edit', compact('categorie'));
    }

    public function update(Request $request, string $id)
    {
        $categorie = Categorie::where('id_categorie', $id)->firstOrFail();

        $request->validate([
            'libel_categorie' => 'required|string|max:50|unique:categories,libel_categorie,' . $categorie->id_categorie . ',id_categorie',
        ]);

        $categorie->update([
            'libel_categorie' => $request->libel_categorie,
            'slug_categorie'  => \Illuminate\Support\Str::slug($request->libel_categorie),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour !');
    }

    public function destroy(string $id)
    {
        $categorie = Categorie::where('id_categorie', $id)->firstOrFail();
        
        if ($categorie->produits()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie qui contient des produits.');
        }

        $categorie->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }
}
