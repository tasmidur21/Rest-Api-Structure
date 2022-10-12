import React, { useState } from "react";
import classNames from "classnames";
import { Collapse, NavItem, NavLink } from "reactstrap";
import { Link } from "react-router-dom";

const SubMenu = (props) => {
  const [collapsed, setCollapsed] = useState(true);
  const toggle = () => setCollapsed(!collapsed);
  const { icon, title, items } = props;
  const activeRoute = (routeName) => {
    return location.pathname.indexOf(routeName) > -1 ? "ml-4 active" : "ml-4";
  };
  return (
    <div>
      <NavItem onClick={toggle} className={classNames({ "menu-open": !collapsed })} style={{cursor: "pointer"}}>
        <NavLink className="dropdown-toggle">
          <i className={icon} />
            <p>
                {title}
                <b className="caret"></b>
            </p>
        </NavLink>
      </NavItem>
      <Collapse isOpen={!collapsed} className={classNames("items-menu", { "mb-1": !collapsed })}>
        {items.map((item, key) => (
            <NavItem  key={key} className={activeRoute(item.path)}>
                <NavLink
                    tag={Link}
                    to={item.path}
                >
                <span className="sidebar-normal">{item.name}</span>
                </NavLink>
            </NavItem>
        ))}
      </Collapse>
    </div>
  );
};

export default SubMenu;
