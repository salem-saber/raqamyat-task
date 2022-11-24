<?php

namespace PaymentApp\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Repository
{
    /**
     * @var mixed
     */
    private mixed $model;

    /**
     * @param $data
     * @return ?Model
     */
    public function create($data):?Model
    {
        $created = $this->getModel()->create($data);
        if ($created)
            return $created;
        return null;
    }

    public function findWhere(array $where):?Model
    {
        return $this->getModel()->where($where)->first() ?? null;
    }

    public function firstOrCreate(array $unique, $data):?Model
    {
        return $this->getModel()->where($unique)->firstOrCreate($data);

    }

    public function exists(array $where):bool
    {
        return $this->getModel()->where($where)->exists();
    }
    /**
     * @param $unique
     * @param $data
     * @return ?Model
     */
    public function updateOrCreate($unique, $data):?Model
    {
        $created = $this->getModel()->updateOrCreate($unique,$data);
        if ($created) {
            return $created;
        }
        return null;
    }

    /**
     * @param $id
     * @return null
     */
    public function find($id)
    {
        $record = $this->getModel()->find($id);
        if (!$record)
            return null;
        return $record;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $record = $this->getModel()->find($id);
        if (!$record)
            return false;

        return $record->delete();
    }

    /**
     * @param $ids
     * @return bool
     */
    public function deleteIn($ids): bool
    {
        $record = $this->getModel()->whereIn('id', $ids);
        if (!$record)
            return false;
        return $record->delete();
    }

    /**
     * @param $column
     * @param $id
     * @return bool
     */
    public function deleteWhere($column, $id): bool
    {
        $record = $this->getModel()->where($column, $id);
        if (!$record)
            return false;
        return $record->delete();
    }

    /**
     * @param $id
     * @param $data
     * @return ?Model
     */
    public function update($id, $data):?Model
    {
        $update = $this->getModel()->find($id)?->update($data) ?: null;
        if (!$update)
            return null;
        return $this->getModel()->find($id);
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }


    /**
     * @return void
     */
    public static function startTransaction(): void
    {
        DB::beginTransaction();
    }

    /**
     * @return void
     */
    public static function commitTransaction(): void
    {
        DB::commit();
    }

    /**
     * @return void
     */
    public static function rollbackTransaction(): void
    {
        DB::rollBack();
    }
}
