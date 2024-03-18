<?php

namespace App\Dto;

use Illuminate\Http\Request;

/** @codeCoverageIgnore */
class Pagination
{
    public function __construct(
        public readonly string $pageName = 'page',
        public readonly int $perPage = 15,
        public readonly int $page = 1,
        public readonly string $order = 'id',
        public readonly string $direction = 'asc',
    ) {
    }

    public static function from(Request $request): Pagination
    {
        return new self(
            pageName: $request->query('pageName', 'page'),
            perPage: $request->query('perPage', 15),
            page: $request->query('page', 1),
            order: $request->query('order', 'id'),
            direction: $request->query('direction', 'asc'),
        );
    }
}
