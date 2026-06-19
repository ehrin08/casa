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
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                spa: {
                    charcoal: '#171514',
                    gray: '#2a2926',
                    espresso: '#4a2f22',
                    brown: '#7a4f35',
                    wood: '#b8875b',
                    gold: '#d6a85f',
                    leaf: '#3f6f4e',
                    sage: '#7f9b80',
                    cream: '#f7f1e8',
                    beige: '#e8d8c3',
                    white: '#fffaf3',
                }
            }
        },
    },

    plugins: [forms],
};
