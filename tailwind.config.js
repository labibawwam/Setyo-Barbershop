import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.php',
    ],
    safelist: [
        // Kelas yang dipanggil dinamis dari JS / custom names untuk menghindari purge
        'active',
        'item-selected',
        'toast-fade-out',
        { pattern: /bg-(amber|indigo|white|gray|red|green)-?\d*/ },
        { pattern: /text-(amber|indigo|white|gray|red|green)-?\d*/ },
        { pattern: /scale-\d+/ },
        { pattern: /rounded.*/ },
        { pattern: /w-\d+/ },
        { pattern: /h-\d+/ },
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
