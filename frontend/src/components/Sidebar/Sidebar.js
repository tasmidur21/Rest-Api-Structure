import React from "react";
import { useLocation, NavLink } from "react-router-dom";
import { Nav, NavItem } from "reactstrap";
import SubMenu from "./SubMenue";

function Sidebar({ color, image, routes }) {
  const location = useLocation();
  const activeRoute = (routeName) => {
    return location.pathname.indexOf(routeName) > -1 ? "active" : "";
  };
  return (
    <div className="sidebar" data-image={image} data-color={color}>
      <div
        className="sidebar-background"
        style={{
          backgroundImage: "url(" + image + ")"
        }}
      />
      <div className="sidebar-wrapper">
        <div className="logo d-flex align-items-center justify-content-start">
          <a href="/" className="simple-text logo-mini mx-1">
            <div className="logo-img">
              <img src={require("assets/img/reactlogo.png")} alt="..." />
            </div>
          </a>
          <a className="simple-text" href="/">
            BYSL
          </a>
        </div>
        <Nav>
          {routes.map((prop, key) => {
            if (!prop.redirect)
              if(!prop.subNav.length)
                return (
                  <NavItem className={activeRoute(prop.path)} key={key}>
                    <NavLink
                      to={prop.path}
                      className="nav-link"
                      activeClassName="active"
                    >
                      <i className={prop.icon} />
                      <p>{prop.name}</p>
                    </NavLink>
                  </NavItem>
                );
              else
                return (
                   <SubMenu title={prop.name} icon={prop.icon} path={prop.path} items={prop.subNav} key={key}/>
                );
            return null;
          })}
        </Nav>
      </div>
    </div>
  );
}

export default Sidebar;