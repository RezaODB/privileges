import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typo from '@tailwindcss/typography';

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
                sans: ['Mulish', ...defaultTheme.fontFamily.sans],
                serif: ['Young Serif', ...defaultTheme.fontFamily.serif],
                title: ['Bebas Neue', ...defaultTheme.fontFamily.sans],
                mono: ['Courier Prime', ...defaultTheme.fontFamily.mono],
            },
        },
    },

    plugins: [forms, typo],
};


