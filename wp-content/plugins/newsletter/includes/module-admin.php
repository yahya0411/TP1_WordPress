<?php

defined('ABSPATH') || exit;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

class NewsletterModuleAdmin extends NewsletterModuleBase {

    static $is_admin_page = false;

    /**
     * @var NewsletterThemes
     */
    var $themes;
    var $cache = [];

    function __construct($module) {
        parent::__construct($module, new NewsletterLogger($module . '-admin'));
    }

    function is_admin_page() {
        return self::$is_admin_page;
    }

    function first_install() {
        $this->logger->debug('First install');
    }

    function get_db_options($sub, $language = '') {
        if (!$sub)
            $sub = $this->module;
        return $this->get_option_array($this->get_prefix($sub, $language));
    }

    /**
     * Returns the main options.
     * 
     * @param string $sub Submodule, if empty the options of the main module are returned.
     * @return type
     */
    function get_main_options($sub = '') {
        if (!$sub)
            $sub = $this->module;
        return $this->get_option_array($this->get_prefix($sub, ''));
    }

    /**
     * Returns the options for the current language (if not specified) merged only with the
     * default options.
     * 
     * @param string $sub Submodule
     * @param string $language 
     * @return array
     */
    function get_options($sub = '', $language = '') {
        if (!$sub)
            $sub = $this->module;
        $options = array_merge($this->get_default_options($sub), $this->get_option_array($this->get_prefix($sub, $language)));
        return $options;
    }

    /**
     * Get the option value for a specifc key using the current language.
     * 
     * @param string $key
     * @param string $sub
     * @return mixed Returns null if the option is not found
     */
    function get_option($key, $sub = '') {
        if (!$sub)
            $sub = $this->module;
        if (isset($this->cache[$sub . self::$language][$key])) {
            return $this->cache[$sub . self::$language][$key];
        }

        $options = $this->get_options($sub);
        if (!isset($options[$key])) {
            return null;
        }
        return $options[$key];
    }

    function reset_options($sub = '', $language = '') {
        update_option($this->get_prefix($sub, $language), $this->get_default_options($sub));
        return $this->get_options($sub, $language);
    }

    /**
     * Saves the module options (or eventually a subset names as per parameter $sub). $options
     * should be an array (even if it can work with non array options.
     * The internal module options variable IS initialized with those new options only for the main
     * options (empty $sub parameter).
     * If the options contain a "theme" value, the theme-related options contained are saved as well
     * (used by some modules).
     *
     * @param array $options
     * @param string $sub
     */
    function save_options($options, $sub = '', $language = '') {
        update_option($this->get_prefix($sub, $language), $options, true);
        if (empty($sub) && empty($language)) {
            if (isset($this->themes) && isset($options['theme'])) {
                $this->themes->save_options($options['theme'], $options);
            }
        }
    }

    /**
     * Saves the main options for a submodule.
     * 
     * @param type $options
     * @param type $sub
     * @param type $autoload
     */
    function save_main_options($options, $sub = '') {
        $this->cache = [];
        $this->save_options($options, $sub, '');
    }

    function delete_options($sub = '', $language = '') {
        $this->cache = [];
        delete_option($this->get_prefix($sub, $language));
    }

    function merge_options($options, $sub = '', $language = '') {
        if (!is_array($options)) {
            $options = array();
        }
        $old_options = $this->get_options($sub, $language);
        $this->save_options(array_merge($old_options, $options), $sub, null, $language);
    }

    function admin_menu() {
        
    }

    function add_menu_page($page, $title, $position = null) {
        if (!$this->is_allowed()) {
            return;
        }

        $name = 'newsletter_' . $this->module . '_' . $page;
        add_submenu_page('newsletter_main_index', $title, $title, 'exist', $name, [$this, 'menu_page'], $position);
    }

    function add_admin_page($page, $title) {
        if (!$this->is_allowed()) {
            return;
        }
        $name = 'newsletter_' . $this->module . '_' . $page;
        add_submenu_page('', $title, $title, 'exist', $name, array($this, 'menu_page'));
    }

    /**
     * Shows a module admin page.
     * @global type $plugin_page
     * @global type $newsletter
     * @global wpdb $wpdb
     */
    function menu_page() {
        global $plugin_page, $newsletter, $wpdb;

        //$this->set_language($this->get_current_language());

        $parts = explode('_', $plugin_page, 3);
        $module = $this->sanitize_file_name($parts[1]);
        $page = $this->sanitize_file_name($parts[2]);
        $page = str_replace('_', '-', $page);

        $logger = $this->logger;
        $is_all_languages = empty(self::$language); // Deprecated
        $controls = new NewsletterControls();
        $language = $this->language();
        $is_multilanguage = $this->is_multilanguage();

        $file = NEWSLETTER_DIR . '/' . $module . '/' . $page . '.php';

        require $file;
    }

    /**
     * Prints out a notice to be used on top of configuration panel tabs 
     * saying the user is configuring the options for a specific language and not
     * the main ones.
     */
    function language_notice() {

        if (!$this->language() || !$this->is_multilanguage()) {
            return;
        }
        echo '<div class="tnpc-language-notice">';
        echo 'You are configuring the language <strong>' . $this->get_language_label($this->language()) . '</strong>. Switch to "all languages" to see all options.';
        echo '</div>';
    }

    function get_admin_page_url($page) {
        return admin_url('admin.php') . '?page=newsletter_' . $this->module . '_' . $page;
    }

    function get_last_run($sub = '') {
        return get_option($this->get_prefix($sub) . '_last_run', 0);
    }

    /**
     * Sums $delta seconds to the last run time.
     * @param int $delta Seconds
     * @param string $sub Sub module name (default empty)
     */
    function add_to_last_run($delta, $sub = '') {
        $time = $this->get_last_run($sub);
        $this->save_last_run($time + $delta, $sub);
    }

    function delete_transient($name = '') {
        delete_transient($this->get_prefix() . '_' . $name);
    }

    static function format_date($time) {
        if (empty($time)) {
            return '-';
        }
        return gmdate(get_option('date_format') . ' ' . get_option('time_format'), $time + get_option('gmt_offset') * 3600);
    }

    static function format_time_delta($delta) {
        $days = floor($delta / (3600 * 24));
        $hours = floor(($delta % (3600 * 24)) / 3600);
        $minutes = floor(($delta % 3600) / 60);
        $seconds = floor(($delta % 60));
        $buffer = $days . ' days, ' . $hours . ' hours, ' . $minutes . ' minutes, ' . $seconds . ' seconds';
        return $buffer;
    }

    /**
     * Formats a scheduler returned "next execution" time, managing negative or false values. Many times
     * used in conjuction with "last run".
     *
     * @param string $name The scheduler name
     * @return string
     */
    static function format_scheduler_time($name) {
        $time = wp_next_scheduled($name);
        if ($time === false) {
            return 'No next run scheduled';
        }
        $delta = $time - time();
        // If less 10 minutes late it can be a cron problem but now it is working
        if ($delta < 0 && $delta > -600) {
            return 'Probably running now';
        } else if ($delta <= -600) {
            return 'It seems the cron system is not working. Reload the page to see if this message change.';
        }
        return 'Runs in ' . self::format_time_delta($delta);
    }

    static function date($time = null, $now = false, $left = false) {
        if (is_null($time)) {
            $time = time();
        }
        if ($time == false) {
            $buffer = 'none';
        } else {
            $buffer = gmdate(get_option('date_format') . ' ' . get_option('time_format'), $time + get_option('gmt_offset') * 3600);
        }
        if ($now) {
            $buffer .= ' (now: ' . gmdate(get_option('date_format') . ' ' .
                            get_option('time_format'), time() + get_option('gmt_offset') * 3600);
            $buffer .= ')';
        }
        if ($left) {
            $buffer .= ', ' . gmdate('H:i:s', $time - time()) . ' left';
        }
        return $buffer;
    }

    /**
     * Return an array of array with on first element the array of recent post and on second element the array
     * of old posts.
     *
     * @param array $posts
     * @param int $time
     */
    static function split_posts(&$posts, $time = 0) {
        if ($time < 0) {
            return array_chunk($posts, ceil(count($posts) / 2));
        }

        $result = array(array(), array());

        if (empty($posts))
            return $result;

        foreach ($posts as &$post) {
            if (self::is_post_old($post, $time))
                $result[1][] = $post;
            else
                $result[0][] = $post;
        }
        return $result;
    }

    static function is_post_old(&$post, $time = 0) {
        return self::m2t($post->post_date_gmt) <= $time;
    }

    static function get_post_image($post_id = null, $size = 'thumbnail', $alternative = null) {
        global $post;

        if (empty($post_id))
            $post_id = $post->ID;
        if (empty($post_id))
            return $alternative;

        $image_id = function_exists('get_post_thumbnail_id') ? get_post_thumbnail_id($post_id) : false;
        if ($image_id) {
            $image = wp_get_attachment_image_src($image_id, $size);
            return $image[0];
        } else {
            $attachments = get_children(array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID'));

            if (empty($attachments)) {
                return $alternative;
            }

            foreach ($attachments as $id => $attachment) {
                $image = wp_get_attachment_image_src($id, $size);
                return $image[0];
            }
        }
    }

    function get_email_field($id, $field_name) {
        return $this->store->get_field(NEWSLETTER_EMAILS_TABLE, $id, $field_name);
    }

    /**
     * Accepts a user ID or a TNP_User object. Does not check if the user really exists.
     *
     * @param type $user
     */
    function get_user_edit_url($user) {
        $id = $this->to_int_id($user);
        return admin_url('admin.php') . '?page=newsletter_users_edit&id=' . $id;
    }

    function get_user_status_label($user, $html = false) {
        if (is_string($user)) {
            $x = $user;
            $user = new stdClass();
            $user->status = $x;
        }
        if (!$html) {
            return TNP_User::get_status_label($user->status);
        }

        $label = TNP_User::get_status_label($user->status);
        $class = 'unknown';
        switch ($user->status) {
            case TNP_User::STATUS_NOT_CONFIRMED: $class = 'not-confirmed';
                break;
            case TNP_User::STATUS_CONFIRMED: $class = 'confirmed';
                break;
            case TNP_User::STATUS_UNSUBSCRIBED: $class = 'unsubscribed';
                break;
            case TNP_User::STATUS_BOUNCED: $class = 'bounced';
                break;
            case TNP_User::STATUS_COMPLAINED: $class = 'complained';
                break;
        }
        return '<span class="tnp-status tnp-user-status tnp-user-status--' . $class . '">' . esc_html($label) . '</span>';
    }

    /**
     * Managed by WP Users Addon
     * @deprecated since version 7.6.7
     * @return TNP_User
     */
    function get_user_from_logged_in_user() {
        if (is_user_logged_in()) {
            return $this->get_user_by_wp_user_id(get_current_user_id());
        }
        return null;
    }

    function get_user_count($refresh = false) {
        global $wpdb;
        $user_count = get_transient('newsletter_user_count');
        if ($user_count === false || $refresh) {
            $user_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C'");
            set_transient('newsletter_user_count', $user_count, DAY_IN_SECONDS);
        }
        return $user_count;
    }

    function get_profile($id) {
        return $this->get_customfield($id);
    }

    function get_profiles() {
        return $this->get_customfields();
    }

    /**
     * @param string $language The language for the list labels (it does not affect the lists returned)
     * @return TNP_Profile[]
     */
    function get_customfields() {

        static $customfields = null;

        if (is_null($customfields)) {
            $customfields = [];
            $options = $this->get_main_options('customfields');
            for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
                $prefix = 'profile_' . $i;
                if (!empty($options[$prefix])) {
                    $field = new TNP_Profile($i, $options[$prefix]);
                    $field->type = $options[$prefix . '_type'];
                    $items = array_map('trim', explode(',', $options[$prefix . '_options']));
                    $items = array_combine($items, $items);
                    $field->options = $items;
                    $field->placeholder = $options[$prefix . '_placeholder'];
                    $field->rule = $options[$prefix . '_rules'];
                    $field->status = (int) $options[$prefix . '_status'];
                    $customfields['' . $i] = $field;
                }
            }
        }
        return $customfields;
    }

    function get_customfield($id) {
        $customfields = $this->get_customfields();
        if (isset($customfields[$id])) {
            return $customfields[$id];
        } else {
            return null;
        }
    }

    function get_customfields_public() {
        static $customfields = null;
        if (is_null($customfields)) {
            $customfields = [];
            foreach ($this->get_customfields() as $customfield) {
                if ($customfield->is_public()) {
                    $customfields['' . $customfield->id] = $customfield;
                }
            }
        }

        return $customfields;
    }

    /**
     * Returns ALL custom fields, even if not configured.
     * 
     * @return \TNP_Profile[]
     */
    function get_all_customfields() {
        $options = $this->get_options('customfields');
        $customfields = [];

        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            if (empty($options['profile_' . $i])) {
                $field = new TNP_Profile($i, '');
                $field->type = TNP_Profile::TYPE_TEXT;
            } else {
                $field = new TNP_Profile($i, $options['profile_' . $i]);
                $field->type = $options['profile_' . $i . '_type'];
            }
            $customfields['' . $i] = $field;
        }

        return $customfields;
    }

    /**
     * Returns a list of TNP_Profile which are public.
     *
     * @staticvar array $profiles
     * @param string $language
     * @return TNP_Profile[]
     */
    function get_profiles_public() {
        return $this->get_customfields_public();
    }   

    /**
     * Returns the list object or null if not found.
     *
     * @param int $id
     * @return TNP_List
     */
    function get_list($id) {
        $lists = $this->get_lists();
        if (!isset($lists['' . $id])) {
            return null;
        }

        return $lists['' . $id];
    }

    function update_user_ip($user, $ip) {
        global $wpdb;
// Only if changed
        $r = $this->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set ip=%s, geo=0 where ip<>%s and id=%d limit 1", $ip, $ip, $user->id));
    }

    /**
     * Finds single style blocks and adds a style attribute to every HTML tag with a class exactly matching the rules in the style
     * block. HTML tags can use the attribute "inline-class" to exact match a style rules if they need a composite class definition.
     *
     * @param string $content
     * @param boolean $strip_style_blocks
     * @return string
     */
    function inline_css($content, $strip_style_blocks = false) {
        $matches = array();
        // "s" skips line breaks
        $styles = preg_match('|<style>(.*?)</style>|s', $content, $matches);
        if (isset($matches[1])) {
            $style = str_replace(array("\n", "\r"), '', $matches[1]);
            $rules = array();
            preg_match_all('|\s*\.(.*?)\{(.*?)\}\s*|s', $style, $rules);
            for ($i = 0; $i < count($rules[1]); $i++) {
                $class = trim($rules[1][$i]);
                $value = trim($rules[2][$i]);
                $value = preg_replace('|\s+|', ' ', $value);
                //$content = str_replace(' class="' . $class . '"', ' class="' . $class . '" style="' . $value . '"', $content);
                $content = str_replace(' inline-class="' . $class . '"', ' style="' . $value . '"', $content);
            }
        }

        if ($strip_style_blocks) {
            return trim(preg_replace('|<style>.*?</style>|s', '', $content));
        } else {
            return $content;
        }
    }

    /**
     * Returns a list of users marked as "test user".
     * @return TNP_User[]
     */
    function get_test_users() {
        return $this->store->get_all(NEWSLETTER_USERS_TABLE, "where test=1 and status in ('C', 'S')");
    }

    /**
     * Add to a destination URL the parameters to identify the user, the email and to show
     * an alert message, if required. The parameters are then managed by the [newsletter] shortcode.
     *
     * @param string $url If empty the standard newsletter page URL is used (usually it is empty, but sometime a custom URL has been specified)
     * @param string $message_key The message identifier
     * @param TNP_User|int $user
     * @param TNP_Email|int $email
     * @param string $alert An optional alter message to be shown. Does not work with custom URLs
     * @return string The final URL with parameters
     */
    function build_message_url($url = '', $message_key = '', $user = null, $email = null, $alert = '') {
        $params = 'nm=' . urlencode($message_key);
        $language = '';
        if ($user) {
            if (!is_object($user)) {
                $user = $this->get_user($user);
            }
            if ($message_key == 'confirmation') {
                $params .= '&nk=' . urlencode($this->get_user_key($user, 'preconfirm'));
            } else {
                $params .= '&nk=' . urlencode($this->get_user_key($user));
            }

            $language = $this->get_user_language($user);
        }

        if ($email) {
            if (!is_object($email)) {
                $email = $this->get_email($email);
            }
            $params .= '&nek=' . urlencode($this->get_email_key($email));
        }

        if ($alert) {
            $params .= '&alert=' . urlencode($alert);
        }

        if (empty($url)) {
            $url = Newsletter::instance()->get_newsletter_page_url($language);
        }

        return self::add_qs($url, $params, false);
    }

    /**
     * Builds a standard Newsletter action URL for the specified action.
     *
     * @param string $action
     * @param TNP_User $user
     * @param TNP_Email $email
     * @return string
     */
    function build_action_url($action, $user = null, $email = null) {
        $url = $this->add_qs($this->get_home_url(), 'na=' . urlencode($action));
        //$url = $this->add_qs(admin_url('admin-ajax.php'), 'action=newsletter&na=' . urlencode($action));
        if ($user) {
            $url .= '&nk=' . urlencode($this->get_user_key($user));
        }
        if ($email) {
            $url .= '&nek=' . urlencode($this->get_email_key($email));
        }
        return $url;
    }

    function get_subscribe_url() {
        return $this->build_action_url('s');
    }

    /**
     * Returns the user language IF there is a supported mutilanguage plugin installed.
     * @param TNP_User $user
     * @return string Language code or empty
     */
    function get_user_language($user) {
        if ($user && $this->is_multilanguage()) {
            return $user->language;
        }
        return '';
    }

    function replace_date($text) {
        $text = str_replace('{date}', date_i18n(get_option('date_format')), $text);

// Date processing
        $x = 0;
        while (($x = strpos($text, '{date_', $x)) !== false) {
            $y = strpos($text, '}', $x);
            if ($y === false)
                continue;
            $f = substr($text, $x + 6, $y - $x - 6);
            $text = substr($text, 0, $x) . date_i18n($f) . substr($text, $y + 1);
        }
        return $text;
    }

    function replace_url($text, $tag, $url) {
        static $home = false;
        if (!$home) {
            $home = trailingslashit(home_url());
        }
        $tag_lower = strtolower($tag);
        $text = str_replace('http://{' . $tag_lower . '}', $url, $text);
        $text = str_replace('https://{' . $tag_lower . '}', $url, $text);
        $text = str_replace($home . '{' . $tag_lower . '}', $url, $text);
        $text = str_replace($home . '%7B' . $tag_lower . '%7D', $url, $text);
        $text = str_replace('{' . $tag_lower . '}', $url, $text);
        $text = str_replace('%7B' . $tag_lower . '%7D', $url, $text);

        $url_encoded = urlencode($url);
        $text = str_replace('%7B' . $tag_lower . '_encoded%7D', $url_encoded, $text);
        $text = str_replace('{' . $tag_lower . '_encoded}', $url_encoded, $text);

// for compatibility
        $text = str_replace($home . $tag, $url, $text);

        return $text;
    }

    static function extract_body($html) {
        $x = stripos($html, '<body');
        if ($x !== false) {
            $x = strpos($html, '>', $x);
            $y = strpos($html, '</body>');
            return substr($html, $x + 1, $y - $x - 1);
        } else {
            return $html;
        }
    }

    /** Returns a percentage as string */
    static function percent($value, $total) {
        if ($total == 0)
            return '-';
        return sprintf("%.2f", $value / $total * 100) . '%';
    }

    /** Returns a percentage as integer value */
    static function percentValue($value, $total) {
        if ($total == 0)
            return 0;
        return round($value / $total * 100);
    }

    static function get_signature($text) {
        $key = NewsletterStatistics::instance()->options['key'];
        return md5($text . $key);
    }

    static function check_signature($text, $signature) {
        if (empty($signature)) {
            return false;
        }
        $key = NewsletterStatistics::instance()->options['key'];
        return md5($text . $key) === $signature;
    }

    static function get_home_url() {
        static $url = false;
        if (!$url) {
            $url = home_url('/');
        }
        return $url;
    }

    function set_current_language($language) {
        self::$current_language = $language;
    }

    function get_default_language() {
        if (class_exists('SitePress')) {
            return $current_language = apply_filters('wpml_current_language', '');
        } else if (function_exists('pll_default_language')) {
            return pll_default_language();
        } else if (class_exists('TRP_Translate_Press')) {
// TODO: Find the default language
        }
        return '';
    }

    function is_all_languages() {
        return $this->get_current_language() == '';
    }

    function is_default_language() {
        return $this->get_current_language() == $this->get_default_language();
    }

    /**
     * Returns an array of languages with key the language code and value the language name.
     * An empty array is returned if no language is available.
     */
    function get_languages() {

        $language_options = [];

        if (class_exists('SitePress')) {
            $languages = apply_filters('wpml_active_languages', null, ['skip_missing' => 0]);
            foreach ($languages as $language) {
                $language_options[$language['language_code']] = $language['translated_name'];
            }

            return $language_options;
        } else if (function_exists('pll_languages_list')) {
            $languages = pll_languages_list(['fields' => '']);
            foreach ($languages as $data) {
                $language_options[$data->slug] = $data->name;
            }


            return $language_options;
        }

        return apply_filters('newsletter_languages', $language_options);
    }

    function get_language_label($language) {
        $languages = $this->get_languages();
        if (isset($languages[$language])) {
            return $languages[$language];
        }
        return '';
    }

    function clean_stats_table() {
        global $wpdb;
        $this->logger->info('Cleaning up stats table');
        $this->query("delete s from `{$wpdb->prefix}newsletter_stats` s left join `{$wpdb->prefix}newsletter` u on s.user_id=u.id where u.id is null");
        $this->query("delete s from `{$wpdb->prefix}newsletter_stats` s left join `{$wpdb->prefix}newsletter_emails` e on s.email_id=e.id where e.id is null");
    }

    function clean_sent_table() {
        global $wpdb;
        $this->logger->info('Cleaning up sent table');
        $this->query("delete s from `{$wpdb->prefix}newsletter_sent` s left join `{$wpdb->prefix}newsletter` u on s.user_id=u.id where u.id is null");
        $this->query("delete s from `{$wpdb->prefix}newsletter_sent` s left join `{$wpdb->prefix}newsletter_emails` e on s.email_id=e.id where e.id is null");
    }

}
