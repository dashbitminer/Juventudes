@props(['gestores'])

<div>
    <label for="filter1" class="block text-sm font-medium text-gray-700">Gestor</label>
    <flux:select variant="listbox" multiple  clear="close" selected-suffix="seleccionados"
        id="gestor" name="gestor"  wire:model.live='filters.gestorSelected'
        placeholder="Seleccione" class="text-indigo-900 border-indigo-500 focus:ring-indigo-500">
        @foreach ($gestores as $key => $value)
            <flux:option value="{{ $key }}">{{ $value }}</flux:option>
        @endforeach
    </flux:select>
</div>