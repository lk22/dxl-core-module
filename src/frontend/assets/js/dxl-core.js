console.log("test");
const DXL = {

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
    }
}