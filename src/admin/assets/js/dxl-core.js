const DXLCore = {

    /**
     * Request data for all initiable requests 
     */
    request: {
        url: ajaxurl, // request url 

        // request data
        data: {
            action: "",
            dxl_core_nonce: dxl_core_vars.dxl_core_nonce
        }
    },

    /**
     * AJAX Request sender helper
     * @param string requested action the server to execute 
     * @param string request method to be default to a GET request  
     * @param string ajax url 
     * @param object data object the action to catch
     * @param function success callback when successfull response returns
     * @param function error callback when an error is thrown
     * @param function beforeSend callback triggered before request is sended
     */
    sendRequest: function(action, method = "GET", url = ajaxurl, data = this.request.data, successCallback = function(response){
        console.log(response)
    }, errorCallback = function(error){
        {console.log(error)}
    }, beforeSendCallback = function() {
        // do something be fore sending
    }) {
        this.request.data.action = action;
        jQuery.ajax({method: method, url: url, data: data, success: successCallback, error: errorCallback, beforeSend: beforeSendCallback});
    },

    /**
     * 
     * @param object response object 
     * @param string module 
     * @returns 
     */
    checkForResponseError: function(response) {
        if( response.error ) {
            return true;
        }

        return false;
    },

    /**
     * Open m<odal component if et exists on the current page
     * @param string modal 
     */
    openModal: function(modal) {
        jQuery(modal).removeClass('hidden');
        jQuery('.overlay').removeClass('hidden');
        jQuery('body').css({'overflow': 'hidden'});
    },

    /**
     * close opened modal on current page
     * @param string modal 
     */
    closeModal: function() {
        jQuery('.modal').addClass('hidden');
        jQuery('.overlay').addClass('hidden');
        jQuery('body').css({'overflow': 'auto'});
    },

    /**
     * redirect to specific action page
     * admin.php?page={plugin}&action={action}&slug/id={value}
     * @param string plugin 
     * @param object parameters
     */
    redirectToAction: function(plugin, parameters) {
        const self = this;
        let newUrl;

        newUrl = "admin.php?page=dxl-" + plugin + "";
        for(let paramIndex in parameters)
        {
            newUrl += "&" + paramIndex + "=" + parameters[paramIndex]
        }

        window.location.href = newUrl;
    },

    /**
     * popping up a warning notification
     */
    getAlert: (alert, callback) => {
        bootbox.alert("This is a test", callback)
    },

    /**
     * Rendering bootbox confirm dialog
     * @param {*} confirm 
     * @param {*} callback 
     * @param {*} hasButtons 
     */
    getConfirm: (confirm, callback, hasButtons) => {
        bootbox.confirm({
            message: alert,
        })
    },

    /**
     * Get bootbox prompt dialog
     * @param {} prompt 
     * @param {*} callback 
     */
    getPrompt: (prompt, callback) => {
        bootbox.prompt({
            title: prompt,
            callback: callback
        })
    },

    /**
     * render an custom dialog based on given options
     * @param Object options 
     */
    getCustomDialog: (options) => {
        bootbox.dialog(options);
    }
}