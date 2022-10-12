import { BrowserRouter, Route, Switch, Redirect } from "react-router-dom";

import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/css/animate.min.css";
import "./assets/scss/scms.scss?v=2.0.0";
import "./assets/css/custom.css";
import "@fortawesome/fontawesome-free/css/all.min.css";
import Admin from "./layouts/Admin";

const App = () => (
    <BrowserRouter>
        <Switch>
            <Route path="/" render={(props) => <Admin {...props} />} />
        </Switch>
    </BrowserRouter>
);

export default App;

