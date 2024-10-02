import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";
import tailwindcss from "tailwindcss";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Ensure Vite listens on all interfaces
        port: 5173,
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
    ],
    css: {
        postcss: {
            plugins: [tailwindcss],
        },
    },
});
