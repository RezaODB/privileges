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
                serif: ['Libre Baskerville', ...defaultTheme.fontFamily.serif],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        blockquote: {
                            quotes: "none",
                            padding: "1rem 0",
                            "border-top": "1px solid black",
                            "border-bottom": "1px solid black",
                            "border-left": "none",
                            "font-size": "1.5rem",
                            "line-height": 1.5,
                            "text-transform": "uppercase",
                            "font-family": "font-serif"
                        },
                        "blockquote strong": {
                            "font-size": "2rem",
                            "line-height": 1,
                        }
                    },
                },
            },
        },
    },
    plugins: [forms, typo],
};


