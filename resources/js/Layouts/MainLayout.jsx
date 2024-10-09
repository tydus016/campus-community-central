import React from "react";

import MainNavbar from "../components/MainNavbar";
import Footer from "../components/Footer";

function MainLayout({ children }) {
    return (
        <>
            <MainNavbar />
            {children}
            <Footer />
        </>
    );
}

export default MainLayout;
