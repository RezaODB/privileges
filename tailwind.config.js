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
            colors: {
                // What the sheet *looks* like once its texture is multiplied over
                // it — for anything opaque laid on top, such as a sticky table
                // head. The base tone it is built from lives in .sheet.
                paper: '#ece1c9',
                folder: '#e5d0b5',
            },
            fontFamily: {
                mono: ['Courier Prime', ...defaultTheme.fontFamily.mono],
                serif: ['Libre Baskerville', ...defaultTheme.fontFamily.serif],
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


