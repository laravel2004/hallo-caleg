/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Controllers/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#1d4ed8",
            },
        },
    },
    plugins: [],
};
