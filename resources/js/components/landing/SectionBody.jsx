import React from "react";

export const SectionTitle = ({ children }) => {
    return (
        <div className="section-title-container">
            <h2 className="section-title">{children}</h2>
        </div>
    );
};

export const SectionContent = ({ children }) => {
    return (
        <div className="section-content">
            <p className="tabs-description">{children}</p>
        </div>
    );
};

export const SectionBody = ({ children, className = "" }) => {
    return <div className={`section-container ${className}`}>{children}</div>;
};

export default { SectionBody, SectionTitle, SectionContent };
