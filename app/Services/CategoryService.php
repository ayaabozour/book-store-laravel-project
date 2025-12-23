<?php

namespace App\Services;

use App\Models\Category;


class CategoryService{
    public function paginate(int $perPage = 10){
        return Category::withCount('books')->latest()->paginate($perPage);
    }

    public function create(array $data):Category{
        return Category::create($data);
    }
}
