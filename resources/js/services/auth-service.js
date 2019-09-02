import Cookies from 'js-cookie';
import {StorageService} from "./storage-service";


// ToDo: use .env to import these variables
const cookieKey = btoa('hotel_manager');
const sessionKey = 'met_match';

export const AuthService = {

  setCookie(token){
    Cookies.set( cookieKey, token, { expires: 5 } );
  },

  getCookie(){
    return Cookies.getJSON( cookieKey );
  },

  removeCookie(){
    Cookies.remove( cookieKey );
  },

  startSession(token){
    this.setCookie(token);
    StorageService.setSession( sessionKey, token.id );
  },

  endSession(){
    this.removeCookie();
    StorageService.removeSession( sessionKey );
  },

  userAuthenticated(){
    console.log('sessionKey: ', sessionKey, ' | session: ', StorageService.getSession( sessionKey ));
    return StorageService.getSession( sessionKey );
  },

};