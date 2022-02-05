const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
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
                'sm': '0.95rem'
            },
            colors: {
                rose: colors.rose,
                neutral: "#f5f7fa",
                primary: "#10b981",
                // primary: "#303956",
                // primary: "#305653",
                secondary: "#303956",
                // secondary: "#10b981",
                tertiary: "#384263"
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
    ]
};
