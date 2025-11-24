<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhoneWebController extends Controller
{
    public function index(Request $request)
    {
    
    $search = trim((string) $request->input('search', ''));

    $phones = Phone::query()
    ->with('category')
    ->when($search !== '', function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('number', 'ILIKE', "%{$search}%")
              ->orWhere('type', 'ILIKE', "%{$search}%")
              ->orWhereHas('category', function ($q2) use ($search) {
                  $q2->where('name', 'ILIKE', "%{$search}%");
              });
        });
    })
    ->latest('id')
    ->paginate(10)
    ->withQueryString();

    return Inertia::render('Phones/Index', [
        'phones'  => $phones,
      
        'filters' => $request->only('search'),
    ]);
}



    public function create()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Phones/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'max:50'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'area_code' => ['nullable', 'string', 'max:10'],
            'type' => ['nullable', 'string', 'max:50'],
            'is_primary' => ['required', 'boolean'],
            'extension' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'barcode' => ['nullable', 'string', 'max:255'],
        ]);

        Phone::create($validated);

        return redirect()
            ->route('phones.index')
            ->with('success', 'Teléfono creado correctamente.');
    }

    public function show(Phone $phone)
    {
        $phone->load('category');

        return Inertia::render('Phones/Show', [
            'phone' => $phone,
        ]);
    }

    public function edit(Phone $phone)
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Phones/Edit', [
            'phone' => $phone,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Phone $phone)
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'max:50'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'area_code' => ['nullable', 'string', 'max:10'],
            'type' => ['nullable', 'string', 'max:50'],
            'is_primary' => ['required', 'boolean'],
            'extension' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'barcode' => ['nullable', 'string', 'max:255'],
        ]);

        $phone->update($validated);

        return redirect()
            ->route('phones.index')
            ->with('success', 'Teléfono actualizado correctamente.');
    }

    public function destroy(Phone $phone)
    {
        $phone->delete();

        return redirect()
            ->route('phones.index')
            ->with('success', 'Teléfono eliminado correctamente.');
    }
}
