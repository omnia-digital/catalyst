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
        './src/**/*.{html,js}',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],

    darkMode: 'class',
    theme: {
        themeVariants: [
            'default',
            'dark',
            'hatchet',
            'cfanea',
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
            'winter'
        ],
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
                neutral: {
                    DEFAULT: 'var(--neutral)',
                    'light': 'var(--neutral-light)',
                    'dark': 'var(--neutral-dark)',
                    'hover': 'var(--neutral-hover)',
                },
                primary: {
                    DEFAULT: 'var(--primary)',
                    "50": "var(--primary-50)",
                    "100": "var(--primary-100)",
                    "200": "var(--primary-200)",
                    "300": "var(--primary-300)",
                    "400": "var(--primary-400)",
                    "500": "var(--primary-500)",
                    "600": "var(--primary-600)",
                    "700": "var(--primary-700)",
                    "800": "var(--primary-800)",
                    "900": "var(--primary-900)"
                },
                secondary: {
                    DEFAULT: 'var(--secondary)',
                    "50": "var(--secondary-50)",
                    "100": "var(--secondary-100)",
                    "200": "var(--secondary-200)",
                    "300": "var(--secondary-300)",
                    "400": "var(--secondary-400)",
                    "500": "var(--secondary-500)",
                    "600": "var(--secondary-600)",
                    "700": "var(--secondary-700)",
                    "800": "var(--secondary-800)",
                    "900": "var(--secondary-900)"
                },
                tertiary: {
                    DEFAULT: 'var(--tertiary)',
                    "50": "var(--tertiary-50)",
                    "100": "var(--tertiary-100)",
                    "200": "var(--tertiary-200)",
                    "300": "var(--tertiary-300)",
                    "400": "var(--tertiary-400)",
                    "500": "var(--tertiary-500)",
                    "600": "var(--tertiary-600)",
                    "700": "var(--tertiary-700)",
                    "800": "var(--tertiary-800)",
                    "900": "var(--tertiary-900)"
                  },
                danger: colors.rose,
                success: colors.green,
                warning: colors.yellow,
                'main-nav-active-hover-text-color': 'var(--main-nav-active-hover-text-color)',
                'main-nav-active-text-color': 'var(--main-nav-active-text-color)',
                'main-nav-active-bg-color': 'var(--main-nav-active-bg-color)',
                'main-nav-text-color': 'var(--main-nav-text-color)',
                'main-nav-hover-text-color': 'var(--main-nav-hover-text-color)',
                'main-nav-hover-bg-color': 'var(--main-nav-hover-bg-color)',
                'post-card-bg-color': 'var(--post-card-bg-color)',
                'post-card-border-color': 'var(--post-card-border-color)',
                'post-card-border-hover-color': 'var(--post-card-border-hover-color)',
                'post-card-title-color': 'var(--post-card-title-color)',
                'post-card-meta-color': 'var(--post-card-meta-color)',
                'post-card-body-color': 'var(--post-card-body-color)',
                'post-card-shadows': 'var(--post-card-shadows)',
                'heading-default-color': 'var(--heading-default-color)',
                'h1-color': 'var(--h1-color)',
                'h2-color': 'var(--h2-color)',
                'h3-color': 'var(--h3-color)',
                'h4-color': 'var(--h4-color)',
                'h5-color': 'var(--h5-color)',
                'h6-color': 'var(--h6-color)',
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
        require('tw-elements/dist/plugin'),
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
