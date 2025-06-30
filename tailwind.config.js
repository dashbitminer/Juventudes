import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import colors from "tailwindcss/colors";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: null,
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/livewire/flux-pro/stubs/**/*.blade.php",
        "./vendor/livewire/flux/stubs/**/*.blade.php",
    ],
    safelist: [
        "bg-sky-100",
        "bg-yellow-100",
        "bg-orange-100",
        "bg-red-100",
        "bg-purple-100",
        "bg-green-100",
        "bg-gray-100",
        "bg-indigo-100",
        "text-sky-600",
        "text-yellow-600",
        "text-orange-600",
        "text-red-600",
        "text-purple-600",
        "text-green-600",
        "text-gray-600",
        "text-sky-400",
        "border-yellow-400",
        "border-red-400",
        "border-orange-400",
        "border-green-400",
        "border-gray-400",
        "border-purple-400",
        "border-sky-400",
        "hover:border-red-400",
        "hover:border-green-400",
        "hover:border-gray-400",
        "hover:border-purple-400",
        "hover:border-orange-400",
        "hover:border-yellow-400",
        "hover:border-sky-400",
        "text-teal-600",
        "bg-teal-100",
        "text-amber-600",
        "bg-amber-100",
        "text-fuchsia-600",
        "bg-fuchsia-100",
        "text-purple-600",
        "bg-purple-100",
        "text-cyan-600",
        "bg-cyan-600",
        "bg-green-600",
        "text-green-800",
        "bg-blue-600",
        "text-blue-800",
        "bg-yellow-600",
        "text-yellow-800",
        "bg-red-600",
        "text-red-800",
        "bg-indigo-600",
        "text-indigo-800",
        "bg-pink-600",
        "text-pink-800",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                "8xl": "96rem",
            },
            colors: {
                // Re-assign Flux's gray of choice...
                zinc: colors.slate,

                // Accent variables are defined in resources/css/app.css...
                accent: {
                    DEFAULT: "var(--color-accent)",
                    content: "var(--color-accent-content)",
                    foreground: "var(--color-accent-foreground)",
                },
            },
        },
    },

    plugins: [forms],
};
