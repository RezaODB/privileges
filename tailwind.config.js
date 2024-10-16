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
                            "font-size": "1.8rem",
                            "line-height": 1.2,
                            "text-align": "right",
                            "color": "#374151",
                            "font-weight": 400,
                            "text-transform": "uppercase",
                            "font-family": "Inter"
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


