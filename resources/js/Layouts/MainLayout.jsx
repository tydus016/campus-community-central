import React, { useContext, useEffect, useState } from "react";

import { AppContext } from "../contexts/AppContext";

// - components
import Topnavbar from "../components/Topnavbar";
import Sidebar from "../components/Sidebar";
import Container from "../components/Container";

function MainLayout({ children, onClick = () => {} }) {
    const { state } = useContext(AppContext);

    const [menuState, setMenuState] = useState(state.menuState);
    useEffect(() => {
        setMenuState(state.menuState);
    }, [state.menuState]);

    return (
        <div className="wrapper" onClick={onClick}>
            <Topnavbar />

            {menuState && <Sidebar isVisible={menuState} />}

            <Container menuState={menuState}>{children}</Container>
        </div>
    );
}

export default MainLayout;
