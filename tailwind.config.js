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
                mono: ['Courier Prime', ...defaultTheme.fontFamily.mono],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        'li::marker': {
                            color: '#27272a' 
                        }
                    },
                },
            },
        },
    },
    plugins: [forms, typo],
};


