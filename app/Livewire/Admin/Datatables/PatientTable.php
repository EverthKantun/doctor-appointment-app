<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;

class PatientTable extends DataTableComponent
{
    //protected $model = Patient::class;
public function builder(): Builder
{
    return Patient::query()
        ->select('patients.*') // 🔑 CLAVE
        ->with('user');
}


    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

public function columns(): array
{
    return [

        Column::make("Id", "id")
            ->sortable(),

        Column::make("Nombre")
            ->label(function ($row) {
                return $row->user?->name ?? 'N/A';
            }),

        Column::make("Email")
            ->label(function ($row) {
                return $row->user?->email ?? 'N/A';
            }),

        Column::make("Número de id")
            ->label(function ($row) {
                return $row->user?->id_number ?? 'N/A';
            }),

        Column::make("Teléfono")
            ->label(function ($row) {
                return $row->user?->phone ?? 'N/A';
            }),

        Column::make("Fecha de creación", "created_at")
            ->sortable()
            ->label(function ($row) {
                return $row->created_at
                    ? $row->created_at->format('d/m/Y')
                    : 'N/A';
            }),

        Column::make("Acciones")
            ->label(function ($row) {
                return view('admin.patients.actions', [
                    'patient' => $row
                ]);
            }),
    ];
}

}
