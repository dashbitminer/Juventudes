
@props(['form', 'disabled' => false])

<div class="sm:col-span-3">
    <x-input-label for="form.calle">{{ __('Calle') }}
        <x-required-label />
    </x-input-label>
    <div class="mt-2">
        <x-text-input wire:model="form.calle" id="form.calle"
            disabled="{{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}" name="form.calle"
            type="text"
            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
            $form->readonly || ($disabled ?? false),
            'block w-full mt-1','border-2 border-red-500' =>
            $errors->has('form.calle')])
            />
            <x-input-error :messages="$errors->get('form.calle')" class="mt-2"
                aria-live="assertive" />
    </div>
</div>

<div class="sm:col-span-3">
    <x-input-label for="ciudad">{{ __('Sector') }}
    </x-input-label>
    <div class="mt-2">
        <x-text-input wire:model="form.sector" id="form.sector"
            disabled="{{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}" name="form.sector"
            type="text"
            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
            $form->readonly || ($disabled ?? false),
            'block w-full mt-1','border-2 border-red-500' =>
            $errors->has('form.sector')])
        />
        <x-input-error :messages="$errors->get('form.sector')" class="mt-2"
            aria-live="assertive" />
    </div>
</div>

<div class="sm:col-span-3">
    <x-input-label for="departamentoSelected">{{ __('Bloque') }}
    </x-input-label>
    <div class="mt-2">
        <x-text-input wire:model="form.bloque" id="form.bloque"
            disabled="{{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}" name="form.bloque"
            type="text"
            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
            $form->readonly || ($disabled ?? false),
            'block w-full mt-1','border-2 border-red-500' =>
            $errors->has('form.bloque')])
        />
        <x-input-error :messages="$errors->get('form.bloque')" class="mt-2"
            aria-live="assertive" />
    </div>
</div>

<div class="sm:col-span-3">
    <x-input-label for="ciudad">{{ __('Casa') }}
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
