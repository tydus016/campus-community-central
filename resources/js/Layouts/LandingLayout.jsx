import React from "react";

// - components
import Navbar from "../components/landing/Navbar";
import Footer from "../components/Footer";

function LandingLayout({ children }) {
    return (
        <div className="landing-wrapper">
            <Navbar />

            {children}

            <Footer />
        </div>
    );
}

export default LandingLayout;
