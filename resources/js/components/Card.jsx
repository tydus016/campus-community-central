import React from "react";

export const Card = ({ children, className = "" }) => {
    return <div className={`card ${className}`}>{children}</div>;
};

export const CardTitle = ({ children, className = "" }) => {
    return <h3 className={`card-title ${className}`}>{children}</h3>;
};

export const CardBody = ({ children, className = "" }) => {
    return <div className={`card-body ${className}`}>{children}</div>;
};

export default { Card, CardTitle, CardBody };
