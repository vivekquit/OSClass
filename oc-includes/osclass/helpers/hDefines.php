<?php

    //URL Helpers
    function osc_base_url($with_index = false) {
        $path = WEB_PATH ;
        if ($with_index) $path .= "index.php" ;
        return($path) ;
    }

    function osc_admin_base_url($with_index = false) {
        $path = WEB_PATH . "oc-admin/" ;
        if ($with_index) $path .= "index.php" ;
        return($path) ;
    }

    //Path Helpers
    function osc_base_path() {
        return(ABS_PATH) ;
    }

    function osc_admin_base_path() {
        return(osc_base_path() . "oc-admin/") ;
    }

    function osc_lib_path() {
        return(LIB_PATH) ;
    }

    function osc_themes_path() {
        return(THEMES_PATH) ;
    }

    function osc_plugins_path() {
        return(PLUGINS_PATH) ;
    }

    function osc_translations_path() {
        return(TRANSLATIONS_PATH) ;
    }

    function osc_css_url() {
        return(osc_base_url() . 'oc-includes/css/') ;
    }

    function osc_js_url() {
        return(osc_base_url() . 'oc-includes/js/') ;
    }

    //ONLY USED AT OC-ADMIN
    function osc_current_admin_theme() {
        return( AdminThemes::newInstance()->getCurrentTheme() ) ;
    }

    function osc_current_admin_theme_url() {
        return( AdminThemes::newInstance()->getCurrentThemeUrl() ) ;
    }
    
    function osc_current_admin_theme_path() {
        return( AdminThemes::newInstance()->getCurrentThemePath() ) ;
    }

    function osc_current_admin_theme_styles_url() {
        return( AdminThemes::newInstance()->getCurrentThemeStyles() ) ;
    }

    function osc_current_admin_theme_js_url() {
        return( AdminThemes::newInstance()->getCurrentThemeJs() ) ;
    }

    //ONLY USED AT PUBLIC WEBSITE
    function osc_current_web_theme() {
        return( WebThemes::newInstance()->getCurrentTheme() ) ;
    }

    function osc_current_web_theme_url() {
        return( WebThemes::newInstance()->getCurrentThemeUrl() ) ;
    }

    function osc_current_web_theme_path() {
        return( WebThemes::newInstance()->getCurrentThemePath() ) ;
    }

    function osc_current_web_theme_styles_url() {
        return( WebThemes::newInstance()->getCurrentThemeStyles() ) ;
    }

    function osc_current_web_theme_js_url() {
        return( WebThemes::newInstance()->getCurrentThemeStyles() ) ;
    }

    
    /////////////////////////////////////
    //functions for the public website //
    /////////////////////////////////////
    function osc_item_post_url($category = '') {
        if ($category != '') {
            if ( osc_rewrite_enabled() ) {
                $path = osc_base_url() . 'item/new/' . $cat['pk_i_id'] ;
            } else {
                $path = sprintf(osc_base_url(true) . '?page=item&action=post&catId=%d', $cat['pk_i_id']) ;
            }
        } else {
            if ( osc_rewrite_enabled() ) {
                $path = osc_base_url() . 'item/new' ;
            } else {
                $path = sprintf(osc_base_url(true) . '?page=item&action=post') ;
            }
        }
        return $path ;
    }

    /**
     * Create automatically the url of a category
     *
     * @param array $cat An array with the category information
     * @param bool $echo If you want to echo or not the path automatically
     * @return string If $echo is false, it returns the path, if not it return blank string
     */
    //osc_createSearchURL y lo mismo con category...
    function osc_search_category_url($category = '', $pattern = '') {
        $path = '' ;
        if ( osc_rewrite_enabled() ) {
            if ($category != '') {
                $category = Category::newInstance()->hierarchy($category['pk_i_id']) ;
                $sanitized_category = "" ;
                for ($i = count($category); $i > 0; $i--) {
                    $sanitized_category .= $category[$i - 1]['s_slug'] . '/' ;
                }
                $path = osc_base_url() . $sanitized_category ;
            }
            if ($pattern != '') {
                if ($path == '') {
                    $path = osc_base_url() . 'search/' . $pattern ;
                } else {
                    $path .= 'search/' . $pattern ;
                }
            }
        } else {
            $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $category['pk_i_id'] ) ;
        }
        return $path ;
    }

    //osc_createUserAccountURL
    function osc_user_dashboard_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/dashboard' ;
        } else {
            $path = osc_base_url(true) . '?action=dashboard' ;
        }
        return $path ;
    }

    //osc_createLogoutURL
    function osc_user_logout_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/logout' ;
        } else {
            $path = osc_base_url(true) . '?page=user&action=logout' ;
        }
        return $path ;
    }

    //osc_createRegisterURL
    function osc_register_account_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/register' ;
        } else {
            $path = osc_base_url(true) . '?pages=user&action=register' ;
        }
        return $path ;
    }

    //osc_createLoginURL
    function osc_login_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url(true) . 'user/login';
        } else {
            $path = osc_base_url(true) . '?pages=user&action=login' ;
        }
        return $path ;
    }

    //osc_createItemURL
    function osc_item_url($item) {
        if ( osc_rewrite_enabled() ) {
            $sanitized_title = osc_sanitizeString($item['s_title']) ;
            $sanitized_category = '';
            $cat = Category::newInstance()->hierarchy($item['fk_i_category_id']) ;
            for ($i = (count($cat)); $i > 0; $i--) {
                $sanitized_category .= $cat[$i - 1]['s_slug'] . '/' ;
            }
            $path = osc_base_url() . sprintf('%s%s_%d', $sanitized_category, $sanitized_title, $item['pk_i_id']) ;
        } else {
            $path = osc_base_url(true) . sprintf('?pages=item&id=%d', $item['pk_i_id']) ;
        }
        return $path ;
    }

    //osc_createPageURL
    function osc_page_url($page) {
        if ( osc_rewrite_enabled() ) {
            $sanitizedString = osc_sanitizeString($page['s_title']);
            $path = sprintf(osc_base_url() . '%s-p%d', urlencode($sanitizedString), $page['pk_i_id']) ;
        } else {
            $path = sprintf(osc_base_url(true) . '?page=page&id=%d', $page['pk_i_id']) ;
        }
        return $path ;
    }

    //osc_createUserAlertsURL
    function osc_user_alerts_url() {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/alerts';
        } else
            return osc_base_url() . 'user.php?action=alerts';
    }


/*

function osc_createProfileURL() {
    if (osc_rewrite_enabled()) {
        return osc_base_url() . 'user/profile';
    } else
        return osc_base_url() . 'user.php?action=profile';
}

function osc_createUserItemsURL() {
    if (osc_rewrite_enabled()) {
        return osc_base_url() . 'user/items';
    } else
        return osc_base_url() . 'user.php?action=items';
}

function osc_createUserOptionsURL($option = null) {
    if (osc_rewrite_enabled()) {
        if($option != null) {
            return osc_base_url() . 'user/options/'.$option;
        } else {
            return osc_base_url() . 'user/options';
        }
    } else {
        if($option != null) {
            return osc_base_url() . 'user.php?action=options&option='.$option;
        } else {
            return osc_base_url() . 'user.php?action=options';
        }
    }
}

function osc_createUserOptionsPostURL($option = null) {
    if (osc_rewrite_enabled()) {
        if($option != null) {
            return osc_base_url() . 'user/options_post/' . $option ;
        } else {
            return osc_base_url() . 'user/options_post';
        }
    } else {
        if($option != null) {
            return osc_base_url() . 'user.php?action=options_post&option=' . $option ;
        } else {
            return osc_base_url() . 'user.php?action=options_post' ;
        }
    }
}

function osc_create_url($params = null, $echo = false) {
    $path = '';
    if(!is_array($params)) {
        return '';
    }

    if(count($params) == 0) {
        return '';
    }

    if(!isset($params['file'])) {
        return '';
    }

    if (osc_rewrite_enabled()) {
        if($params['file'] == 'index') {
            $params['file'] = '';
            $path = osc_base_url() . $params['action'];
        } else {
            if(count($params) == 2 && isset($params['action'])) {
                $path = osc_base_url() . $params['file'] . "/" . $params['action'];
            } else {
                $path = osc_base_url() . $params['file'] . "?" . $params_string;
            }
        }
    } else {
        $params_string = "";
        foreach ($params as $k => $v) {
            if ($k != 'file') {
                $params_string .= $k . '=' . $v . '&';
            }
        }
        $params_string = preg_replace('/\&$/','',$params_string);
        $path = osc_base_url() . $params['file'] . ".php?" . $params_string;
    }

    if($echo) {
        echo $path;
        return '';
    }

    return $path;
}

function osc_createThumbnailURL($resource) {
    if(isset($resource['pk_i_id'])) {
        return sprintf(osc_base_url() . 'oc-content/uploads/%d_thumbnail.png', $resource['pk_i_id']) ;
    } else {
        return osc_theme_resource('images/no-image.png') ;
    }
}

function osc_createResourceURL($resource) {
    return sprintf(osc_base_url() . 'oc-content/uploads/%d.png', $resource['pk_i_id']) ;
}

function osc_item_post_url($cat = null) {
    if (!isset($cat) || !isset($cat['pk_i_id'])) {
        if (osc_rewrite_enabled()) {
            return osc_base_url() . 'item/new' ;
        } else {
            return sprintf(osc_base_url() . 'item.php?action=post') ;
        }
    } else {
        if (osc_rewrite_enabled()) {
            return osc_base_url() . 'item/new/' . $cat['pk_i_id'] ;
        } else {
            return sprintf(osc_base_url() . 'item.php?action=post&catId=%d', $cat['pk_i_id']) ;
        }
    }
}*/

/**
 * Create automatically the url of a category
 *
 * @param array $cat An array with the category information
 * @param bool $echo If you want to echo or not the path automatically
 * @return string If $echo is false, it returns the path, if not it return blank string
 */
/*function osc_search_category_url($cat, $echo = false) {
    $path = '';

    if (osc_rewrite_enabled()) {
        $cat = Category::newInstance()->hierarchy($cat['pk_i_id']) ;
        $sanitized_category = "" ;
        for ($i = count($cat); $i > 0; $i--) {
            $sanitized_category .= $cat[$i - 1]['s_slug'] . '/' ;
        }
        $path = osc_base_url() . $sanitized_category ;
    } else {
        $path = sprintf(osc_base_url() . 'search.php?sCategory=%d', $cat['pk_i_id']) ;
    }

    if($echo) {
        echo $path ;
        return '';
    }

    return $path ;
}*/

/*
function osc_createUserPublicDashboard($user = null) {
    if ($user != null || !isset($user['pk_i_id'])) {
        if (osc_rewrite_enabled()) {
            return osc_base_url() . 'user/'.$user['pk_i_id'] ;
        } else {
            return osc_base_url() . 'user.php?action=public&user='.$user['pk_i_id'] ;
        }
    }
}*/

/**
 * Prints the user's account menu
 *
 * @param array with options of the form array('name' => 'display name', 'url' => 'url of link')
 *
 * @return void
 */
/* function nav_user_menu($options = null) {
    if($options == null) {
        $options = array();
        $options[] = array('name' => __('Dashboard'), 'url' => osc_createUserAccountURL()) ;
        $options[] = array('name' => __('Manage your items'), 'url' => osc_createUserItemsURL()) ;
        $options[] = array('name' => __('Manage your alerts'), 'url' => osc_createUserAlertsURL()) ;
        $options[] = array('name' => __('My account'), 'url' => osc_createProfileURL()) ;
        $options[] = array('name' => __('Logout'), 'url' => osc_createLogoutURL()) ;
    }

    <script type="text/javascript">
        $(".user_menu > :first-child").addClass("first");
        $(".user_menu > :last-child").addClass("last");
    </script>
    <ul class="user_menu">

            $var_l = count($options) ;
            for($var_o=0;$var_o<$var_l;$var_o++) {
                echo '<li><a href="' . $options[$var_o]['url'] . '" >' . $options[$var_o]['name'] . '</a></li>' ;
            }

            osc_run_hook('user_menu');

    </ul>
} */


/**
 * Prints the aditional options to the menu
 *
 * @param array with options of the form array('name' => 'display name', 'url' => 'url of link')
 *
 * @return void
 */
/*function add_option_menu($option = null) {
    if($option!=null) {
        echo '<li><a href="' . $option['url'] . '" >' . $option['name'] . '</a></li>' ;
    }

}*/

    
?>