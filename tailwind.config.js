/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            colors: {
                navy: "#0F172A",
                navySoft: "#1E293B",
                accent: "#3B82F6",
                accentSoft: "#1D4ED8",
            },
        },
    },

    plugins: [
        require("flowbite/plugin"),
    ],
};
