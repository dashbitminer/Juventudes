<div>
    <!-- Success Indicator... -->
    <x-notifications.success-text-notification message="Successfully saved!" />

    <!-- Error Indicator... -->
    <x-notifications.error-text-notification message="Han habido errores en el formulario" />

    <!-- Success Alert... -->
    <x-notifications.alert-success-notification>
        <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
        <p class="mt-1 text-sm text-gray-500">El registro fue guardado exitosamente y los cambios aparecerán en la ficha de registro.</p>
    </x-notifications.alert-success-notification>

    <!-- Error Alert... -->
    <x-notifications.alert-error-notification>
      <p class="text-sm font-medium text-red-900">¡Errores en el formulario!</p>
      <p class="mt-1 text-sm text-gray-500">Han habido problemas para guardar los cambios, corrija cualquier error en el formulario e intente nuevamente.</p>
    </x-notifications.alert-error-notification>
</div>
