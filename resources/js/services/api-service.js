import axios from 'axios';
import {AuthService} from "./auth-service";


export const ApiService = {
  tokenSet: false,

  setBearer(){
    if( ! AuthService.tokenSet){
      let cookie = AuthService.getCookie();
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + (cookie ? cookie.token : '');
      AuthService.tokenSet = true;
    }
    return this;
  },

  handleRequest(request, callback){
    request
      .then(response => {
        callback( null, response.data );
      })
      .catch(error => {
        console.log('ApiService error: ', error);
        callback( error, error.response.data );
      });
  },

  getPaginated(url, params, callback){
    this.setBearer().handleRequest(
      axios.get(url, params), callback
    );
  },

  get(url, callback){
    this.setBearer().handleRequest(
      axios.get(url), callback
    );
  },

  post(url, data, callback){
    this.setBearer().handleRequest(
      axios.post(url, data), callback
    );
  },

  put(url, data, callback){
    this.setBearer().handleRequest(
      axios.put(url, data), callback
    );
  },

  delete(url, callback){
    this.setBearer().handleRequest(
      axios.delete(url), callback
    );
  },


  // ======================================================================

  Login(formData, callback){
    let url = '/api/login';
    ApiService.post(url, formData, callback);
  },

  Logout(formData, callback){
    let url = '/api/logout';
    ApiService.post(url, formData, callback);
  },

  getUsers(page, callback){
    let url = '/api/users';
    ApiService.getPaginated(url, page, callback);
  },

  getHotel(callback){
    let url = '/api/';
    ApiService.get(url, callback);
  },

  getRoomTypes(page, callback){
    let url = page ? '/api/room-types/paginated' :  '/api/room-types';
    ApiService.getPaginated(url, { params: { page } }, callback);
  },

  addRoomType(formData, callback){
    let url = '/api/room-types';
    ApiService.post(url, formData, callback);
  },

  getRoomTypeDetails(id, callback){
    let url = '/api/room-types/' + id;
    ApiService.get(url, callback);
  },

  updateRoomType(formData, id, callback){
    let url = '/api/room-types/' + id;
    ApiService.put(url, formData, callback);
  },

  deleteRoomType(id, callback){
    let url = '/api/room-types/' + id;
    ApiService.delete(url, callback);
  },


  // ==========================================================================
  // R O O M S
  // ==========================================================================

  getRooms(page, callback){
    let url = '/api/rooms';
    ApiService.getPaginated(url, { params: { page } }, callback);
  },

  addRoom(formData, callback){
    let url = '/api/rooms';
    ApiService.post(url, formData, callback);
  },

  getRoomDetails(id, callback){
    let url = '/api/rooms/' + id;
    ApiService.get(url, callback);
  },

  updateRoom(formData, id, callback){
    let url = '/api/rooms/' + id;
    ApiService.put(url, formData, callback);
  },

  deleteRoom(id, callback){
    let url = '/api/rooms/' + id;
    ApiService.delete(url, callback);
  },

};