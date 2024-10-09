import React from "react";

export const MainHeader = ({ children, className = "" }) => {
    return <div className={`main-header ${className}`}>{children}</div>;
};

export const MainTitle = ({ children }) => {
    return <p className="main-title">{children}</p>;
};

export const MainBody = ({ children }) => {
    return <div className="main-body">{children}</div>;
};

export const MainContent = ({ children }) => {
    return <div className="main-content">{children}</div>;
};

export default { MainContent, MainHeader, MainTitle, MainBody };
