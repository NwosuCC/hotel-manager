import axios from 'axios';

export const ApiService = {

  getHotel(callback)
  {
    axios
      .get('/api/')
      .then(response => {
        callback( null, response.data );
      })
      .catch(error => {
        callback( error, error.response.data );
      });
  },

  getUsers(page, callback){
    axios
      .get('/api/users', page)
      .then(response => {
        callback( null, response.data );
      })
      .catch(error => {
        callback( error, error.response.data );
      });
  },

};