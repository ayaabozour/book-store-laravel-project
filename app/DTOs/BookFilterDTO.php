<?php

namespace App\DTOs;

class BookFilterDTO{

    public function __construct(
    public readonly ?string $search = null,
    public readonly ?string $categoryId = null,
    public readonly ?string $author = null,
    public readonly int $perPage = 10)
    {}

    public static function fromRequest($request): self{
        return new self(
            search: $request->query('search'),
            categoryId: $request->query('category_id'),
            author: $request->query('author'),
            perPage:(int) $request->query('per_page',10),
        );
    }
}
