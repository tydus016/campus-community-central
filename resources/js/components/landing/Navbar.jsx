import React from "react";
import { Link } from "@inertiajs/inertia-react";

function Navbar(props) {
    return (
        <div className="navbar">
            <div className="landing-top-navbar">
                <div className="navbar-branding">
                    <img
                        src="/assets/logos/ccc-log-alternate.png"
                        alt="ccc-logo"
                    />
                    <span className="branding-text">
                        CAMPUS COMMUNITY CENTRAL
                    </span>
                </div>

                <div className="navbar-links">
                    <Link className="navbar-link signup" href="/sign-up">
                        sign up
                    </Link>
                    <Link className="navbar-link login" href="/sign-in">
                        <span>login</span>
                    </Link>
                </div>
            </div>

            <div className="navbar-title">
                <span className="navbar-title-text">
                    One Platform, Infinite Campus Possibilities
                </span>
            </div>
        </div>
    );
}

export default Navbar;
