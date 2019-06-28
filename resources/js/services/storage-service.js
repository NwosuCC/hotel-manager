
const Store = {

  getStorage(type){
    switch (String(type)){
      case 'local' : return localStorage;
      case 'session' : return sessionStorage;
    }
  },

  set(type, key, value){
    if( ! StorageService.isSupported()){
      return;
    }

    let hashedKey = btoa(key), hashedKey2 = btoa(hashedKey);

    let item = btoa( JSON.stringify(value));

    Store.getStorage(type).setItem( hashedKey, btoa( item + hashedKey2 ));
  },

  get(type, key){
    if( ! StorageService.isSupported()){
      return;
    }

    let hashedKey = btoa(key), hashedKey2 = btoa(hashedKey);
    let item = null;

    let storedItem = Store.getStorage(type).getItem( hashedKey );
    let hashedItem = atob(storedItem).slice( 0, -(hashedKey2.length));

    try {
      item = hashedItem ? JSON.parse( atob(hashedItem)) : null;
    }
    catch (error){}

    return item;
  },

  remove(type, key){
    if( ! StorageService.isSupported()){
      return;
    }

    Store.getStorage(type).removeItem( btoa(key) );
  },

};


export const StorageService = {

  isSupported(){
    return typeof(Storage) !== "undefined";
  },

  setLocal(key, value){
    Store.set('local', key, value);
  },

  setSession(key, value){
    Store.set('session', key, value);
  },

  getLocal(key){
    return Store.get('local', key);
  },

  getSession(key){
    return Store.get('session', key);
  },

  removeLocal(key){
    return Store.remove('local', key);
  },

  removeSession(key){
    return Store.remove('session', key);
  },

};