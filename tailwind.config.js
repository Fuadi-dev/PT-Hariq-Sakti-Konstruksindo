import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    orange: '#E65100',
                    accent: '#F97316',
                    dark: '#121417',
                    surface: '#1A1D21',
                    muted: '#6B7280',
                    light: '#F8F9FA',
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', 'sans-serif'],
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-50%)' },
                }
            },
            animation: {
                marquee: 'marquee 25s linear infinite',
            },
        },
    },

    plugins: [forms],
};
