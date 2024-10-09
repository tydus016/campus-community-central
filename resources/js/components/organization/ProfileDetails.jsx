import React from "react";

import {
    OrgCard,
    OrgCardBanner,
    OrgCardFooter,
    OrgCardTitle,
} from "../../components/OrgCard";

function ProfileDetails({ showStats = false, className = "" }) {
    const Statistics = () => {
        return (
            <div className="org-admin-about-section">
                <h2 className="about-section-title">Statistics</h2>

                <div className="chart-container">
                    <img
                        src="/assets/icons/bar_chart_icon.png"
                        alt="bar_chart_icon"
                        draggable="false"
                    />
                </div>
            </div>
        );
    };

    return (
        <div className={`org-profile-details ${className}`}>
            <div className="org-profile-content">
                <OrgCard className="org-profile-card">
                    <OrgCardBanner>
                        <img
                            src="/assets/images/orgs/ap.png"
                            alt="org-banner"
                        />
                    </OrgCardBanner>
                    <OrgCardFooter>
                        <OrgCardTitle className="org-profile-card-title">
                            Atalaya Publication
                        </OrgCardTitle>
                    </OrgCardFooter>
                </OrgCard>

                <div className="org-admin-details">
                    <div className="org-admin-details-head">
                        <img
                            src="/assets/icons/profile_account_icon.png"
                            alt="profile image icon"
                            draggable="false"
                        />

                        <div className="admin-name-details">
                            <p className="org-name">Atalaya Publication</p>
                            <p className="org-admin-position">Head</p>
                        </div>
                    </div>

                    <div className="send-message-btn-wrapper">
                        <div className="org-admin-send-msg-btn">
                            <span>Send Message</span>
                        </div>
                    </div>

                    <div className="org-admin-about-section">
                        <h2 className="about-section-title">About</h2>

                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Voluptatum delectus nostrum facilis soluta a,
                            non officiis cum laudantium iusto quis voluptatibus,
                            culpa exercitationem natus! Fugit non fuga obcaecati
                            porro consequatur!
                        </p>
                    </div>

                    {showStats && <Statistics />}
                </div>
            </div>
        </div>
    );
}

export default ProfileDetails;
