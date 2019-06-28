import Cookies from 'js-cookie';
import {StorageService} from "./storage-service";


// ToDo: use .env to import these variables
const cookieKey = btoa('hotel_manager');
const sessionKey = 'met_match';

export const AuthService = {

  getSessionKey(){
    return sessionKey;
  },

  userAuthenticated(){
    return StorageService.getSession( sessionKey );
  },

  setCookie(token){
    Cookies.set( cookieKey, token, { expires: 5 } );
  },

  getCookie(){
    return Cookies.getJSON( cookieKey );
  },

  removeCookie(){
    Cookies.remove( cookieKey );
  },

};