<x-admin-layout
    title="Roles | MediCare" 
    :breadcrumb="[
       [ 'name'=>'Dashboard',
        'route'=> route('admin.dashboard'),
        ],
        [
            'name'=>'Roles',
            'route'=> route('admin.roles.index'),
        ],
        [
            'name' => 'Crear',
],
    ]">

</x-admin-layout>