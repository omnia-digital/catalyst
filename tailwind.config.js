const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    darkMode: 'media',
    theme: {
        extend: {
            fontFamily: {
                sans: ["Roboto","-apple-system", "BlinkMacSystemFont", "Segoe UI", "Helvetica", "Arial", "sans-serif", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                rose: colors.rose,
            },
        },
    },

    variants: {
        extend: {
            textOpacity: ['dark']
        }
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')],
};
