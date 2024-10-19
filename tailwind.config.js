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
                serif: ['Tinos', ...defaultTheme.fontFamily.serif],
                sans: ['Mulish', ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        blockquote: {
                            quotes: "none",
                            padding: "1rem 0",
                            "font-size": "1.5rem",
                            "line-height": 1.2,
                            "font-style": "normal",
                            "border-top": "1px solid black",
                            "border-bottom": "1px solid black",
                            "border-left": "none",
                        },
                        "blockquote strong": {
                            "font-size": "2.2rem",
                            "line-height": 0,
                        }
                    },
                },
            },
        },
    },
    plugins: [forms, typo],
};


