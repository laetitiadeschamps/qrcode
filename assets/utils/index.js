import axios from 'axios'
import decode from 'jwt-decode'

export function isLoggedIn() {
    
        let authToken = getAuthToken();
       
        return !!authToken && !isTokenExpired(authToken)
    
}

export function getAuthToken() {
    return localStorage.getItem('token')    
}

function getTokenExpirationDate(encodedToken) {

    if(!encodedToken || encodedToken == 'null') {
       
        return null;
    }
    
    let token = decode(encodedToken)
    if (!token.exp) {
        return null
    }
  
    let date = new Date(0)
    date.setUTCSeconds(token.exp)
  
    return date
}

function isTokenExpired(token) {
    let expirationDate = getTokenExpirationDate(token)
    return expirationDate < new Date()
}