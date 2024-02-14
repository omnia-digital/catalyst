module.exports = {
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
        require('postcss-import'),
        require('postcss-nesting'),
        require('cssnano')({
            preset: 'default',
        }),
    ],
}
