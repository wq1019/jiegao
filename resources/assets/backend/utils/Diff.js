export default class Diff {
  clear () {
    this.oldObj = undefined;
  }
  save (oldObj) {
    this.oldObj = objDeepCopy(oldObj);
  }
  isDiff (submitObj) {
    return false;
    // const diffObjStr = JSON.stringify(this.diff(submitObj));
    // return diffObjStr !== '{}';
  }
  diff (submitObj) {
    return submitObj;
    // let newObj = objDeepCopy(submitObj);
    // if (!this.oldObj) {
    //   for (let index in newObj) {
    //     if (newObj[index] === null) {
    //       delete newObj[index];
    //     }
    //   }
    //   return newObj;
    // }
    // let diffObj = {};
    // for (let key in newObj) {
    //   if (isValue(this.oldObj[key])) {
    //     if (this.oldObj[key] !== newObj[key]) {
    //       diffObj[key] = newObj[key];
    //     }
    //   } else if (isArray(this.oldObj[key])) {
    //     if (this.oldObj[key].sort().toString() !== newObj[key].sort().toString()) {
    //       diffObj[key] = newObj[key];
    //     }
    //   }
    // }
    // return diffObj;
  }
};
// function isArray (obj) {
//   return {}.toString.apply(obj) === '[object Array]';
// }
// function isObject (obj) {
//   return {}.toString.apply(obj) === '[object Object]';
// }
// function isValue (obj) {
//   return !isObject(obj) && !isArray(obj);
// }
function objDeepCopy (source) {
  var sourceCopy = source instanceof Array ? [] : {};
  for (var item in source) {
    sourceCopy[item] = typeof source[item] === 'object' && !(source[item] instanceof Date) ? objDeepCopy(source[item]) : source[item];
  }
  return sourceCopy;
}
