import Keycloak from "keycloak-js";

const auth = new Keycloak({
    url: process.env.REACT_APP_KEYCLOAK_ISSUER_URL,
    realm: process.env.REACT_APP_KEYCLOAK_REALM_NAME,
    clientId: process.env.REACT_APP_KEYCLOAK_CLIENT_ID
});

const initKeycloak = (onAuthenticatedCallback) => {
    auth.init({
        onLoad: 'login-required',
        silentCheckSsoRedirectUri: window.location.origin + '/silent-check-sso.html',
        pkceMethod: process.env.REACT_APP_KEYCLOAK_PKC_METHOD,
        redirectUri: process.env.REACT_APP_KEYCLOAK_REDIRECT_URL
    })
        .then((authenticated) => {
            if (!authenticated) {
                console.log("user is not authenticated..!");
            }
            onAuthenticatedCallback();
        })
        .catch(console.error);
};

const doLogin = auth.login;

const doLogout = auth.logout;

const getToken = () => auth.token;

const getRefreshToken = () => auth.refreshToken;

const isLoggedIn = () => !!auth.token;

const updateToken = (successCallback) =>
    auth.updateToken(5)
        .then(successCallback)
        .catch(doLogin);

const getUsername = () => auth.tokenParsed?.preferred_username;

const hasRole = (roles) => roles.some((role) => auth.hasRealmRole(role));

const AuthService = {
    initKeycloak,
    doLogin,
    doLogout,
    isLoggedIn,
    getToken,
    getRefreshToken,
    updateToken,
    getUsername,
    hasRole
};

export default AuthService;
