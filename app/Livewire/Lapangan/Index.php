<?php

namespace App\Livewire\Lapangan;

use App\Models\Category;
use App\Models\Field;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
use WithPagination;

    public string $searchName = '';
    public string $searchCategory = '';
    // Catatan: Saya tambahkan searchCity sesuai UI, Anda perlu menyesuaikan logikanya
    public string $searchCity = '';

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSearchCategory()
    {
        $this->resetPage();
    }

    public function updatingSearchCity()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown filter
        $categories = Category::all();

        // Query dasar untuk mengambil venue
        $fieldsQuery = Field::query()->with('category');

        // Terapkan filter jika ada input dari pengguna
        $fieldsQuery->when($this->searchName, function ($query) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        });

        $fieldsQuery->when($this->searchCategory, function ($query) {
            $query->where('field_category_id', $this->searchCategory);
        });

        // @todo: Tambahkan logika filter untuk kota sesuai struktur database Anda
        // $fieldsQuery->when($this->searchCity, function ($query) {
        //     $query->where('city_id', $this->searchCity);
        // });

        // Ambil hasil dengan paginasi
        $fields = $fieldsQuery->paginate(9);

        return view('livewire.lapangan.index', [
            'fields' => $fields,
            'categories' => $categories,
        ]);
    }
}
