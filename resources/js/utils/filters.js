
import _ from 'lodash';

const Filters = (function () {
  return {
    kebabCase(text) {
      return _.kebabCase(text)
    },
    titleCase(text) {
      // return _.upperFirst(text);
      let words = String( text ).toLowerCase().split(" ").filter(w => !!w).map(w => w.split(''));
      return words.map(word => word.shift().toUpperCase() + word.join("") ).join(' ');
    },
    dayDate(date){
      return (new Date( date )).toDateString();
    },
    date(date){
      let weekday = Filters.weekDay(date, true);
      return Filters.dayDate(date, true).replace(weekday, '').trim()
    },
    weekDay(date, short){
      short = Number( short !== false );
      let d = new Date( date );
      let days = [
        ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
        ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
      ];
      return days[ short ][ d.getDay() ];
    },
  };
})();


/*---------------------------------------------------------------*
 | Filters imported and registered into Vue in base app.js
 *------------------------------------------------------------*/
export default Filters;