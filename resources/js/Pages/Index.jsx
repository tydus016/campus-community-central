import React from "react";

// - components
import AboutUs from "../components/landing/AboutUs";
import MissionVission from "../components/landing/MissionVission";

// - layout
import LandingLayout from "../Layouts/LandingLayout";

function Index(props) {
    return (
        <LandingLayout>
            <AboutUs />
            <MissionVission />
        </LandingLayout>
    );
}

export default Index;
