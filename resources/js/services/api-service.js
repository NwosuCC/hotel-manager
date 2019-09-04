import axios from 'axios';
import {AuthService} from "./auth-service";


export const ApiService = {
  tokenSet: false,

  setBearer(){
    if( ! AuthService.tokenSet){
      let user = AuthService.getUser();
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + (user ? user.token : '');
      AuthService.tokenSet = true;
    }
    return this;
  },

  // errorHandler(callback){
  //   axios.interceptors.response.use(
  //     function (response) {
  //       // console.log('errorHandler response: ', response);
  //       return response;
  //     },
  //     function (error) {
  //       // console.log('errorHandler error: ', error);
  //       if(error.response){
  //         alert(error.response.data.message);
  //         callback(error, (error.response ? error.response.data : null));
  //       }
  //     }
  //   );
  // },

  handleRequest(request, callback){
    // this.errorHandler(callback);

    request
      .then(response => {
        // console.log('handleRequest response: ', response);
        callback( null, response.data );
      })
      .catch(error => {
        // console.log('handleRequest error: ', error);
        callback(error, (error.response ? error.response.data : null));
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


  /* ================================================================
   | A U T H
   * ------------------------------------------------------------*/
  register(formData, callback){
    let url = '/api/register';
    ApiService.post(url, formData, callback);
  },

  getDemoData(callback){
    let url = '/api/demo';
    ApiService.get(url, callback);
  },

  login(formData, callback){
    let url = '/api/login';
    ApiService.post(url, formData, callback);
  },

  logout(formData, callback){
    let url = '/api/logout';
    ApiService.post(url, formData, callback);
  },

  getUsers(page, callback){
    let url = '/api/users';
    ApiService.getPaginated(url, page, callback);
  },


  /* ================================================================
   | H O T E L
   * ------------------------------------------------------------*/
  getHotel(callback){
    let url = '/api/';
    ApiService.get(url, callback);
  },


  /* ================================================================
   | R O O M   T Y P E S
   * ------------------------------------------------------------*/
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


  /* ================================================================
   | R O O M S
   * ------------------------------------------------------------*/
  getRooms(page, callback){
    let url = '/api/rooms';
    ApiService.getPaginated(url, { params: { page } }, callback);
  },

  getRoomsPaginated(page, callback){
    let url = '/api/rooms/paginated';
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


  /* ================================================================
   | B O O K I N G S
   * ------------------------------------------------------------*/
  getBookings(page, callback){
    let url = '/api/bookings';
    ApiService.getPaginated(url, { params: { page } }, callback);
  },

  getBookingsPaginated(query, callback){
    let url = '/api/bookings/paginated';
    ApiService.getPaginated(url, { params: query }, callback);
  },

  addBooking(formData, callback){
    let url = '/api/bookings';
    ApiService.post(url, formData, callback);
  },

  getBookingDetails(id, callback){
    let url = '/api/bookings/' + id;
    ApiService.get(url, callback);
  },

  updateBooking(formData, id, callback){
    let url = '/api/bookings/' + id;
    ApiService.put(url, formData, callback);
  },

  deleteBooking(id, callback){
    let url = '/api/bookings/' + id;
    ApiService.delete(url, callback);
  },

};
