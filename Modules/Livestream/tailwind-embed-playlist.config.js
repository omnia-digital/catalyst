const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [
            './resources/views/playlist/**/*.blade.php',
            './resources/views/components/**/*.blade.php',
        ]
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
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp')
    ],
};
