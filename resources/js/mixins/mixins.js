const mixins = {
  methods: {
    //method "hasAnyPermission"
    hasAnyPermission: function (permissions) {

      //get permissions from props
      let allPermissions = this.$page.props.auth.permissions;

      let hasPermission = false;
      permissions.forEach(function(item){
        if(allPermissions[item]) hasPermission = true;     
      });

      return hasPermission;
    },

    formatPrice(value) {
      let val = (value/1).toFixed(0).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  },
};

export { mixins };