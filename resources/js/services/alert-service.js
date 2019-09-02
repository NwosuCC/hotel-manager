
const Alert = {
  eventBus: () => window.vmEvents,

  types: {
    SUCCESS: 'success', INFO: 'info', WARNING: 'warning', ERROR: 'danger',
  },

  props: {
    message: '', type: '',
  },

  timeout: 0,

  hasType(type){
    return Object.values(Alert.types).indexOf(type) >= 0;
  },

  set(message, timeout, type){
    this.props.type = Alert.hasType(type) ? type : Alert.types.SUCCESS;
    this.props.message = message;
    this.timeout = (isNaN(timeout) || timeout < 0) ? 0 : timeout;
    return Alert;
  },

  show(){
    Alert.eventBus().$emit('flash:data', {...Alert.props});
  }
};


export const AlertService = {

  success(message, timeout = 0){
    Alert.set(message, timeout, Alert.types.SUCCESS).show();
  },

  info(message, timeout = 0){
    Alert.set(message, timeout, Alert.types.INFO).show();
  },

  warning(message, timeout = 0){
    Alert.set(message, timeout, Alert.types.WARNING).show();
  },

  error(message, timeout = 0){
    Alert.set(message, timeout, Alert.types.ERROR).show();
  }

};
