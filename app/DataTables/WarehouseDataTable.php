<?php

namespace warehouse\DataTables;

use warehouse\Models\Warehouse;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class WarehouseDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        // return datatables()
        //     ->eloquent($query)
        //     ->addColumn('action', 'warehouse.action');

            $model = Warehouse_order::with('customers_warehouse','sub_service.remarks');
            // ->select('customers_warehouse.*','sub_service.*','sub_service.remarks.*');
  
            return DataTable::eloquent($model)
            ->addColumn('customers_warehouse', function (Warehouse_order $Warehouse_order) {
                return $Warehouse_order->customers_warehouse->name;
            })
            ->toJson();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \warehouse\Models\Warehouse $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Warehouse $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('warehouse-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('Bfrtip')
                    ->orderBy(1);
                    // ->buttons(
                    //     Button::make('create'),
                    //     Button::make('export'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload')
                    // );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            // Column::make('id'),
            // Column::make('add your columns'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            'id',
            'order_id',
            'customer',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Warehouse_' . date('YmdHis');
    }
}
