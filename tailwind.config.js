const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './vendor/omnia-digital/library/resources/views/**/*.blade.php',
        './vendor/omnia-digital/library/resources/js/**/*.js',
        './vendor/phuclh/media-manager/resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './Modules/*/Resources/views/**/*.blade.php',
    ],

    darkMode: 'class',
    theme: {
        themeVariants: [
            'default',
            'dark',
            'newyear',
            'valentines',
            'patrick',
            'easter',
            'spring',
            'summer',
            'independence',
            'fall',
            'halloween',
            'christmas',
            'winter'],
        extend: {
            fontFamily: {
                sans: ["Roboto", "-apple-system", "BlinkMacSystemFont", "Segoe UI", "Helvetica", "Arial", "sans-serif", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'xxs': '0.65rem',
                'sm': '0.95rem'
            },
            colors: {
                'text-base': 'var(--text)',
                'text-light': 'var(--text-light)',
                'text-dark': 'var(--text-dark)',
                neutral: 'var(--neutral)',
                'neutral-dark': 'var(--neutral-dark)',
                'neutral-hover': 'var(--neutral-hover)',
                primary: 'var(--primary)',
                secondary: 'var(--secondary)',
                tertiary: 'var(--tertiary)'
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
        require('@tailwindcss/typography'),
        require('tailwindcss-multi-theme'),
        require('@tailwindcss/aspect-ratio'),
        require('tailwind-scrollbar-hide'),
        require('@tailwindcss/line-clamp'),
    ]
};
