<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Order_transport_history extends Model
{
    protected $table = "order_transport_histories";
    protected $fillable = ['id','order_id','datetime','job_no','user_id','status','created_at','updated_at'];

    public function user_order_transport_history()
    {
        return $this->belongsTo('warehouse\User','user_id');
    }

    public function statusHistoryName()
    {
        return $this->belongsTo('warehouse\Models\Transports_orders_statused','status');
    }

    public static function ubahAtauBuatBaru(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }

     public static function insertUpdates(array $attributes = [])
    {
        $model = new static($attributes);

        $model->fill($attributes);

        if ($model->usesTimestamps()) {
            $model->updateTimestamps();
        }

        $attributes = $model->getAttributes();

        $query = $model->newBaseQueryBuilder();
        $processor = $query->getProcessor();
        $grammar = $query->getGrammar();

        $table = $grammar->wrapTable($model->getTable());
        $keyName = $model->getKeyName();
        $columns = $grammar->columnize(array_keys($attributes));
        $insertValues = $grammar->parameterize($attributes);

        $updateValues = [];

        if ($model->primaryKey !== null) {
            $updateValues[] = "{$grammar->wrap($keyName)} = LAST_INSERT_ID({$keyName})";
        }

        foreach ($attributes as $k => $v) {
            $updateValues[] = sprintf("%s = '%s'", $grammar->wrap($k), $v);
        }

        $updateValues = join(',', $updateValues);

        $sql = "insert into {$table} ({$columns}) values ({$insertValues}) on duplicate key update {$updateValues}";

        $id = $processor->processInsertGetId($query, $sql, array_values($attributes));

        $model->setAttribute($keyName, $id);

        return $model;
    }

    public static function ChangeDataStatus(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }

}
