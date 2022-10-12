import Dashboard from "./views/Dashboard";
import TableList from "views/TableList.js";
import Typography from "views/Typography.js";
import Icons from "views/Icons.js";
//import User from "views/user/User";

const dashboardRoutes = [
  {
    path: "/",
    name: "Dashboard",
    icon: "nc-icon nc-chart-pie-35",
    component: Dashboard, 
    subNav: []
  },
  {
    path: "#",
    name: "Users",
    icon: "far fa-user",
    component: Icons,
    subNav: [
      {
        path: "/user",
        name: "User",
        icon: "nc-icon nc-circle-09",
        component: Icons,
      },
      {
        path: "/role",
        name: "Role",
        icon: "nc-icon nc-notes",
        component: TableList,
      },
      {
        path: "/permission",
        name: "Permission",
        icon: "nc-icon nc-paper-2",
        component: Typography,
      }
    ]
  }
];

export default dashboardRoutes;
