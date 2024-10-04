import React from "react";
import { SectionBody, SectionContent, SectionTitle } from "./SectionBody";

function MissionVission(props) {
    return (
        <>
            <SectionBody>
                <SectionTitle>Vision</SectionTitle>
                <SectionContent>
                    We envision a campus where seamless communication and
                    collaboration are the norms. By integrating a central
                    platform for all campus activities, we aim to create a
                    connected, engaged, and empowered community. Our vision is
                    to transform how information is shared and interactions
                    occur, leading to a more unified and collaborative campus
                    experience that enriches academic and social life for all.
                </SectionContent>
            </SectionBody>

            <SectionBody>
                <SectionTitle>Mission</SectionTitle>
                <SectionContent>
                    Our mission is to enhance communication and collaboration
                    within Cebu Eastern College by creating a comprehensive,
                    user-friendly platform that unifies announcements,
                    discussions, and resources. We strive to simplify
                    information sharing, improve coordination, and foster a
                    dynamic and inclusive academic environment where every
                    member of our community can engage effectively and stay
                    informed.
                </SectionContent>
            </SectionBody>

            <SectionBody className="last-section">
                <SectionTitle>Goal</SectionTitle>
                <SectionContent>
                    The primary goal of Campus Community Central is to develop
                    and implement a centralized web-based platform that
                    facilitates efficient communication and collaboration among
                    all members of Cebu Eastern College. Through this platform,
                    we aim to eliminate the inefficiencies of traditional
                    communication methods, promote greater participation, and
                    enhance overall user satisfaction. By providing a single,
                    reliable source for campus announcements and interactions,
                    we seek to create a more cohesive and engaging academic
                    community.
                </SectionContent>
            </SectionBody>
        </>
    );
}

export default MissionVission;
