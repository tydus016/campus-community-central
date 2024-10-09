import React from "react";

function MainWrapper({ className, children }) {
    return <div className={`main-wrapper ${className}`}>{children}</div>;
}

export default MainWrapper;
