import React, { useState, useEffect } from "react";

function Icon({ type, className, style, onClick = () => {} }) {
    const [IconComponent, setIconComponent] = useState(null);

    useEffect(() => {
        let isMounted = true;

        async function loadIcon() {
            try {
                const iconMap = {
                    Group: () => import("@mui/icons-material/Group"),
                    Menu: () => import("@mui/icons-material/Menu"),
                    Close: () => import("@mui/icons-material/Close"),
                    LightMode: () => import("@mui/icons-material/LightMode"),
                    DarkMode: () => import("@mui/icons-material/DarkMode"),
                    MenuOpen: () => import("@mui/icons-material/MenuOpen"),
                    ShoppingCart: () =>
                        import("@mui/icons-material/ShoppingCart"),
                    FilterList: () => import("@mui/icons-material/FilterList"),
                };

                if (iconMap[type]) {
                    const { default: LoadedIcon } = await iconMap[type]();
                    if (isMounted) setIconComponent(() => LoadedIcon);
                } else {
                    console.warn(`Icon type "${type}" is not recognized.`);
                }
            } catch (error) {
                console.error("Error loading icon:", error);
            }
        }

        loadIcon();

        return () => {
            isMounted = false;
        };
    }, [type]);

    if (!IconComponent) return null;

    return (
        <IconComponent className={className} style={style} onClick={onClick} />
    );
}

export default Icon;
