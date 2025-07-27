<?php

namespace App\DataTables;

use App\Models\prasenceDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Storage;

class prasenceDetailsDataTable extends DataTable
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
            ->addColumn('action', function($query){
                $btnDelete = "<a href='".route('prasence-detail.destroy',$query->id)."' class='btn btn-danger btn-delete mx-1'>Hapus</a>";

                return "{$btnDelete}";
            })
            ->rawColumns(['tanda_tangan', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<prasenceDetail>
     */
    public function query(prasenceDetail $model): QueryBuilder
    {
        return $model->with('prasence')->where('prasence_id', request()->segment(2))->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('prasencedetails-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
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
            Column::make('created_at')->title('Waktu Absen')->data('waktu_absen'),
            Column::make('name')->title('Nama'),
            Column::make('jabatan'),
            Column::make('asal_instansi'),
            Column::make('tanda_tangan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'prasenceDetails_' . date('YmdHis');
    }
}
