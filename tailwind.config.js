import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    '"M PLUS 1"',
                    '"Helvetica Neue"',
                    "Helvetica",
                    '"Hiragino Sans"',
                    '"Hiragino Kaku Gothic ProN"',
                    "Arial",
                    '"Yu Gothic"',
                    "Meiryo",
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            fontSize: {
                base: "24px",
                h1: "48px",
                "small-base": "16px",
            },
            colors: {
                "custom-gray": "#666563",
                beige: "#FFF4E0",
                "custom-green": "#8EFF99",
                "custom-brown": "#FFB98E",
                "form-gray": "#F5F5F4",
                "custom-blue": "#00AAFF",
                "custom-pink": "#FD8DFD",
                "calendar-title": "#849ab9",
                "stamp-gold": "#fbbf24",
                "stamp-blue": "#60a5fa",
            },
        },
    },

    plugins: [forms],
};
