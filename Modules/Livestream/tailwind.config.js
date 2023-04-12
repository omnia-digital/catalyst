const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [
            './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
            './vendor/laravel/jetstream/**/*.blade.php',
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php',
        ],

        options: {
            defaultExtractor: content => content.match(/[\w-/:.]+(?<!:)/g) || [],
            safelist: [/^bg-/, /^text-/, /^grid-/], // Retain all classes starting with...,
        }
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blue: {
                    // light: "#57ADDE",
                    DEFAULT: "#fff",
                    dark: "#fff"
                },
                gold: {
                    DEFAULT: "#E9AF6B"
                }
            },
            fontSize: {
                "3xs": '.3rem'
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            cursor: ['disabled'],
            borderStyle: ['hover'],
            borderWidth: ['hover']
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/line-clamp')
    ],
};
