<?php

/**
 * @property int $id The list unique identifier
 * @property string $name The list name
 * @property bool $forced If the list must be added to every new subscriber
 * @property int $status When and how the list is visible to the subscriber - see constants
 * @property bool $checked If it must be pre-checked on subscription form
 * @property array $languages The list of language used to pre-assign this list
 */
class TNP_List {

    const STATUS_PRIVATE = 0;
    const STATUS_PUBLIC = 1;

    var $id;
    var $name;
    var $status;
    var $forced;
    var $languages;

    function is_private() {
        return $this->status == self::STATUS_PRIVATE;
    }

    function is_public() {
        return $this->status == self::STATUS_PUBLIC;
    }

    static function build($options) {
        $lists = [];
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if (empty($options['list_' . $i])) {
                continue;
            }

            $prefix = 'list_' . $i;
            $list = new TNP_List();
            $list->id = $i;
            $list->name = $options[$prefix];
            $list->forced = !empty($options[$prefix . '_forced']);
            $list->status = empty($options[$prefix . '_status']) ? TNP_List::STATUS_PRIVATE : TNP_List::STATUS_PUBLIC;
            if (empty($options[$prefix . '_languages'])) {
                $list->languages = [];
            } else {
                $list->languages = $options[$prefix . '_languages'];
            }

            $lists['' . $list->id] = $list;
        }
        return $lists;
    }

}

class TNP_Media {

    var $id;
    var $url;
    var $width;
    var $height;
    var $alt;
    var $link;
    var $align = 'center';

    /** Sets the width recalculating the height */
    public function set_width($width) {
        $width = (int) $width;
        if (empty($width))
            return;
        if ($this->width < $width)
            return;
        $this->height = floor(($width / $this->width) * $this->height);
        $this->width = $width;
    }

    /** Sets the height recalculating the width */
    public function set_height($height) {
        $height = (int) $height;
        $this->width = floor(($height / $this->height) * $this->width);
        $this->height = $height;
    }

}

/**
 * @property int $id The list unique identifier
 * @property string $name The list name
 * @property int $status When and how the list is visible to the subscriber - see constants
 * @property string $type Field type: text or select
 * @property array $options Field options (usually the select items)
 */
class TNP_Profile {

    const STATUS_PRIVATE = 0;
    const STATUS_PUBLIC = 1;
    const TYPE_TEXT = 'text';
    const TYPE_SELECT = 'select';

    public $id;
    public $name;
    public $status;
    public $type;
    public $options;
    public $placeholder;
    public $rule;

    public function __construct($id = 0, $name = '', $status = '', $type = '', $options = [], $placeholder = '', $rule = '') {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->type = $type;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->rule = $rule;
    }

    function is_select() {
        return $this->type == self::TYPE_SELECT;
    }

    function is_text() {
        return $this->type == self::TYPE_TEXT;
    }

    function is_required() {
        return $this->rule == 1;
    }

    function is_private() {
        return $this->status == self::STATUS_PRIVATE;
    }
    
    function is_public() {
        // To be compatibile with old statuses (2, 3)
        return $this->status != self::STATUS_PRIVATE;
    }

    function show_on_profile() {
        return $this->status == self::STATUS_PROFILE_ONLY || $this->status == self::STATUS_PUBLIC;
    }

}

/**
 * Represents the set of data collected by a subscription interface (form, API, ...). Only a valid
 * email is mandatory.
 */
class TNP_Subscription_Data {

    var $email = null;
    var $name = null;
    var $surname = null;
    var $sex = null;
    var $language = null;
    var $referrer = null;
    var $http_referrer = null;
    var $ip = null;
    var $country = null;
    var $region = null;
    var $city = null;
    var $flow = '';

    /**
     * Associative array id=>value of lists chosen by the subscriber. A list can be set to
     * 0 meaning the subscriber does not want to be in that list.
     * @var array
     */
    var $lists = [];
    var $profiles = [];

    function merge_in($subscriber) {
        if (!$subscriber)
            $subscriber = new TNP_User();
        if (!empty($this->email))
            $subscriber->email = $this->email;
        if (!empty($this->name))
            $subscriber->name = $this->name;
        if (!empty($this->surname))
            $subscriber->surname = $this->surname;
        if (!empty($this->sex))
            $subscriber->sex = $this->sex;
        if (!empty($this->language))
            $subscriber->language = $this->language;
        if (!empty($this->ip))
            $subscriber->ip = $this->ip;
        if (!empty($this->referrer))
            $subscriber->referrer = $this->referrer;
        if (!empty($this->http_referrer))
            $subscriber->http_referrer = $this->http_referrer;
        if (!empty($this->country))
            $subscriber->country = $this->country;
        if (!empty($this->region))
            $subscriber->region = $this->region;
        if (!empty($this->city))
            $subscriber->city = $this->city;
        if (!empty($this->source))
            $subscriber->source = $this->source;


        foreach ($this->lists as $id => $value) {
            $key = 'list_' . $id;
            $subscriber->$key = $value;
        }

        // Profile
        foreach ($this->profiles as $id => $value) {
            $key = 'profile_' . $id;
            $subscriber->$key = $value;
        }
    }

    /** Sets to active a set of lists. Accepts incorrect data (and ignores it).
     * 
     * @param array $list_ids Array of list IDs
     */
    function add_lists($list_ids) {
        if (empty($list_ids) || !is_array($list_ids))
            return;
        foreach ($list_ids as $list_id) {
            $list_id = (int) $list_id;
            if ($list_id <= 0 || $list_id > NEWSLETTER_LIST_MAX)
                continue;
            $this->lists[$list_id] = 1;
        }
    }

}

/**
 * Represents a subscription request with the subscriber data and actions to be taken by
 * the subscription engine (spam check, notifications, ...).
 */
class TNP_Subscription {

    const EXISTING_ERROR = 1;
    const EXISTING_MERGE = 0;
    const EXISTING_SINGLE_OPTIN = 2;

    /**
     * Subscriber's data following the syntax of the TNP_User
     * @var TNP_Subscription_Data
     */
    var $data;
    var $spamcheck = true;
    // The optin to use, empty for the plugin default. It's a string to facilitate the use by addons (which have a selector for the desired
    // optin as empty (for default), 'single' or 'double'.
    var $optin = null;
    // What to do with an existing subscriber???
    var $if_exists = self::EXISTING_MERGE;

    /**
     * Determines if the welcome or activation email should be sent. Note: sometime an activation email is sent disregarding
     * this setting.
     * @var boolean
     */
    var $send_emails = true;

    public function __construct() {
        $this->data = new TNP_Subscription_Data();
    }

    public function set_optin($optin) {
        if (empty($optin))
            return;
        if ($optin != 'single' && $optin != 'double') {
            return;
        }
        $this->optin = $optin;
    }

    public function is_single_optin() {
        return $this->optin == 'single';
    }

    public function is_double_optin() {
        return $this->optin == 'double';
    }

}

/**
 * @property int $id The subscriber unique identifier
 * @property string $email The subscriber email
 * @property string $name The subscriber name or first name
 * @property string $surname The subscriber last name
 * @property string $status The subscriber status
 * @property string $language The subscriber language code 2 chars lowercase
 * @property string $token The subscriber secret token
 * @property string $country The subscriber country code 2 chars uppercase
 */
class TNP_User {

    const STATUS_CONFIRMED = 'C';
    const STATUS_NOT_CONFIRMED = 'S';
    const STATUS_UNSUBSCRIBED = 'U';
    const STATUS_BOUNCED = 'B';
    const STATUS_COMPLAINED = 'P';

    var $ip = '';

    public static function get_status_label($status) {
        switch ($status) {
            case self::STATUS_NOT_CONFIRMED: return __('Not confirmed', 'newsletter');
                break;
            case self::STATUS_CONFIRMED: return __('Confirmed', 'newsletter');
                break;
            case self::STATUS_UNSUBSCRIBED: return __('Unsubscribed', 'newsletter');
                break;
            case self::STATUS_BOUNCED: return __('Bounced', 'newsletter');
                break;
            case self::STATUS_COMPLAINED: return __('Complained', 'newsletter');
                break;
            default:
                return __('Unknown', 'newsletter');
        }
    }

    public static function is_status_valid($status) {
        switch ($status) {
            case self::STATUS_CONFIRMED: return true;
            case self::STATUS_NOT_CONFIRMED: return true;
            case self::STATUS_UNSUBSCRIBED: return true;
            case self::STATUS_BOUNCED: return true;
            case self::STATUS_COMPLAINED: return true;
            default: return false;
        }
    }

}

/**
 * @property int $id The email unique identifier
 * @property string $subject The email subject
 * @property string $message The email html message
 * @property int $track Check if the email stats should be active
 * @property array $options Email options
 * @property int $total Total emails to send
 * @property int $sent Total sent emails by now
 * @property int $open_count Total opened emails
 * @property int $click_count Total clicked emails
 * */
class TNP_Email {

    const STATUS_DRAFT = 'new';
    const STATUS_SENT = 'sent';
    const STATUS_SENDING = 'sending';
    const STATUS_PAUSED = 'paused';
    const STATUS_ERROR = 'error';

}
