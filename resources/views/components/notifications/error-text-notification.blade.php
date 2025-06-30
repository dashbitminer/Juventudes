<div x-show="$wire.form.showValidationErrorIndicator" x-transition.out.opacity.duration.2000ms
    x-effect="if($wire.form.showValidationErrorIndicator) setTimeout(() => $wire.form.showValidationErrorIndicator = false, 3000)"
    class="flex justify-end pt-4" aria-live="polite">
    <div class="flex items-center gap-2 text-sm font-medium text-red-500">
       {{ $message }}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </div>
</div>
