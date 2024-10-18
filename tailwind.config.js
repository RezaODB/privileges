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
                            padding: "1rem",
                            "border-left": "none",
                            background: "white"
                        },
                        "blockquote strong": {
                            "font-size": "2rem",
                            "line-height": 1,
                            "font-family": "font-serif"
                        }
                    },
                },
            },
        },
    },
    plugins: [forms, typo],
};


