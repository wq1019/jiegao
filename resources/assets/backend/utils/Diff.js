export default class Diff {
  clear () {
    this.oldObj = undefined;
  }
  save (oldObj) {
    this.oldObj = {...oldObj};
  }
  isDiff (submitObj) {
    const diffObjStr = JSON.stringify(this.diff(submitObj));
    return diffObjStr !== '{}';
  }
  isSerializeDiff (submitObj) {
    let oldObjStr = JSON.stringify(this.oldObj);
    let newObjStr = JSON.stringify(submitObj);
    return newObjStr !== oldObjStr;
  }
  diff (submitObj) {
    let newObj = {...submitObj};
    if (!this.oldObj) {
      for (let index in newObj) {
        if (newObj[index] === null) {
          delete newObj[index];
        }
      }
      return newObj;
    }
    let diffObj = {};
    for (let key in newObj) {
      if (isValue(this.oldObj[key])) {
        if (this.oldObj[key] !== newObj[key]) {
          diffObj[key] = newObj[key];
        }
      } else if (isArray(this.oldObj[key])) {
        if (this.oldObj[key].sort().toString() !== newObj[key].sort().toString()) {
          diffObj[key] = newObj[key];
        }
      }
    }
    return diffObj;
  }
};
function isArray (obj) {
  return {}.toString.apply(obj) === '[object Array]';
}
function isObject (obj) {
  return {}.toString.apply(obj) === '[object Object]';
}
function isValue (obj) {
  return !isObject(obj) && !isArray(obj);
}
