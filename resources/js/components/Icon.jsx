import React, { useState, useEffect } from "react";

function Icon({ type, className, style, onClick = () => {} }) {
    const [IconComponent, setIconComponent] = useState(null);

    useEffect(() => {
        let isMounted = true;

        async function loadIcon() {
            try {
                const iconMap = {
                    Search: () => import("@mui/icons-material/Search"),
                    Group: () => import("@mui/icons-material/Group"),
                    Menu: () => import("@mui/icons-material/Menu"),
                    Close: () => import("@mui/icons-material/Close"),
                    LightMode: () => import("@mui/icons-material/LightMode"),
                    DarkMode: () => import("@mui/icons-material/DarkMode"),
                    MenuOpen: () => import("@mui/icons-material/MenuOpen"),
                    ShoppingCart: () =>
                        import("@mui/icons-material/ShoppingCart"),
                    FilterList: () => import("@mui/icons-material/FilterList"),
                    Visibility: () => import("@mui/icons-material/Visibility"),
                    VisibilityOff: () =>
                        import("@mui/icons-material/VisibilityOff"),
                    Category: () => import("@mui/icons-material/Category"),
                    MoreVert: () => import("@mui/icons-material/MoreVert"),
                    Settings: () => import("@mui/icons-material/Settings"),
                    Notifications: () =>
                        import("@mui/icons-material/Notifications"),
                    AddCircle: () => import("@mui/icons-material/AddCircle"),
                    Mood: () => import("@mui/icons-material/Mood"),
                    Mic: () => import("@mui/icons-material/Mic"),
                    Check: () => import("@mui/icons-material/Check"),
                    ThumbUp: () => import("@mui/icons-material/ThumbUp"),
                    ThumbUpAltOutlined: () =>
                        import("@mui/icons-material/ThumbUpAltOutlined"),
                    ThumbDown: () => import("@mui/icons-material/ThumbDown"),
                    ThumbDownAltOutlined: () =>
                        import("@mui/icons-material/ThumbDownAltOutlined"),
                    SendOutlined: () =>
                        import("@mui/icons-material/SendOutlined"),
                    ImageOutlined: () =>
                        import("@mui/icons-material/ImageOutlined"),
                    CloudUploadOutlined: () =>
                        import("@mui/icons-material/CloudUploadOutlined"),
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
