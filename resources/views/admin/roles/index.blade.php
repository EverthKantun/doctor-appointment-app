<x-admin-layout
    title="Roles | MediCare" 
    :breadcrumbs="[
       [ 'name'=>'Dashboard',
        'route'=> route('admin.dashboard'),
        ],
        [
            'name'=>'Roles',
             'route'=> route('admin.roles.index'),
        ],
               [
            'name' => 'Nuevo',
                ],
    ]">
    @livewire('admin.datatables.role-table')
</x-admin-layout>