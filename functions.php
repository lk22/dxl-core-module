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

?>