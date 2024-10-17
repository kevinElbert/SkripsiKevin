import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                // Extending Tailwind's default sans-serif with 'Figtree' and 'Nunito'
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                nunito: ['Nunito', 'sans-serif'],
            },
            keyframes: {
                // Adding a custom fade-in keyframe animation
                fadeIn: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
            },
            animation: {
                // Assigning the custom fade-in animation to a class
                'fade-in': 'fadeIn 1s ease-in-out forwards',
            },
        },
    },
    plugins: [forms], // Using Tailwind's official forms plugin for better form element styling
};
