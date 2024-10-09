import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/inertia-react";
import { InertiaProgress } from "@inertiajs/progress";
import { AppProvider } from "../js/contexts/AppContext";
import { NotifProdiver } from "../js/contexts/NotifContext";
import { MessageNotifProdiver } from "../js/contexts/MessageNotifContext";

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
                <NotifProdiver>
                    <MessageNotifProdiver>
                        <App {...props} />
                    </MessageNotifProdiver>
                </NotifProdiver>
            </AppProvider>
        );
    },
});

// Optional: Add Inertia progress
InertiaProgress.init();
