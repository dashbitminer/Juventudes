
@props(['form', 'disabled' => false])

<div class="sm:col-span-2">
    <x-input-label for="form.apartamento">{{ __('Apartamento') }}
    </x-input-label>
    <div class="mt-2">
        <x-text-input wire:model="form.apartamento" id="form.apartamento"
            disabled="{{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}" name="form.apartamento"
            type="text"
            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
            $form->readonly || ($disabled ?? false),
            'block w-full mt-1','border-2 border-red-500' =>
            $errors->has('form.apartamento')])
        />
        <x-input-error :messages="$errors->get('form.apartamento')" class="mt-2"
            aria-live="assertive" />
    </div>
</div>

<div class="sm:col-span-2">
    <x-input-label for="form.casa">{{ __('Casa') }} {{ $disabled }}
    </x-input-label>
    <div class="mt-2">
        <x-text-input wire:model="form.casa" id="form.casa"
            disabled="{{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}" name="form.casa"
            type="text"
            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
            $form->readonly || ($disabled ?? false),
            'block w-full mt-1','border-2 border-red-500' =>
            $errors->has('form.casa')])
        />
        <x-input-error :messages="$errors->get('form.casa')" class="mt-2"
            aria-live="assertive" />
    </div>
</div>

<div class="sm:col-span-2">
    <x-input-label for="form.zona">{{ __('Zona') }}
    </x-input-label>
    <div class="mt-2">
        <x-text-input wire:model="form.zona" id="form.zona"
            disabled="{{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}" name="form.zona"
            type="text"
            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
            $form->readonly ||($disabled ?? false),
            'block w-full mt-1','border-2 border-red-500' =>
            $errors->has('form.zona')])
        />
        <x-input-error :messages="$errors->get('form.zona')" class="mt-2"
            aria-live="assertive" />
    </div>
</div>
