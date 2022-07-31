const plugin = require('tailwindcss/plugin');
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
        './vendor/filament/**/*.blade.php',
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
                sans: ["SF Pro Display", "Helvetica", "Roboto", "-apple-system", "BlinkMacSystemFont", "Segoe UI", "Arial", "sans-serif", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'dot': '.15rem',
                '2xs': '0.65rem',
                '3xs': '0.55rem',
                'base': '0.9375rem',
            },
            height: {
                '13': '3.2rem',
                'full-with-nav': 'calc(100vh - 56px)'
            },
            maxWidth: {
                'sm': '22rem',
                '2xl': '40rem',
                '8xl': '82rem',
                '9xl': '90rem',
                'post-card-max-w': '680px'
            },
            colors: {
                'base-text-color': 'var(--base-text-color)',
                'white-text-color': 'var(--white-text-color)',
                'light-text-color': 'var(--light-text-color)',
                'dark-text-color': 'var(--dark-text-color)',
                neutral: 'var(--neutral)',
                'neutral-light': 'var(--neutral-light)',
                'neutral-dark': 'var(--neutral-dark)',
                'neutral-dark\/75': 'var(--neutral-dark-75)',
                'neutral-hover': 'var(--neutral-hover)',
                primary: 'var(--primary)',
                secondary: 'var(--secondary)',
                tertiary: 'var(--tertiary)',
                danger: colors.rose,
                success: colors.green,
                warning: colors.yellow,
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
        plugin(function({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'h-full-minus': (value) => {
                        return {
                            height: 'calc(100vh - ' + value + ')',
                        }
                    },
                    'max-h-full-minus': (value) => {
                        return {
                            maxHeight: 'calc(100vh - ' + value + ')',
                        }
                    },
                },
            )
        }),
    ]
};
