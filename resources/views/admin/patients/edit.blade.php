{{-- lógiva de PHP para manejar errores y controlar la pestaña activa --}}

@php
    // definimos qué campos pertenecen a cada pestaña
    $errorGroups = [
        'antecedentes' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
        'información-general' => ['blood_type_id', 'observations'],
        'contacto-emergencia' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
    ];


    //Pestaña por datecto
    $initialTab= 'datos-personales';

    //Cargar automáticamente el error
    foreach ($errorGroups as $tabName => $fields) {
        if ($errors->hasAny($fields)) {
            $initialTab = $tabName;
            break;
        }
    }
@endphp
<x-admin-layout
    title="Pacientes | MediCare"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
            'href' => route('admin.patients.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ]">
<form action="{{ route('admin.patients.update', $patient) }}" method="POST">
    @csrf
    @method('PUT')
            {{-- Encabezado con foto y acciones--}}
    <x-wire-card class="ml-8">
        <div class="lg:flex lg:justify-between lg:items-center">

            <div class="flex items-center">
                <img 
                    src="{{ $patient->user->profile_photo_url }}" 
                    alt="{{ $patient->user->name }}"
                    class="h-20 w-20 rounded-full object-cover object-center"
                >
                <div>
                    <p class="text-2xl font-bold text-gray-900 ml-4">
                        {{ $patient->user->name }}
                    </p>
                </div>
            </div>

            <div class="flex space-x-3 mt-6 lg:mt-0">
                <x-wire-button 
                    outline 
                    gray 
                    href="{{ route('admin.patients.index') }}"
                >
                    Volver
                </x-wire-button>
                <x-wire-button 
                    type="submit">
                        <i class="fa-solid fa-check"></i>
                    Guardar cambios
                </x-wire-button>
            </div>
        </div>
    </x-wire-card>

{{--tabs de navegación--}}
<x-wire-card>
    <div x-data="{tab: '{{ $initialTab }}' }">
       <!--Menú de pestañas--> 
<div class="border-b border-gray-200">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
        <!-- tab 1: Datos personales -->
        <li class="me-2">
            <a href="#" x-on:click.prevent="tab = 'datos personales'"
            :class="{
            'text-blue-600 border-blue-600 active': tab === 'datos personales',
            'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'datos personales'
            }"
            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
            :aria-current="tab === 'datos personales' ? 'page' : undefined">
            <i class="fa-solid fa-user me-2"></i>    
            Datos personales
            </a>
        </li>

        <!-- tab 2: Antecedentes -->
        @php $hasError = $errors->hasAny($errorGroups['antecedentes']);
        @endphp
        <li class="me-2">
            <a href="#" x-on:click.prevent="tab = 'antecedentes'"
            :class="{
            'text-red-600 border-red-600': tab !== 'antecedentes'
                && {{ $hasError ? 'true' : 'false' }} ,
            'text-blue-600 border-blue-600 active': tab === 'antecedentes' 
                && !{{ $hasError ? 'true' : 'false' }},
            'text-red-600 border-red-600 active': tab === 'antecedentes' 
                && {{ $hasError ? 'true' : 'false' }},
            'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'antecedentes'
                && !{{ $hasError ? 'true' : 'false' }}
            }"
            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200
            {{ $hasError ? 'text-red-600 border-red-600' : '' }} "
            :aria-current="tab === 'antecedentes' ? 'page' : undefined">
            <i class="fa-solid fa-file-lines me-2"></i>    
            Antecedentes
            @if ($hasError)
                <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
            @endif
            </a>
        </li>

        <!-- tab 3: Información general -->
        @php $hasError = $errors->hasAny($errorGroups['información-general']);
        @endphp
        <li class="me-2">
            <a href="#" x-on:click.prevent="tab = 'información-general'"
            :class="{
            'text-red-600 border-red-600': tab !== 'información-general'
                && {{ $hasError ? 'true' : 'false' }} ,
            'text-blue-600 border-blue-600 active': tab === 'información-general' 
                && !{{ $hasError ? 'true' : 'false' }},
            'text-red-600 border-red-600 active': tab === 'información-general' 
                && {{ $hasError ? 'true' : 'false' }},
            'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'información-general'
                && !{{ $hasError ? 'true' : 'false' }}
            }"
            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200
            {{ $hasError ? 'text-red-600 border-red-600' : '' }} "
            :aria-current="tab === 'información-general' ? 'page' : undefined">
            <i class="fa-solid fa-info me-2"></i>    
            Información general
            @if ($hasError)
                <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
            @endif
            </a>
        </li>

        <!-- tab 4: Contacto de emergencia -->
         @php $hasError = $errors->hasAny($errorGroups['contacto-emergencia']);
        @endphp
        <li class="me-2">
            <a href="#" x-on:click.prevent="tab = 'contacto-emergencia'"
            :class="{
            'text-red-600 border-red-600': tab !== 'contacto-emergencia'
                && {{ $hasError ? 'true' : 'false' }} ,
            'text-blue-600 border-blue-600 active': tab === 'contacto-emergencia'
                && !{{ $hasError ? 'true' : 'false' }},
            'text-red-600 border-red-600 active': tab === 'contacto-emergencia'
                && {{ $hasError ? 'true' : 'false' }},
            'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'contacto-emergencia'
                && !{{ $hasError ? 'true' : 'false' }}
            }"
            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200
            {{ $hasError ? 'text-red-600 border-red-600' : '' }} "
            :aria-current="tab === 'contacto-emergencia' ? 'page' : undefined">
            <i class="fa-solid fa-heart me-2"></i>    
            Contacto de emergencia
            @if ($hasError)
                <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
            @endif
            </a>
        </li>
    </ul>
</div>
{{-- Contenido de los tabs --}}
<div class="px-4 mt-4">
    {{-- Tab 1: Datos Personales --}}
    <div x-show="tab === 'datos personales'">
        {{-- Alert de edición de usuario --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <div class="flex jflex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Lado Izquierdo: Información --}}
                <div class="flex item-start">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-5"></i>
                    </div>
                                            <div class="ml-3">
                            <h3 class="text-blue-800 font-bold">Edición de usuario</h3>
                                <div class="mt-1 text-sm text-blue-600">
                                    <p class="text-sm text-blue-700 mt-1">
                                        La información de acceso (nombre, email y contraseña) debe gestionarse desde la cuenta de usuario asociada.
                                    </p>
                                </div>
                        </div>
                </div>
                {{-- Lado Derecho: Botón --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.users.edit', $patient->user) }}"
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Editar usuario
                        <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Grid de datos personales (solo lectura) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <label class="text-gray-500 font-semibold text-sm">Teléfono</label>
                <p class="text-gray-900">{{ $patient->user->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-gray-500 font-semibold text-sm">Email</label>
                <p class="text-gray-900">{{ $patient->user->email ?? 'N/A' }}</p>
            </div>
            <div class="lg:col-span-2">
                <label class="text-gray-500 font-semibold text-sm">Dirección</label>
                <p class="text-gray-900">{{ $patient->user->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- Tab 2: Antecedentes --}}
    <div x-show="tab === 'antecedentes'">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-wire-textarea
                name="allergies"
                label="Alergias"
                :value="old('allergies', $patient->allergies)"
                rows="4" />

            <x-wire-textarea
                name="chronic_conditions"
                label="Enfermedades Crónicas"
                :value="old('chronic_conditions', $patient->chronic_conditions)"
                rows="4" />

            <x-wire-textarea
                name="surgical_history"
                label="Antecedentes Quirúrgicos"
                :value="old('surgical_history', $patient->surgical_history)"
                rows="4" />

            <x-wire-textarea
                name="family_history"
                label="Antecedentes Familiares"
                :value="old('family_history', $patient->family_history)"
                rows="4" />
        </div>
    </div>

    {{-- Tab 3: Información General --}}
    <div x-show="tab === 'información-general'">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <x-wire-native-select name="blood_type_id" label="Tipo de Sangre">
                    <option value="">Selecciona un tipo de sangre</option>
                    @foreach ($bloodTypes as $bloodType)
                        <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                            {{ $bloodType->type }}
                        </option>
                    @endforeach
                </x-wire-native-select>
            </div>

            <div class="lg:col-span-2">
                <x-wire-textarea
                    name="observations"
                    label="Observaciones"
                    :value="old('observations', $patient->observations)"
                    rows="4" />
            </div>
        </div>
    </div>

    {{-- Tab 4: Contacto de Emergencia --}}
    <div x-show="tab === 'contacto-emergencia'">
        <div class="space-y-4">
            <x-wire-input
                name="emergency_contact_name"
                label="Nombre de contacto"
                :value="old('emergency_contact_name', $patient->emergency_contact_name)" />

            <x-wire-phone
                name="emergency_contact_phone"
                mask="(###) ###-####"
                placeholder="(999) 999-9999"
                label="Teléfono de contacto"
                :value="old('emergency_contact_phone', $patient->emergency_contact_phone)" />

            <x-wire-input
                name="emergency_contact_relationship"
                placeholder="Parentesco"
                label="Relación con el contacto"
                :value="old('emergency_contact_relationship', $patient->emergency_contact_relationship)" />
        </div>
    </div>
</div>

</x-wire-card>


</form>

</x-admin-layout>
