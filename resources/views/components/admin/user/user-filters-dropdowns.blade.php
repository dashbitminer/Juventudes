@props(['socioImplementadores', 'roles'])

<div>
    <label for="filter1" class="block text-sm font-medium text-gray-700">Socio Implementador</label>
    <flux:select variant="listbox" multiple  clear="close" selected-suffix="seleccionados"
        id="pais" name="pais"  wire:model.live='filters.socioImplementadorSelected'
        placeholder="Seleccione" class="text-indigo-900 border-indigo-500 focus:ring-indigo-500">
        @foreach ($socioImplementadores as $key => $value)
            <flux:option value="{{ $key }}">{{ $value }}</flux:option>
        @endforeach
    </flux:select>
</div>
<div>
    <label for="filter2" class="block text-sm font-medium text-gray-700">Rol</label>
    <flux:select variant="listbox" multiple  clear="close" selected-suffix="seleccionados"
        id="filter3" name="filter2"  wire:model.live='filters.rolSelected'
        placeholder="Seleccione" class="text-indigo-900 border-indigo-500 focus:ring-indigo-500">
        @foreach ($roles as $key => $value)
            <flux:option value="{{ $key }}">{{ $value }}</flux:option>
        @endforeach
    </flux:select>
</div>
