<?php

namespace App\DataTables;

use App\Models\prasence;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class prasencesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<prasence> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('tgl', function($query){
                return date('d F Y', strtotime($query->tgl_kegiatan));
            })
            ->addColumn('waktu_mulai', function($query){
                return date('H:i', strtotime($query->tgl_kegiatan));
            })
            ->addColumn('action', function($query){
                $btnDetail = "<a href='".route('prasence.show',$query->id)."' class='btn btn-secondary mx-1'>Detail</a>";
                $btnEdit = "<a href='".route('prasence.edit',$query->id)."' class='btn btn-warning mx-1'>Edit</a>";
                $btnDelete = "<a href='".route('prasence.destroy',$query->id)."' class='btn btn-danger btn-delete mx-1'>Hapus</a>";

                return "{$btnDetail} {$btnEdit} {$btnDelete}";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<prasence>
     */
    public function query(prasence $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', auth()->user()->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('prasences-table')
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
            Column::make('nama_kegiatan'),
            Column::make('tgl'),
            Column::make('waktu_mulai'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(250)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'prasences_' . date('YmdHis');
    }
}
