import React from "react";

export const OrgCardBanner = ({ children, className = "" }) => {
    return <div className={`org-card-banner ${className}`}>{children}</div>;
};

export const OrgCardFooter = ({ children, className = "" }) => {
    return <div className={`org-card-footer ${className}`}>{children}</div>;
};

export const OrgCardTitle = ({ children, className = "" }) => {
    return <p className={`org-card-title ${className}`}>{children}</p>;
};

export const OrgCard = ({ children, className = "" }) => {
    return <div className={`org-card ${className}`}>{children}</div>;
};

export default { OrgCard, OrgCardBanner, OrgCardFooter, OrgCardTitle };
