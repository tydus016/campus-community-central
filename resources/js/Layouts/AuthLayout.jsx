import React from "react";

function AuthLayout({ children, formTitle = "", customClass = "" }) {
    return (
        <div className="auth-wrapper">
            <div className="auth-content">
                {/* form area */}
                <div className="auth-form-container">
                    <span className="form-title">{formTitle}</span>

                    <div className={`form-box ${customClass}`}>{children}</div>
                </div>

                {/* logo area */}
                <div className="auth-banner-container">
                    <div className="banner">
                        <img
                            src="/assets/logos/ccc-logo.png"
                            alt="ccc-banner image"
                            className="auth-ccc-banner"
                            draggable="false"
                        />

                        <p className="auth-banner-text">
                            CAMPUS COMMUNITY CENTRAL
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default AuthLayout;
