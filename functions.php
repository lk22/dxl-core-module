<?php 

    if(!function_exists('generate_dxl_subpage_url'))
    {
        function generate_dxl_subpage_url($parameters = []): string
        {
            $parametersList = [];
            $paramString = "";
            foreach($parameters as $p => $val)
            {
                $parametersList[$p] = $val;
                $paramString .= "&" . $p . "=" . $val;
            }
            return admin_url(sprintf('admin.php?%s', http_build_query($_GET))) . $paramString;
        }
    }

    function generate_dxl_admin_page_url($page)
    {
        return admin_url('admin.php?page=' . $page);
    }

    if( !function_exists('dxl_core_enqueue_scripts') )
    {
        function dxl_core_enqueue_scripts()
        {
            wp_enqueue_script('bootstrap5', plugin_dir_url(__FILE__) . "/src/admin/assets/js/dependencies/bootstrap.min.js", array('jquery'));
            wp_enqueue_style('bootstrap5', plugin_dir_url(__FILE__) . "/src/admin/assets/css/dependencies/bootstrap.min.css");
            wp_enqueue_script('bootbox', plugin_dir_url(__FILE__) . "/src/admin/assets/js/dependencies/bootbox.all.min.js", array('jquery'));
        }
    }

    add_action( 'admin_enqueue_scripts', 'dxl_core_enqueue_scripts' );


?>