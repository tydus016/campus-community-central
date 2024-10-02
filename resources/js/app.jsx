import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/inertia-react";
import { InertiaProgress } from "@inertiajs/progress";
import { AppProvider } from "../js/contexts/AppContext";

import "../css/app.css";

createInertiaApp({
    resolve: async (name) => {
        const page = await import(`./Pages/${name}`).then(
            (module) => module.default
        );
        return page;
    },
    setup({ el, App, props }) {
        createRoot(el).render(
            <AppProvider>
                <App {...props} />
            </AppProvider>
        );
    },
});

// Optional: Add Inertia progress
InertiaProgress.init();
