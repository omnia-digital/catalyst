const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [
            './resources/views/episode/embed.blade.php',
            './resources/views/episode/embed-gallery.blade.php',
            './resources/views/episode/embed-pagination.blade.php',
        ],

        options: {
            defaultExtractor: content => content.match(/[\w-/:.]+(?<!:)/g) || [],
            safelist: [/^text-/, /^grid-/], // Retain all classes starting with...,
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
        // require('@tailwindcss/forms'),
        // require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/line-clamp')
    ],
};
