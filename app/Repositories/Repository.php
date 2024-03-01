<?php

namespace App\Repositories;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin Builder
 */
abstract class Repository
{
    use ForwardsCalls;

    protected Builder $query;

    public function __construct(
        private readonly Model|BaseModel $model
    ) {
        $this->reset();
    }

    public function model(): Model|BaseModel
    {
        return $this->model;
    }

    public function query(): Builder
    {
        return $this->query;
    }

    protected function reset(): self
    {
        $this->query = $this->model()->newQuery();

        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        if (! method_exists($this, $name)) {
            return $this->forwardCallTo($this->query(), $name, $arguments);
        }

        return $this->{$name}(...$arguments);
    }

    public function save(Model $model, array $data)
    {
        return tap($model->fill($data), fn (Model $model) => $model->save());
    }
}
