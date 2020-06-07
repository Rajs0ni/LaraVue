export default {
  required: (value) => !!value || 'Field is required',
  email: (value) => {
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (value) {
      return pattern.test(value) || 'invalid email';
    }
    return true;
  },
  numeric: (value) => {
    const pattern = /^\d+$/;
    return pattern.test(value) || 'It must be numeric';
  },
  exact_length: (length) => {
    return function(value) {
      if (value && value.length != length) {
        return 'This field should have ' + length + ' characters';
      }
      return true;
    };
  },
};
