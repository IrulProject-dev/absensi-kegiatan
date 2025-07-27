<?php

namespace App\DataTables;

use App\Models\prasenceDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Storage;

class AbsenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<prasenceDetail> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('waktu_absen', function($query){
                return date('Y-m-d H:i', strtotime($query->created_at));
            })
            ->addColumn('tanda_tangan', function($query){
                return "<img src='".asset('uploads/' . $query->tanda_tangan)."' width='75px'>";
            })
            ->rawColumns(['tanda_tangan'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<prasenceDetail>
     */
    public function query(prasenceDetail $model): QueryBuilder
    {
        return $model->where('prasence_id', $this->prasence_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('absens-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0) //order by waktu absen
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('#')
                ->render('meta.row + meta.settings._iDisplayStart + 1 ')
                ->width(100),
            Column::make('waktu_absen'),
            Column::make('name'),
            Column::make('jabatan'),
            Column::make('asal_instansi'),
            Column::make('tanda_tangan'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Absen_' . date('YmdHis');
    }
}
