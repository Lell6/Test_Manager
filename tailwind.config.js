import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        './resources/js/**/*.js',
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
        './resources/js/**/*.ts',
    
        './resources/js/**/*.vue',
    
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
    
        './resources/js/**/*.alpine.js',
    
        './resources/views/**/*.html',
        './public/**/*.html',
        './storage/framework/views/*.php',

        './public/js/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
