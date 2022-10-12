import ReactDOM from "react-dom/client";
import App from "./App";
// import HttpService from "./services/HttpService";
// import AuthService from "./services/AuthService";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);
// const renderApp = () => root.render(<App />);
// AuthService.initKeycloak(renderApp);
// HttpService.configure();